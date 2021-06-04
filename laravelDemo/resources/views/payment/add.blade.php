@extends('layouts.theme')

@section('content')
    @if ($id)
        <h1>Update Payment</h1>
    @else
        <h1>Add Payment</h1>
    @endif
    <div class="row">
      <div class="col-9">
          <form action="{{ url('payment/store/' . $id) }}" method="post" id='payment_form'>
              @csrf
              <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control"
                      value="{{ isset($payment->name) && $payment['name'] != '' ? $payment['name'] : '' }}"
                      name="payment[name]" id="name" aria-describedby="emailHelp" placeholder="Name" required>
              </div>
              <div class="form-group">
                  <label for="code">Code</label>
                  <input type="text" class="form-control"
                      value="{{ isset($payment->code) && $payment['code'] != '' ? $payment['code'] : '' }}"
                      name="payment[code]" id="name" aria-describedby="emailHelp" placeholder="Code" required>
              </div>
              <div class="form-group">
                  <label for="description">Description</label>
                  <input type="text" class="form-control"
                      value="{{ isset($payment->description) && $payment['description'] != '' ? $payment['description'] : '' }}"
                      name="payment[description]" id="name" aria-describedby="emailHelp" placeholder="Description" required>
              </div>
              <div class="form-group">
                  <label for="status">Status</label>
                  <select class="form-control"
                      value="{{ isset($payment->status) && $payment['status'] != '' ? $payment['status'] : '' }}"
                      name="payment[status]" id="ststus" required>
                      <option value="Enable" {{ $payment['status'] == 'Enable' ? 'selected' : '' }}>Enable</option>
                      <option value="Disable" {{ $payment['status'] == 'Disable' ? 'selected' : '' }}>Disable</option>
                  </select>
              </div>
              <input type="button" value="Submit" class="btn btn-success" onclick="mage.setForm('payment_form');">
          </form>
      </div>
  </div>
@endsection
