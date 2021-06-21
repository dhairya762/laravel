@extends('layouts.theme')

@section('content')
    <h1>Order List Page</h1>

    <div class="col-md-2">
        <form id="select_customer" action="{{ url('placeorder') }}" method="get">
            @csrf
            <div class="form-group">
                <label for="exampleFormControlSelect1">Example select</label>
                <select name="customer_id" class="form-control" id="exampleFormControlSelect1"
                    onchange="mage.setForm('select_customer')">
                    <option value="0" selected disabled>Select Customer</option>
                    @foreach ($customers as $name)
                        <option value="{{ $name->id }}" {{ $name->id == $customer_id ? 'selected' : '' }}>
                            {{ $name->first_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div><br><br>
    <div class="row">
        <div class="col table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">OrderId</th>
                        <th scope="col">CustomerId</th>
                        <th scope="col">Total</th>
                        <th scope="col">Discount</th>
                        <th scope="col">Payment_Method</th>
                        <th scope="col">Shipping_Method</th>
                        <th scope="col">Shipping_Amount</th>
                        <th scope="col">Created Date</th>
                        <th scope="col">Updated Date</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                @if (count($orders) <= 0)
                    <tr>
                        <td colspan="9">No Data available.</td>
                    </tr>
                @else
                    <tbody>
                        @foreach ($orders as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->customer_id }}</td>
                                <td>{{ $item->total }}</td>
                                <td>{{ $item->discount }}</td>
                                <td>{{ $item->payment_method_id }}</td>
                                <td>{{ $item->shipping_method_id }}</td>
                                <td>{{ $item->shipping_amount }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->updated_at }}</td>
                                <td>
                                    <input type="button" class="btn btn-primary"
                                        onclick="mage.setUrl('placeorder/show/{{ $item->id }}').setMethod('get').load();"
                                        value="Show">
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
            <form id="paginate" action="{{ url('placeorder') }}" method="GET">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label for="records_per_page">Records Per Page</label>
                            <select name="records_per_page" id="records_per_page" onchange="mage.setForm('paginate')">
                                <option value="Select" {{ session('paginate') < 3 ? 'selected' : '' }}>Select</option>
                                <option value="1" {{ session('paginate') == 1 ? 'selected' : '' }}>1</option>
                                <option value="2" {{ session('paginate') == 2 ? 'selected' : '' }}>2</option>
                                <option value="3" {{ session('paginate') == 3 ? 'selected' : '' }}>3</option>
                                <option value="5" {{ session('paginate') == 5 ? 'selected' : '' }}>5</option>
                                <option value="10" {{ session('paginate') == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ session('paginate') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ session('paginate') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ session('paginate') == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            @for ($i = 1; $i <= $totalPage; $i++)
                <a href="javascript:void(0)" name="page" value="{{ $i }}"
                    onclick="mage.setUrl('placeorder/page={{ $i }}').setMethod('get').load();"
                    id="{{ $i }}" onclick="pagination()" class="btn btn-primary">{{ $i }}</a>
            @endfor
        </div>
    </div>
@endsection
