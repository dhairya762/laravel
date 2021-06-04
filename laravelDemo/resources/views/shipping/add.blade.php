@extends('layouts.theme')

@section('content')
    @if ($id)
        <h1>Update Shipping</h1>
    @else
        <h1>Add Shipping</h1>
    @endif
    <div class="row">
      <div class="col-9">
          <form action="{{ url('shipping/store/' . $id) }}" method="post" id='shipping_form'>
              @csrf
              <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control"
                      value="{{ isset($shipping->name) && $shipping['name'] != '' ? $shipping['name'] : '' }}"
                      name="shipping[name]" id="name" aria-describedby="emailHelp" placeholder="Name" required>
              </div>
              <div class="form-group">
                  <label for="code">Code</label>
                  <input type="text" class="form-control"
                      value="{{ isset($shipping->code) && $shipping['code'] != '' ? $shipping['code'] : '' }}"
                      name="shipping[code]" id="name" aria-describedby="emailHelp" placeholder="Code" required>
              </div>
              <div class="form-group">
                  <label for="description">Description</label>
                  <input type="text" class="form-control"
                      value="{{ isset($shipping->description) && $shipping['description'] != '' ? $shipping['description'] : '' }}"
                      name="shipping[description]" id="name" aria-describedby="emailHelp" placeholder="Description" required>
              </div>
              <div class="form-group">
                  <label for="amount">Amount</label>
                  <input type="text" class="form-control"
                      value="{{ isset($shipping->amount) && $shipping['amount'] != '' ? $shipping['amount'] : '' }}"
                      name="shipping[amount]" id="name" aria-describedby="emailHelp" placeholder="Amount" required>
              </div>
              <div class="form-group">
                  <label for="status">Status</label>
                  <select class="form-control"
                      value="{{ isset($shipping->status) && $shipping['status'] != '' ? $shipping['status'] : '' }}"
                      name="shipping[status]" id="ststus" required>
                      <option value="Enable" {{ $shipping['status'] == 'Enable' ? 'selected' : '' }}>Enable</option>
                      <option value="Disable" {{ $shipping['status'] == 'Disable' ? 'selected' : '' }}>Disable</option>
                  </select>
              </div>
              <input type="button" value="Submit" class="btn btn-success" onclick="mage.setForm('shipping_form');">
          </form>
      </div>
  </div>
@endsection
