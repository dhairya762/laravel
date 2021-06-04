@extends('layouts.theme')

@section('content')
<div class="row">
      <div class="col-8">
          <h1>Edit Product</h1>
            <form action="{{ url('products/store/'.$product->id) }}" method="post">
                @csrf
                    <div class="form-group">
                      <label for="sku">SKU</label>
                      <input type="text" class="form-control"  value="{{$product->sku}}" name = "products[sku]" id="first_name" aria-describedby="emailHelp" placeholder="SKU">
                    </div>
                    <div class="form-group">
                      <label for="name">Name</label>
                      <input type="text" class="form-control"  value="{{$product->name}}" name = "products[name]" id="last_name" aria-describedby="emailHelp" placeholder="Name">
                    </div>
                    <div class="form-group">
                      <label for="price">Price</label>
                      <input type="text" class="form-control"  name = "products[price]" value="{{$product->price}}" id="price" aria-describedby="emailHelp" placeholder="Price">
                    </div>
                    <div class="form-group">
                      <label for="discount">Discount</label>
                      <input type="text" class="form-control"  name = "products[discount]" value="{{$product->discount}}" id="discount" placeholder="Discount">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" name = "products[status]" id="ststus" value="{{$product->status}}">
                          <option value="Enable">Enable</option>
                          <option value="Disable">Disable</option>
                        </select>
                      </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            
        </div>
    </div>
@endsection
