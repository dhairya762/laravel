<?php

namespace App\Http\Controllers;

use App\Models\SalesMan;
use App\Models\SalesManProductPrice;
use App\Models\SalesManProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class SalesManController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $show = session('show');
        if (!$show) {
            $show = 0;
        }
        $search = $request->input('search');
        if ($search) {
            $salesman = SalesMan::where('name', 'LIKE', $search)->first();
            Session(['search' => $search]);
            Session(['salesman_id' => $salesman->id]);
            Session(['show' => 0]);
            $salesman = SalesMan::where('name', 'LIKE', $search)->get();
        } else {
            if (session('search')) {
                $salesman = SalesMan::where('name', '=', session('search'))->get();
            } else {
                $salesman = SalesMan::all();
            }
            if (!$salesman) {
                $salesman = NULL;
            }
        }
        $id = session('salesman_id');
        if (!$id) {
            $id = null;
        }
        $currentSalesMan = SalesMan::find($id);
        if (!$currentSalesMan) {
            $currentSalesMan = null;
        }
        if ($id) {
            $query = "SELECT salesman_product.sku,
            salesman_product.id, 
            salesman_product_price.price  AS spp, 
            salesman_product_price.discount, 
            salesman_product_price.salesman_id, 
            salesman_product_price.salesman_product_id, 
            salesman_product.price 
        FROM salesman_product
        LEFT JOIN `salesman_product_price`
            ON salesman_product.id = salesman_product_price.salesman_product_id
            AND salesman_product_price.salesman_id= $id";
            $products = DB::select($query);
        } else {
            $products = SalesManProduct::all();
        }
        $view = view('salesman.list', compact('currentSalesMan','salesman', 'products', 'id'))->render();
        $response = [
            'element' => [
                [
                    'success' => 'success',
                    'name' => 'laravel',
                    'selector' => '#content',
                    'html' => $view
                ]
            ]
        ];

        header('content-type:application/json');
        echo json_encode($response);
        // die;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $name = $request->search;
        $salesMan = SalesMan::where('name', '=', $name)->first();
        if ($salesMan) {
            return redirect('salesman')->with('error', 'Salesman Name already exist.');
        }
        $salesMan = SalesMan::insert(['name' => $name]);
        session(['show' => 0]);
        return redirect('salesman')->with('success', 'Salesman Inserted SuccessFully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SalesMan  $salesMan
     * @return \Illuminate\Http\Response
     */
    public function show(SalesMan $salesMan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SalesMan  $salesMan
     * @return \Illuminate\Http\Response
     */
    public function edit(SalesMan $salesMan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SalesMan  $salesMan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SalesMan $salesMan, $id)
    {
        $tmpPrice = [];
        $price = $request->input('sprice');
        $discount = $request->input('sdiscount');
        if ($price) {
            foreach ($price as $key1 => $value1) {
                $product = SalesManProduct::find($key1);
                if ($value1 >= $product->price) {
                    $salesman_product_price = SalesManProductPrice::where([['salesman_id', '=', $id], ['salesman_product_id', '=', $key1]])->first();
                    if ($salesman_product_price) {
                        $salesman_product_price->price = $value1;
                        $salesman_product_price->save();
                    } else {
                        $salesman_product_price = new SalesmanProductPrice;
                        $salesman_product_price->price = $value1;
                        $salesman_product_price->salesman_product_id = $key1;
                        $salesman_product_price->salesman_id = $id;
                        $salesman_product_price->save();
                    }
                } else {
                    array_push($tmpPrice, $key1);
                }
            }
            if ($tmpPrice) {
                return redirect('salesman', compact('tmpPrice')); //->with('success', 'SalesmanProductPrice Must Be Greater Then Price.');
            }
        }
        if ($discount) {
            foreach ($discount as $key2 => $value2) {
                $product = SalesManProduct::find($key2);
                if ($value2 >= 0) {
                    $salesman_product_price = SalesManProductPrice::where([['salesman_id', '=', $id], ['salesman_product_id', '=', $key2]])->first();
                    $salesman_product_price->discount = $value2;
                    $salesman_product_price->save();
                }
            }
        }
        // session(['show' => 0]);
        return redirect('salesman')->with('success', 'SalesmanProductPrice Updated SuccessFully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SalesMan  $salesMan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $salesman = SalesMan::find($id);
        $salesman->delete();
        // session(['show' => 0]);
        return redirect('salesman')->with('success', 'Salesman Deleted SuccessFully.');
    }

    public function salesManId(Request $request, $id)
    {
        session(['salesman_id' => $id]);
        session(['show' => 1]);
        return redirect('salesman');
    }

    public function product(Request $request)
    {
        $products = SalesManProduct::all();
        $postData = $request->salesman_product;
        foreach ($products as $key => $value) {
            if ($value->sku == $postData['sku']) {
                return redirect('salesman')->with('error', 'Sku Must be Unique.');
            }
        }
        $product = SalesManProduct::insert($postData);
        return redirect('salesman')->with('success', 'SalesManProduct Inserted SuccessFully.');
    }

    public function clearAction(Request $request)
    {
        $request->session()->forget('search');
        session(['show' => 0]);
        return redirect('salesman');
    }
}
