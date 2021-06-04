<?php

namespace App\Http\Controllers;

use App\Models\Shipping;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $page_no = null)
    {
        if (!$page_no) {
            $page_no = 1;
        }
        $current_page = $page_no;
        $recordsPerPage = $request->records_per_page;
        if ($recordsPerPage) {
            session(['paginate' => $recordsPerPage]);
        }
        if ($current_page == 1) {
            $recordsPerPage = session('paginate');
            if (!$recordsPerPage) {
                $recordsPerPage = 1;
            }
            session(['paginate' => $recordsPerPage]);
        }
        $count = Shipping::count();
        $limit = session('paginate');
        $offset = ($current_page - 1) * $limit;
        $allShippings = Shipping::all();
        $shippings = Shipping::orderBy('id', 'DESC')->offset($offset)->limit($limit)->get();

        if ($limit > 0) {
            $totalPage = ceil($count / $limit);
        } else {
            $totalPage = 0;
        }
        $view = view('shipping.list', compact('totalPage', 'limit', 'offset', 'allShippings', 'recordsPerPage', 'shippings'))->render();
        $response = [
            'element' => [
                [
                    'selector' => '#content',
                    'html' => $view
                ]
            ]
        ];
        header('content-type:application/json');
        echo json_encode($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $shipping = Shipping::find($id);
        $view = view('shipping.add', compact('shipping', 'id'))->render();
        $response = [
            'element' => [
                [
                    'selector' => '#content',
                    'html' => $view
                ]
            ]
        ];
        header('content-type:application/json');
        echo json_encode($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $postData = $request->shipping;
        
        if (!$postData['name']) {
            return redirect('shipping/add/' . $id )->with('error', 'Please insert data in Name field.');
        }
        if (!$postData['code']) {
            return redirect('shipping/add/' . $id )->with('error', 'Please insert data in Code field.');
        }
        if (!$postData['description']) {
            return redirect('shipping/add/' . $id )->with('error', 'Please insert data in Description field.');
        }
        if (!$postData['status']) {
            return redirect('shipping/add/' . $id )->with('error', 'Please insert data in Status field.');
        }
        $code = Shipping::where('code', '=', $postData['code'])->first();
        if ($code) {
            return redirect('shipping/add/' . $id )->with('error', 'Please insert unique data in Code field.');
        }
        $shipping = Shipping::find($id);
        if (!$shipping) {
            $code = Shipping::where('code', '=', $postData['code'])->first();
            if ($code) {
                return redirect('shipping/add/0')->with('error', 'Code has to be unique please selece unique one.');;
            }
            $postData['created_at'] = Carbon::now();
            Shipping::insertGetId($postData);
            return redirect('shipping')->with('success', 'Shipping inserted successfully');
        } else {
            $shipping->name = $postData['name'];
            $shipping->code = $postData['code'];
            $shipping->description = $postData['description'];
            $shipping->status = $postData['status'];
            $shipping->updated_at = Carbon::now();
            $shipping->save();
            return redirect('shipping')->with('success', 'Shipping Updated successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function show(Shipping $shipping)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function edit(Shipping $shipping)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shipping $shipping)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shipping = Shipping::find($id);
        $shipping->delete();
        return redirect('shipping')->with('success', 'Shipping deleted successfully.');
    }
}
