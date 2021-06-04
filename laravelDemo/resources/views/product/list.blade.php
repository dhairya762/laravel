@extends('layouts.theme')

@section('content')
    <h1>Product List Page</h1>
        <input type="button" value="Add" class="btn btn-success" onclick="mage.setUrl('products/add/0').setMethod('get').load();">
    <br><br>
    <div class="row">
        <div class="col table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ProductId</th>
                        <th scope="col">SKU</th>
                        <th scope="col">Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Price</th>
                        <th scope="col">Discount</th>
                        <th scope="col">Status</th>
                        <th scope="col">Created Date</th>
                        <th scope="col">Updated Date</th>
                        <th scope="col" colspan="2">Action</th>
                    </tr>
                </thead>
                @if (count($products) <= 0)
                <tr>
                    <td colspan="9">No Data available.</td>
                </tr>
                @else
                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <td>{{$product->id}}</td>
                                    <td>{{$product->sku}}</td>
                                    <td>{{$product->name}}</td>
                                    <td>{{$product->category}}</td>
                                    <td>{{$product->price}}</td>
                                    <td>{{$product->discount}}</td>
                                    <td>{{$product->status}}</td>
                                    <td>{{$product->created_at}}</td>
                                    <td>{{$product->updated_at}}</td>
                                    <td>
                                        <input type="button" class="btn btn-success" onclick="mage.setUrl('products/add/{{$product->id}}').setMethod('get').load();"value="Edit">
                                    </td>
                                    <td>
                                        <input type="button" class="btn btn-danger" onclick="mage.setUrl('products/destroy/{{$product->id}}').setMethod('get').load();"value="Delete">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            @endif
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <form id="paginate" action="{{ url('products') }}" method="GET">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="records_per_page">Records Per Page</label>
                                        <select name="records_per_page" id="records_per_page" onchange="mage.setForm('paginate')">
                                            <option value="Select"{{(session('paginate') < 3 ? 'selected' : '')}}>Select</option>
                                            <option value="1" {{(session('paginate') == 1 ? 'selected' : '')}}>1</option>
                                            <option value="2" {{(session('paginate') == 2 ? 'selected' : '')}}>2</option>
                                            <option value="3" {{(session('paginate') == 3 ? 'selected' : '')}}>3</option>
                                            <option value="5" {{(session('paginate') == 5 ? 'selected' : '')}}>5</option>
                                            <option value="10" {{(session('paginate') == 10 ? 'selected' : '')}}>10</option>
                                            <option value="25" {{(session('paginate') == 25 ? 'selected' : '')}}>25</option>
                                            <option value="50" {{(session('paginate') == 50 ? 'selected' : '')}}>50</option>
                                            <option value="100" {{(session('paginate') == 100 ? 'selected' : '')}}>100</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form> 
                    </div>
                <div class="col-md-6">
                    @for ($i = 1; $i <= $totalPage; $i++)
                        <a href="javascript:void(0)" name="page" value="{{$i}}" onclick="mage.setUrl('products/page={{$i}}').setMethod('get').load();" id="{{$i}}" onclick="pagination()" class="btn btn-primary">{{$i}}</a>
                    @endfor
                </div>
@endsection