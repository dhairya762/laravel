@extends('layouts.theme')

@section('content')
    @if ($id)
        <h1>Update Product</h1>
    @else
        <h1>Add Product</h1>
    @endif
    <div class="row">
        @if ($id != 0)
            <div class="col-3">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
                        The current link item
                    </a>
                    <input type="button" value="Product Media"
                        onclick="mage.setUrl('products/media/{{ $id }}').setMethod('get').load();">
                </div>
            </div>
        @endif
        <div class="col-9">
            <form action="{{ url('products/store/' . $id) }}" method="post" id='product_form'>
                @csrf
                <div class="form-group">
                    <label for="sku">SKU</label>
                    <input type="text" class="form-control"
                        value="{{ isset($product->sku) && $product['sku'] != '' ? $product['sku'] : '' }}"
                        name="products[sku]" id="sku" aria-describedby="emailHelp" placeholder="SKU" required>
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control"
                        value="{{ isset($product->name) && $product['name'] != '' ? $product['name'] : '' }}"
                        name="products[name]" id="name" aria-describedby="emailHelp" placeholder="Name" required>
                </div>
                <div class="form-group">
                    <label for="status">Category</label>
                    <select class="form-control"
                        value="{{ isset($product->category) && $product['category'] != '' ? $product['category'] : '' }}"
                        name="products[category]" id="category" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->name }}"
                                {{ $product['category'] == $category->name ? 'selected' : '' }}>{{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" class="form-control"
                        value="{{ isset($product->price) && $product['price'] != '' ? $product['price'] : '' }}"
                        name="products[price]" id="price" aria-describedby="emailHelp" placeholder="Price" required>
                </div>
                <div class="form-group">
                    <label for="discount">Discount</label>
                    <input type="number" class="form-control"
                        value="{{ isset($product->discount) && $product['discount'] != '' ? $product['discount'] : '' }}"
                        name="products[discount]" id="discount" placeholder="Discount" required>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control"
                        value="{{ isset($product->status) && $product['status'] != '' ? $product['status'] : '' }}"
                        name="products[status]" id="ststus" required>
                        <option value="Enable" {{ $product['status'] == 'Enable' ? 'selected' : '' }}>Enable</option>
                        <option value="Disable" {{ $product['status'] == 'Disable' ? 'selected' : '' }}>Disable</option>
                    </select>
                </div>
                <input type="button" value="Submit" onclick="mage.setForm('product_form');">
            </form>
        </div>
    </div>
@endsection
