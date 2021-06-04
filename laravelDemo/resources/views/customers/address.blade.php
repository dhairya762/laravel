@extends('layouts.theme')

@section('content')
    <h1>Customer Address</h1>
    <div class="row">
        <div class="col-8">
            <form action="{{ url('customers/save-address/' . $customer->id) }}" method="post" id="customer_address_form">
                @csrf
                <h2>Billing Address</h2>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control"
                        value="{{ isset($customerBillingAddress->address) && $customerBillingAddress['address'] != '' ? $customerBillingAddress['address'] : '' }}"
                        name="billing[address]" id="address" aria-describedby="emailHelp" placeholder="Address" required>
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" class="form-control"
                        value="{{ isset($customerBillingAddress->city) && $customerBillingAddress['city'] != '' ? $customerBillingAddress['city'] : '' }}"
                        name="billing[city]" id="city" aria-describedby="emailHelp" placeholder="City" required>
                </div>
                <div class="form-group">
                    <label for="state">State</label>
                    <input type="text" class="form-control"
                        value="{{ isset($customerBillingAddress->state) && $customerBillingAddress['state'] != '' ? $customerBillingAddress['state'] : '' }}"
                        name="billing[state]" id="state" aria-describedby="emailHelp" placeholder="State" required>
                </div>
                <div class="form-group">
                    <label for="country">Country</label>
                    <input type="text" class="form-control"
                        value="{{ isset($customerBillingAddress->country) && $customerBillingAddress['country'] != '' ? $customerBillingAddress['country'] : '' }}"
                        name="billing[country]" id="country" aria-describedby="emailHelp" placeholder="Country" required>
                </div>
                <div class="form-group">
                    <label for="zipcode">ZipCode</label>
                    <input type="text" class="form-control"
                        value="{{ isset($customerBillingAddress->zipcode) && $customerBillingAddress['zipcode'] != '' ? $customerBillingAddress['zipcode'] : '' }}"
                        name="billing[zipcode]" id="zipcode" aria-describedby="emailHelp" placeholder="zipcode" required>
                </div>
                <h2>Shipping Address</h2>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control"
                        value="{{ isset($customerShippingAddress->address) && $customerShippingAddress['address'] != '' ? $customerShippingAddress['address'] : '' }}"
                        name="shipping[address]" id="address" aria-describedby="emailHelp" placeholder="Address" required>
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" class="form-control"
                        value="{{ isset($customerShippingAddress->city) && $customerShippingAddress['city'] != '' ? $customerShippingAddress['city'] : '' }}"
                        name="shipping[city]" id="city" aria-describedby="emailHelp" placeholder="City" required>
                </div>
                <div class="form-group">
                    <label for="state">State</label>
                    <input type="text" class="form-control"
                        value="{{ isset($customerShippingAddress->state) && $customerShippingAddress['state'] != '' ? $customerShippingAddress['state'] : '' }}"
                        name="shipping[state]" id="state" aria-describedby="emailHelp" placeholder="State" required>
                </div>
                <div class="form-group">
                    <label for="country">Country</label>
                    <input type="text" class="form-control"
                        value="{{ isset($customerShippingAddress->country) && $customerShippingAddress['country'] != '' ? $customerShippingAddress['country'] : '' }}"
                        name="shipping[country]" id="country" aria-describedby="emailHelp" placeholder="Country" required>
                </div>
                <div class="form-group">
                    <label for="zipcode">ZipCode</label>
                    <input type="text" class="form-control"
                        value="{{ isset($customerShippingAddress->zipcode) && $customerShippingAddress['zipcode'] != '' ? $customerShippingAddress['zipcode'] : '' }}"
                        name="shipping[zipcode]" id="zipcode" aria-describedby="emailHelp" placeholder="zipcode" required>
                </div>
                <input type="button" value="Submit" class="btn btn-primary" onclick="mage.setForm('customer_address_form')">
            </form>
        </div>
    </div>
@endsection
