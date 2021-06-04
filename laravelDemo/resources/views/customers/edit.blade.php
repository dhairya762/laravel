@extends('layouts.theme')

@section('content')
<div class="row">
  <div class="col-3">
        <div class="list-group">
          <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
            The current link item
          </a>
          <a href="{{url('customers/address/'.$customer->id)}}" class="list-group-item list-group-item-action">Customer Address</a>
        </div>
      </div>
      <div class="col-8">
          <h1>Edit Customer</h1>
            <form action="{{ url('customers/store/'.$customer->id) }}" method="post">
                @csrf
                    <div class="form-group">
                      <label for="first_name">First Name</label>
                      <input type="text" class="form-control"  value="{{$customer->first_name}}" name = "customers[first_name]" id="first_name" aria-describedby="emailHelp" placeholder="First Name">
                      <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                      <label for="last_name">Last Name</label>
                      <input type="text" class="form-control"  value="{{$customer->last_name}}" name = "customers[last_name]" id="last_name" aria-describedby="emailHelp" placeholder="Last Name">
                      <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Email</label>
                      <input type="email" class="form-control"  name = "customers[email]" value="{{$customer->email}}" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                      <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Password</label>
                      <input type="password" class="form-control"  name = "customers[password]" value="{{$customer->password}}" id="exampleInputPassword1" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" name = "customers[status]" id="ststus" value="{{$customer->status}}">
                          <option value="Enable" <?php if($customer->status == "Enable"){echo "selected";}?>>Enable</option>
                          <option value="Disable" <?php if($customer->status == "Disable"){echo "selected";}?>>Disable</option>
                        </select>
                      </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            
        </div>
    </div>
@endsection
