<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\PlaceOrder;
use App\Models\PlaceOrderItem;
use App\Models\PlaceOrderComments;
use App\Models\PlaceOrderAddress;
use App\Models\PlaceOrderComment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PlaceOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $page_no = null)
    {
        $customers = Customers::all();
        $placeOrder = PlaceOrder::where('customer_id', '=', session('customer_id'))->first();

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
        $customer_id = $request->customer_id;
        if ($customer_id) {
            $count = PlaceOrder::where('customer_id', '=', $customer_id)->count();
            $limit = session('paginate');
            $offset = ($current_page - 1) * $limit;
            $orders = PlaceOrder::orderBy('id', 'DESC')->where('customer_id', '=', $customer_id)->offset($offset)->limit($limit)->get();
        } else {
            $count = PlaceOrder::count();
            $limit = session('paginate');
            $offset = ($current_page - 1) * $limit;
            $orders = PlaceOrder::orderBy('id', 'DESC')->offset($offset)->limit($limit)->get();
        }
        if ($limit > 0) {
            $totalPage = ceil($count / $limit);
        } else {
            $totalPage = 0;
        }
        $view = view('placeorder.list', compact('customer_id', 'totalPage', 'limit', 'offset', 'recordsPerPage', 'orders', 'customers', 'placeOrder'))->render();
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
    public function create()
    {
        //
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
     * @param  \App\Models\PlaceOrder  $placeOrder
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = new PlaceOrder;
        $product = Product::all();
        $placeOrder = Placeorder::find($id);
        $comments = DB::select('select * from `placeorder_comments` where `placeorder_id` = ? ORDER BY `id` DESC', [$placeOrder->id]);
        if (!$comments) {
            $comments = null;
        }
        $customerName = Customers::find($placeOrder->customer_id);
        $placeOrder_item = PlaceOrderItem::where('placeOrder_id', '=', $id)->get();
        $payment = Payment::find($placeOrder->payment_method_id);
        $shipping = Shipping::find($placeOrder->shipping_method_id);
        $placeOrderBillingAddress = PlaceOrderAddress::where('placeOrder_id', '=', $id)->where('address_type', '=', 'billing')->first();
        $placeOrderShippingAddress = PlaceOrderAddress::where('placeOrder_id', '=', $id)->where('address_type', '=', 'shipping')->first();
        $view = view('placeorder.information', compact('comments', 'product', 'customerName', 'placeOrder_item', 'placeOrderBillingAddress', 'placeOrderShippingAddress', 'model', 'payment', 'shipping', 'placeOrder'))->render();
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PlaceOrder  $placeOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(PlaceOrder $placeOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PlaceOrder  $placeOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PlaceOrder $placeOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PlaceOrder  $placeOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(PlaceOrder $placeOrder)
    {
        //
    }

    public function saveComment(Request $request, $id)
    {
        $postData = $request->comments;
        $comment = new PlaceOrderComment;
        $comment_id = $comment->insertGetId([
            'placeorder_id' => $id,
            'comment' => $postData['comment'],
            'status' => $postData['status'],
            'created_at' => Carbon::now(),
        ]);
        return redirect('placeorder')->with('success', 'Order status successfully changed.');
    }
}
