<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\CustomersAddress;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class CustomersController extends Controller
{
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
        $count = Customers::count(); 
        $limit = session('paginate');
        $offset = ($current_page - 1) * $limit;
        $customers = Customers::leftJoin('customers_address', 'customers.id', '=', 'customers_address.customer_id')
        ->select([
            'customers.id',
            'customers.first_name',
            'customers.last_name',
            'customers.email',
            'customers.password',
            'customers.status',
            'customers.created_at',
            'customers.updated_at',
            'customers_address.address',
            'customers_address.city',
            'customers_address.state',
            'customers_address.country',
            'customers_address.zipcode',
            'customers_address.address_type',
            ])->orderBy('id', 'DESC')->offset($offset)->limit($limit)->get();
            
            if ($limit > 0) {
                $totalPage = ceil($count/$limit);
            }
            else {
                $totalPage = 0;
            }
        $view = view('customers.list', compact('totalPage', 'count', 'customers','limit', 'offset'))->render();
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
    // }

    public function create($id)
    {
        $customer = Customers::find($id);
        $view = view('customers.add', compact('customer'))->render();
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


    public function store(Request $request, $id)
    {
        $postData = $request->customers;
        if (!$postData['first_name']) {
            return redirect('customers/add/'. $id )->with('error', 'Please insert data into First Name.');
        }
        if (!$postData['last_name']) {
            return redirect('customers/add/'. $id )->with('error', 'Please insert data into Last Name.');
        }
        if (!$postData['email']) {
            return redirect('customers/add/'. $id )->with('error', 'Please insert data into Email.');
        }
        if (!$postData['password']) {
            return redirect('customers/add/'. $id )->with('error', 'Please insert data into Password.');
        }
        if (!$postData['status']) {
            return redirect('customers/add/'. $id )->with('error', 'Please insert data into Status.');
        }
        $customer = Customers::find($id);
        if (!$customer) {
            $postData['created_at'] = Carbon::now();
            Customers::insertGetId($postData);
            return redirect('customers')->with('success', 'Customer inserted successfully.');
        } else {
            $customer->first_name = $postData['first_name'];
            $customer->last_name = $postData['last_name'];
            $customer->email = $postData['email'];
            $customer->password = $postData['password'];
            $customer->status = $postData['status'];
            $customer->updated_at = Carbon::now();
            $customer->save();
            return redirect('customers')->with('success', 'Customer updated successfully.');
        }
    }


    public function show(Customers $customers)
    {
        // return redirect()->route('customers');
    }


    public function edit(Request $request, $id)
    {
        $customer = Customers::find($id);
        return view('customers.add')->with('customer', $customer);
        // $response = [
        //     'element' =>[
        //         [
        //             'selector' => '#content',
        //             'html' => $view
        //         ]
        //     ]
        // ];
        // header('content-type:application/json');
        // echo json_encode($response);
    }

    public function update(Request $request, $id)
    {
        // $postData = $request->customers;
        // $customer = Customers::find($id);
        // $customer->first_name = $postData['first_name'];
        // $customer->last_name = $postData['last_name'];
        // $customer->email = $postData['email'];
        // $customer->password = $postData['password'];
        // $customer->status = $postData['status'];
        // $customer->updated_at = Carbon::now();
        // $customer->save();
        // return redirect('customers');
    }

    public function destroy($id)
    {
        $customer = Customers::find($id);
        $customer->delete();
        return redirect('customers')->with('success', 'Customer deleted successfully.');
    }

    public function addressAction($id)
    {
        $customer = Customers::find($id);
        $customerBillingAddress = CustomersAddress::where('customer_id', '=', $id)->where('address_type', '=', "Billing")->first();
        $customerShippingAddress = CustomersAddress::where('customer_id', '=', $id)->where('address_type', '=', "Shipping")->first();
        // return view('customers.address', compact('customer', 'customerBillingAddress', 'customerShippingAddress'));
        $view = view('customers.address', compact('customer', 'customerBillingAddress', 'customerShippingAddress'))->render();
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

    public function saveAddressAction(Request $request, $id)
    {
        $billing = CustomersAddress::where('address_type', '=', "Billing")->where('customer_id', '=', $id)->first();
        $shipping = CustomersAddress::where('address_type', '=', "Shipping")->where('customer_id', '=', $id)->first();
        if (!$billing) {
            $billing = new CustomersAddress;
        }
        if (!$shipping) {
            $shipping = new CustomersAddress;
        }
        $billingAddress = $request->billing;
        $shippingAddress = $request->shipping;
        $billing->address = $billingAddress['address'];
        $billing->city = $billingAddress['city'];
        $billing->state = $billingAddress['state'];
        $billing->country = $billingAddress['country'];
        $billing->zipcode = $billingAddress['zipcode'];
        $billing->address_type = "Billing";
        $billing->created_at = Carbon::now();
        $billing->customer_id = $id;
        $billing->save();
        $shipping->address = $shippingAddress['address'];
        $shipping->city = $shippingAddress['city'];
        $shipping->state = $shippingAddress['state'];
        $shipping->country = $shippingAddress['country'];
        $shipping->zipcode = $shippingAddress['zipcode'];
        $shipping->address_type = "Shipping";
        $shipping->created_at = Carbon::now();
        $shipping->customer_id = $id;
        $shipping->save();
        return redirect('customers')->with('success', 'Customer Address saved successfully.');
    }
}
