@extends('layouts.theme')

@section('content')
    <a href="javascript:void(0)" onclick="mage.setUrl('placeorder').setMethod('get').load();" class="btn btn-success">Back</a>
    <h1>Hello {{ $customerName->first_name }} {{ $customerName->last_name }}</h1>
    <div class="col-md">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">CustomerId</th>
                    <th scope="col">FirstName</th>
                    <th scope="col">LastName</th>
                    <th scope="col">Email</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $customerName->id }}</td>
                    <td>{{ $customerName->first_name }}</td>
                    <td>{{ $customerName->last_name }}</td>
                    <td>{{ $customerName->email }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md">
        <br><br>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">PlaceOrderId</th>
                    <th scope="col">ProductId</th>
                    <th scope="col">ProductName</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Base Price</th>
                    <th scope="col">Price</th>
                    <th scope="col">Discount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($placeOrder_item as $item)
                    <tr>
                        <td>{{ $item->placeorder_id }}</td>
                        <td>{{ $item->product_id }}</td>
                        @foreach ($product as $item1)
                        @if ($item1->id == $item->product_id)
                        <td>{{ $item1->name }}</td>
                        @endif
                        @endforeach
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->base_price }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->discount }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="5"></td>
                    <td>Total Quantity</td>
                    <td>{{ $model->getTotalQuantity($placeOrder_item) }}</td>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td>Total Discount</td>
                    <td>{{ $model->getTotalDiscount($placeOrder_item) }}</td>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td>Total Price</td>
                    <td>{{ $model->getTotal($placeOrder_item) }}</td>
                </tr>
            </tbody>
        </table><br><br>
    </div>
    <br><br><br><br>
    <div class="col-md">
        <div class="row">
            <div class="col-md-5 float-left">
                <h3>Billing Address</h3>
                <table class="table">
                    <tbody>
                        <tr>
                            <td scope="col">Address</td>
                            <td>{{ $placeOrderBillingAddress->address }}</td>
                        </tr>
                        <tr>
                            <td scope="col">City</td>
                            <td>{{ $placeOrderBillingAddress->city }}</td>
                        </tr>
                        <tr>
                            <td scope="col">State</td>
                            <td>{{ $placeOrderBillingAddress->state }}</td>
                        </tr>
                        <tr>
                            <td scope="col">Country</td>
                            <td>{{ $placeOrderBillingAddress->country }}</td>
                        </tr>
                        <tr>
                            <td scope="col">Zipcode</td>
                            <td>{{ $placeOrderBillingAddress->zipcode }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-5 float-right">
                <h3>Shipping Address</h3>
                <table class="table">
                    <tbody>
                        <tr>
                            <td scope="col">Address</td>
                            <td>{{ $placeOrderShippingAddress->address }}</td>
                        </tr>
                        <tr>
                            <td scope="col">City</td>
                            <td>{{ $placeOrderShippingAddress->city }}</td>
                        </tr>
                        <tr>
                            <td scope="col">State</td>
                            <td>{{ $placeOrderShippingAddress->state }}</td>
                        </tr>
                        <tr>
                            <td scope="col">Country</td>
                            <td>{{ $placeOrderShippingAddress->country }}</td>
                        </tr>
                        <tr>
                            <td scope="col">Zipcode</td>
                            <td>{{ $placeOrderShippingAddress->zipcode }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br><br><br><br>
        <div class="row">
            <div class="col-md-5 float-left">
                <h3>
                    <center>Payment Method</center>
                </h3>
                <table class="table">
                    <tbody>
                        <tr>
                            <td>{{ $payment->name }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-5 float-right">
                <h3>
                    <center>Shipping Method</center>
                </h3>
                <table class="table">
                    <tbody>
                        <tr>
                            <td>{{ $shipping->name }} => {{ $shipping->description }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br><br><br><br>
        <div class="row">
            <div class="col-md-6 float-left">
                <table class="table table-bordered ">
                    <thead>
                        <tr>
                            <th colspan="3" class="text-center">
                                Order Status
                            </th>
                        </tr>
                        <tr>
                            <th>Comment</th>
                            <th>Status</th>
                            <th>Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($comments)
                            @foreach ($comments as $comment)
                                <tr>
                                    <td>
                                        {{ $comment->comment ? $comment->comment : '-' }}
                                    </td>
                                    <td>
                                        {{ $comment->status }}
                                    </td>
                                    <td>
                                        {{ $comment->created_at }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        <tr>
                            <td colspan="3">
                                <form action="{{ url('placeorder/comments/' . $placeOrder->id) }}" method="post" id="comments">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label
                                                for="comment">Comment</label>
                                            <textarea class="form-control"
                                                name="comments[comment]"
                                                id="comment" rows="2"
                                                style="resize: none"></textarea>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="status">Select
                                                Status</label>
                                            <select class="form-control"
                                                name="comments[status]"
                                                id="status">
                                                <option selected disabled>
                                                    Select Status
                                                </option>
                                                <option value="Pending">
                                                    Pending
                                                </option>
                                                <option value="Processing">
                                                    Processing
                                                </option>
                                                <option value="Shipped">
                                                    Shipped
                                                </option>
                                                <option value="Delivered">
                                                    Delivered
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-12">
                                            <input type="button" onclick="mage.setForm('comments');"
                                                class="btn btn-primary" value="Save Comment">
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6 float-right">
                <table class="table">
                    <tbody>
                        <tr>
                            <td scope="row">Total Price</td>
                            <td>{{ $model->getTotal($placeOrder_item) }}</td>
                        </tr>
                        <tr>
                            <td scope="row">Total Discount</td>
                            <td>{{ $model->getTotalDiscount($placeOrder_item) }}</td>
                        </tr>
                        <tr>
                            <td scope="row">Shipping Charge</td>
                            <td>{{ $placeOrder->shipping_amount }}</td>
                        </tr>
                        <tr>
                            <td scope="row">Final Price</td>
                            <td>{{ $model->getFinalPrice($placeOrder_item) + $placeOrder->shipping_amount }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
