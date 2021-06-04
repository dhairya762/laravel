@extends('layouts.theme')
@section('content')
    <div class="row">
        <div class="col-md-2">
            <form id="select_customer" action="{{ url('cart/select_customer') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Example select</label>
                    <select name="customer_id" class="form-control" id="exampleFormControlSelect1"
                    onchange="mage.setForm('select_customer')">
                        <option value="0" selected disabled>Select Customer</option>
                        @foreach ($customerName as $name)
                            <option value="{{ $name->id }}"
                                {{ $name->id == session('customer_id') ? 'selected' : '' }}>
                                {{ $name->first_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    </div>
    <input type="button" class="btn btn-success" value="Add Product" id="add_product">
    <br><br><br><br>
    <div class="col-md d-n" id="product">
        <form action="{{ url('cart/add_product') }}" method="post" id="add_product_form">
            @csrf
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ProductId</th>
                        <th scope="col">SKU</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Discount</th>
                        <th scope="col">Add Item to Cart</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->sku }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->discount }}</td>
                            <td>
                                <input name="product[add_to_cart][]" value="{{ $product->id }}" type="checkbox"
                                    class="form-check-input" id="exampleCheck1">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br><br>
            <input type="button" class="btn btn-success" value="Add To Cart" id="add_to_cart" onclick="mage.setForm('add_product_form');">
        </form>
    </div>
    <br><br><br><br>
    <div class="col-md">
        {{-- <a href="{{ url('cart/clear_cart') }}" class="btn btn-danger" onclick="mage.setUrl().setMethod.load()">Clrear Cart</a> --}}
        <input type="button" value="Clear Cart" onclick="mage.setUrl('cart/clear_cart').setMethod('get').load();" class="btn btn-danger">
        <br><br>
        <form action="{{ url('cart/update_product_quantity') }}" method="post" id="cart_item">
            @csrf
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
                        <th scope="col">Remove</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($cartItem)
                    @if (count($cartItem) > 0) 
                        @foreach ($cartItem as $item)
                            <tr>
                                <td>{{ $item->cart_id }}</td>
                                <td>{{ $item->product_id }}</td>
                                @foreach ($products as $product)
                                    @if ($product->id == $item->product_id)
                                        <td>{{ $product->name }}</td>
                                    @endif
                                @endforeach
                                <td><input type="number" name="quantity[{{ $item->product_id }}]" id="quantity" min="1"
                                        value={{ $item->quantity }}></td>
                                <td>{{ $item->base_price }}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->discount }}</td>
                                <td><input type="checkbox" name="remove[{{ $item->id }}]" id="remove_item"
                                        value={{ $item->id }}></td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="6"></td>
                            <td>Total Quantity</td>
                            <td>{{$model->getTotalQuantity($cartItem)}}</td>
                        </tr>
                        <tr>
                            <td colspan="6"></td>
                            <td>Total Discount</td>
                            <td>{{$model->getTotalDiscount($cartItem)}}</td>
                        </tr>
                        <tr>
                            <td colspan="6"></td>
                            <td>Total Price</td>
                            <td>{{$model->getTotal($cartItem)}}</td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="8">No Product added into cart.</td>
                        </tr>
                    @endif
                    @endif
                </tbody>
            </table>
            <br><br>
            @if (count($cartItem) > 0)
                <input type="button" class="btn btn-success" value="Update" onclick="mage.setForm('cart_item');"id="update _product_quantity">
                <input type="button" class="btn btn-danger" value="Delete Product" onclick="mage.changeAction('cart_item','cart/delete_product');" id="delete_product">
            @endif
        </form>
    </div>
    <br><br><br><br>
    <div class="col-md">
        <div class="row">
            <div class="col-md-5 float-left">
                <form action="{{ url('cart/billing_address') }}" method="post" id="billing_form">
                    <h3>Billing Address</h3>
                    @csrf
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control"
                            value="{{ isset($customerBillingAddress->address) && $customerBillingAddress->address != '' ? $customerBillingAddress->address : '' }}"
                            name="billing[address]" id="baddress" aria-describedby="emailHelp" placeholder="Address"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" class="form-control"
                            value="{{ isset($customerBillingAddress->city) && $customerBillingAddress->city != '' ? $customerBillingAddress->city : '' }}"
                            name="billing[city]" id="bcity" aria-describedby="emailHelp" placeholder="City" required>
                    </div>
                    <div class="form-group">
                        <label for="state">State</label>
                        <input type="text" class="form-control"
                            value="{{ isset($customerBillingAddress->state) && $customerBillingAddress->state != '' ? $customerBillingAddress->state : '' }}"
                            name="billing[state]" id="bstate" aria-describedby="emailHelp" placeholder="State" required>
                    </div>
                    <div class="form-group">
                        <label for="country">Country</label>
                        <input type="text" class="form-control"
                            value="{{ isset($customerBillingAddress->country) && $customerBillingAddress->country != '' ? $customerBillingAddress->country : '' }}"
                            name="billing[country]" id="bcountry" aria-describedby="emailHelp" placeholder="Country"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="zipcode">ZipCode</label>
                        <input type="text" class="form-control"
                            value="{{ isset($customerBillingAddress->zipcode) && $customerBillingAddress->zipcode != '' ? $customerBillingAddress->zipcode : '' }}"
                            name="billing[zipcode]" id="bzipcode" aria-describedby="emailHelp" placeholder="zipcode"
                            required>
                    </div>
                    <div class="form-check">
                        <input name="billing[save_to_address]" type="checkbox" class="form-check-input" id="exampleCheck1"
                            checked>
                        <label class="form-check-label" for="exampleCheck1">Save in Address Book </label>
                    </div>
                    <input id="save_billing" type="button" value="Save" class="btn btn-success" onclick="mage.setForm('billing_form')">
                </form>
            </div>
            <div class="col-md-5 float-right">
                <form action="{{ url('cart/shipping_address') }}" method="post" id="shipping_form">
                    @csrf
                    <h3>Shipping Address</h3>
                    <div class="form-check">
                        <input name="shipping[same_as_billing]" type="checkbox" class="form-check-input"
                            id="same_as_billing">
                        <label class="form-check-label" for="same_as_billing">Same As Billing</label>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" id="saddress" class="form-control"
                            value="{{ isset($customerShippingAddress->address) && $customerShippingAddress->address != '' ? $customerShippingAddress->address : '' }}"
                            name="shipping[address]" id="address" aria-describedby="emailHelp" placeholder="Address"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" id="scity" class="form-control"
                            value="{{ isset($customerShippingAddress->city) && $customerShippingAddress->city != '' ? $customerShippingAddress->city : '' }}"
                            name="shipping[city]" id="city" aria-describedby="emailHelp" placeholder="City" required>
                    </div>
                    <div class="form-group">
                        <label for="state">State</label>
                        <input type="text" id="sstate" class="form-control"
                            value="{{ isset($customerShippingAddress->state) && $customerShippingAddress->state != '' ? $customerShippingAddress->state : '' }}"
                            name="shipping[state]" id="state" aria-describedby="emailHelp" placeholder="State" required>
                    </div>
                    <div class="form-group">
                        <label for="country">Country</label>
                        <input type="text" id="scountry" class="form-control"
                            value="{{ isset($customerShippingAddress->country) && $customerShippingAddress->country != '' ? $customerShippingAddress->country : '' }}"
                            name="shipping[country]" id="country" aria-describedby="emailHelp" placeholder="Country"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="zipcode">ZipCode</label>
                        <input type="text" id="szipcode" class="form-control"
                            value="{{ isset($customerShippingAddress->zipcode) && $customerShippingAddress->zipcode != '' ? $customerShippingAddress->zipcode : '' }}"
                            name="shipping[zipcode]" id="zipcode" aria-describedby="emailHelp" placeholder="zipcode"
                            required>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="shipping[save_to_address]" class="form-check-input"
                            id="shipping_save_address_book" checked>
                        <label class="form-check-label" for="shipping_save_address_book">Save in AddressBook</label>
                    </div>
                    <input id="save_shipping" type="button" value="Save" class="btn btn-success" onclick="mage.setForm('shipping_form');">
                </form>
            </div>
        </div>
        <br><br><br><br>
        <div class="row">
            <div class="col-md-5 float-left">
                <form id="payment" action="{{ url('cart/payment_method') }}" method="post">
                    @csrf
                    <h3>Payment Method</h3>
                    <div class="form-check">
                        @foreach ($payment as $item)
                            <input class="form-check-input" type="radio" name="payment_method" value="{{ $item->id }}"
                                id="flexRadioDefault2" onchange="mage.setForm('payment');"
                                {{ $cart->payment_method_id == $item->id ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexRadioDefault2">{{ $item->name }}</label><br>
                        @endforeach
                    </div>
                </form>
            </div>

            <div class="col-md-5 float-right">
                <form id="shipping" action="{{ url('cart/shipping_method') }}" method="post">
                    @csrf
                    <h3>Shipping Method</h3>
                    <div class="form-check">
                        @foreach ($shipping as $item)
                            <input class="form-check-input" type="radio" name="shipping_method" value="{{ $item->id }}"
                                id="flexRadioDefault2" onchange="mage.setForm('shipping');"
                                {{ $cart->shipping_method_id == $item->id ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexRadioDefault2">{{ $item->name}} => {{$item->description}}</label><br>
                        @endforeach
                    </div>
                </form>
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
                            <td>{{$model->getTotal($cartItem)}}</td>
                        </tr>
                        <tr>
                            <td scope="row">Total Discount</td>
                            <td>{{$model->getTotalDiscount($cartItem)}}</td>
                        </tr>
                        <tr>
                            <td scope="row">Shipping Charge</td>
                            <td>{{ $cart->shipping_amount }}</td>
                        </tr>
                        <tr>
                            <td scope="row">Final Price</td>
                            <td>{{$model->getFinalPrice($cartItem)}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md text-right">
                    @if ($cart->customer_id != 0 && count($cartItem) > 0 && $cart->payment_method_id != 0 && $cart->shipping_method_id != 0 && $customerBillingAddress && $customerShippingAddress)
                        <input type="button" value="Place Order" onclick="mage.setUrl('cart/place_order').setMethod('get').load();" class="btn btn-primary">
                    @endif
                </div>
            </div>
        </div>
@endsection

@section('script')
    <script>
        $('#add_product').click(function () {
            $('#product').removeClass('d-n');
        });

        $('#add_to_cart').click(function(){
            $('#product').addClass('d-n');
        });
        
        $('#same_as_billing').change(function() {
            $('#saddress').attr('disabled',this.checked);
            $('#scity').attr('disabled',this.checked);
            $('#sstate').attr('disabled',this.checked);
            $('#scountry').attr('disabled',this.checked);
            $('#szipcode').attr('disabled',this.checked);
        });
    </script>
@endsection
