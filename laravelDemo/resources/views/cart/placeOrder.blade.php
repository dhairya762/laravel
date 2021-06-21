@extends('layouts.theme')
@section('content')
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
                    <th scope="col">CartId</th>
                    <th scope="col">ProductId</th>
                    <th scope="col">ProductName</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Base Price</th>
                    <th scope="col">Price</th>
                    <th scope="col">Discount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart_item as $item)
                    <tr>
                        <td>{{ $item->cart_id }}</td>
                        <td>{{ $item->product_id }}</td>
                        @foreach ($products as $product)
                            @if ($product->id == $item->product_id)
                                <td>{{ $product->name }}</td>
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
                    <td>{{ $model->getTotalQuantity($cart_item) }}</td>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td>Total Discount</td>
                    <td>{{ $model->getTotalDiscount($cart_item) }}</td>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td>Total Price</td>
                    <td>{{ $model->getTotal($cart_item) }}</td>
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
                            <td>{{ $customerBillingAddress->address }}</td>
                        </tr>
                        <tr>
                            <td scope="col">City</td>
                            <td>{{ $customerBillingAddress->city }}</td>
                        </tr>
                        <tr>
                            <td scope="col">State</td>
                            <td>{{ $customerBillingAddress->state }}</td>
                        </tr>
                        <tr>
                            <td scope="col">Country</td>
                            <td>{{ $customerBillingAddress->country }}</td>
                        </tr>
                        <tr>
                            <td scope="col">Zipcode</td>
                            <td>{{ $customerBillingAddress->zipcode }}</td>
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
                            <td>{{ $customerShippingAddress->address }}</td>
                        </tr>
                        <tr>
                            <td scope="col">City</td>
                            <td>{{ $customerShippingAddress->city }}</td>
                        </tr>
                        <tr>
                            <td scope="col">State</td>
                            <td>{{ $customerShippingAddress->state }}</td>
                        </tr>
                        <tr>
                            <td scope="col">Country</td>
                            <td>{{ $customerShippingAddress->country }}</td>
                        </tr>
                        <tr>
                            <td scope="col">Zipcode</td>
                            <td>{{ $customerShippingAddress->zipcode }}</td>
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
                            <td>{{ $paymentMethod->name }}</td>
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
                            <td>{{ $shippingMethod->name }} => {{ $shippingMethod->description }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br><br><br><br>
        <div class="row">
            <div class="col-md-6 float-left">
            </div>
            <div class="col-md-6 float-right">
                <table class="table">
                    <tbody>
                        <tr>
                            <td scope="row">Total Price</td>
                            <td>{{ $model->getTotal($cart_item) }}</td>
                        </tr>
                        <tr>
                            <td scope="row">Total Discount</td>
                            <td>{{ $model->getTotalDiscount($cart_item) }}</td>
                        </tr>
                        <tr>
                            <td scope="row">Shipping Charge</td>
                            <td>{{ $cart->shipping_amount }}</td>
                        </tr>
                        <tr>
                            <td scope="row">Final Price</td>
                            <td>{{ $model->getFinalPrice($cart_item) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br><br><br><br>
    <div class="row">
        <div class="col-md-6 text-center">
            <a href="javascript:void(0)" onclick="mage.setUrl('cart').setMethod('get').load();"
                class="btn btn-primary text-left">Back to the cart</a>
        </div>
        <div class="col-md text-center">
            <form id="submit_form" action="{{ url('placeorder') }}" method="get">
                <input type="button" value="Confirm Order Details" class="btn btn-success"
                    onclick="mage.setForm('submit_form');">
            </form>
        </div>
    </div>
@endsection