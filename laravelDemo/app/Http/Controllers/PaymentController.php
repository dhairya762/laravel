<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaymentController extends Controller
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
        $count = Payment::count();
        $limit = session('paginate');
        $offset = ($current_page - 1) * $limit;
        $allPayments = Payment::all();
        $payments = Payment::orderBy('id', 'DESC')->offset($offset)->limit($limit)->get();

        if ($limit > 0) {
            $totalPage = ceil($count / $limit);
        } else {
            $totalPage = 0;
        }
        $view = view('payment.list', compact('totalPage', 'limit', 'offset', 'allPayments', 'recordsPerPage', 'payments'))->render();
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
        $payment = Payment::find($id);
        $view = view('payment.add', compact('payment', 'id'))->render();
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
        $postData = $request->payment;
        if (!$postData['name']) {
            return redirect('payment/add/' . $id )->with('error', 'Please insert data in Name field.');
        }
        if (!$postData['code']) {
            return redirect('payment/add/' . $id )->with('error', 'Please insert data in Code field.');
        }
        if (!$postData['description']) {
            return redirect('payment/add/' . $id )->with('error', 'Please insert data in Description field.');
        }
        if (!$postData['status']) {
            return redirect('payment/add/' . $id )->with('error', 'Please insert data in Status field.');
        }
        $code = Payment::where('code', '=', $postData['code'])->first();
        if ($code) {
            return redirect('payment/add/' . $id )->with('error', 'Please insert unique data in Code field.');
        }
        $payment = Payment::find($id);
        if (!$payment) {
            $code = Payment::where('code', '=', $postData['code'])->first();
            if ($code) {
                return redirect('payment/add/0')->with('error', 'Code has to be unique please selece unique one.');;
            }
            $postData['created_at'] = Carbon::now();
            Payment::insertGetId($postData);
            return redirect('payment')->with('success', 'Payment inserted successfully');
        } else {
            $payment->name = $postData['name'];
            $payment->code = $postData['code'];
            $payment->description = $postData['description'];
            $payment->status = $postData['status'];
            $payment->updated_at = Carbon::now();
            $payment->save();
            return redirect('payment')->with('success', 'Payment Updated successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = Payment::find($id);
        $payment->delete();
        return redirect('payment')->with('success', 'Payment deleted successfully.');
    }
}
