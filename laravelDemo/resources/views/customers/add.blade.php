@extends('layouts.theme')

@section('content')
    @if (isset($customer->id))
        <?php $id = $customer->id;?>
        <h1>Edit Customer</h1>
        @else
        <?php $id = 0;?>
        <h1>Add Customer</h1>
    @endif
    @if ($id !=0)
    <div class="row">
      <div class="col-3">
        <div class="list-group">
          <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
            The current link item
          </a>
          <button class="list-group-item list-group-item-action" onclick="mage.setUrl('customers/address/{{$id}}').setMethod('get').load();">Customer Address</button>
        </div>
      </div>
      @endif
        <div class="col-9">
            <form action="{{ url('customers/store/' . $id) }}" method="post" id="customer_form">
                @csrf
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" class="form-control"
                        value="{{ isset($customer->first_name) && $customer['first_name'] != '' ? $customer['first_name'] : '' }}"
                        name="customers[first_name]" id="first_name" aria-describedby="emailHelp" placeholder="First Name" required>
                        <span class="text-danger -error-text first_name_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control"
                        value="{{ isset($customer->last_name) && $customer['last_name'] != '' ? $customer['last_name'] : '' }}"
                        name="customers[last_name]" id="last_name" aria-describedby="emailHelp" placeholder="Last Name" required>
                        <span class="text-danger -error-text last_name_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" class="form-control"
                        value="{{ isset($customer->email) && $customer['email'] != '' ? $customer['email'] : '' }}"
                        name="customers[email]" id="exampleInputEmail1" aria-describedby="emailHelp"
                        placeholder="Enter email" required>
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                            else.</small>
                            <span class="text-danger -error-text email_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control"
                            value="{{ isset($customer->password) && $customer['password'] != '' ? $customer['password'] : '' }}"
                            name="customers[password]" id="exampleInputPassword1" placeholder="Password" required>
                            <span class="text-danger -error-text password_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control"
                            value="{{ isset($customer->status) && $customer['status'] != '' ? $customer['status'] : '' }}"
                            name="customers[status]" id="ststus" required>
                            <option value="Enable" {{($customer['status'] == 'Enable') ? 'selected' : ''}}>Enable</option>
                            <option value="Disable" {{($customer['status'] == 'Disable') ? 'selected' : ''}}>Disable</option>
                        </select>
                        <span class="text-danger -error-text status_error"></span>
                </div>
                <input type="button" class="btn btn-success" onclick="mage.setForm('customer_form')" value="submit" class="btn btn-success">
            </form>
        </div>
    </div>
@endsection
@section('script')
<script>
    $('#customer_form').on('submit',function (e) {
        e.preventDefault();

        $.ajax({
            url:$(this).attr('action'),
            method:$(this).attr('method'),
            data:new FormData(this),
            processData: False,
            dataType: 'json',
            contentType:False,
            beforeSend:function(){

            },
            success:function (data) {
                
            }
        });
    });
    $('#customer_form').validate({
        rules: {
            first_name: {
                required : true,
            },
            last_name: {
                required : true,
            },
            email: {
                required : true,
            },
            pasword: {
                required : true,
            },
            status: {
                required : true,
            }
        },
        message: {
            first_name: {
                required : Please enter FirstName,
            },
            last_name: {
                required : Please enter LastName,
            },
            email: {
                required : Please enter email,
            },
            pasword: {
                required : password,
            },
            status: {
                required : status,
            }
        }
    });
<script>
@endsection