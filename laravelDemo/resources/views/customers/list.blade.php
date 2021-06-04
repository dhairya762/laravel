@extends('layouts.theme')

@section('content')
    <h1>Customer List Page</h1>
    <button class="btn btn-primary" onclick="mage.setUrl('customers/add/0').setMethod('get').load();">Add</button>
    <br><br>
    <div class="row">
        <div class="col table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">CustomerId</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Password</th>
                        <th scope="col">Status</th>
                        <th scope="col">Address</th>
                        <th scope="col">City</th>
                        <th scope="col">State</th>
                        <th scope="col">Country</th>
                        <th scope="col">ZipCode</th>
                        <th scope="col">Address Type</th>
                        <th scope="col">Created Date</th>
                        <th scope="col">Updated Date</th>
                        <th scope="col" colspan="2">Action</th>
                    </tr>
                </thead>
                <tbody id="customer-data">
                    @if (count($customers) <= 0)
                        <tr>
                            <td colspan="16">No customer available in database.</td>
                        </tr>
                    @else
                        @foreach ($customers as $customer)
                            @if ($customer->address_type != 'shipping')
                                <tr>
                                    <td>{{ $customer->id }}</td>
                                    <td>{{ $customer->first_name }}</td>
                                    <td>{{ $customer->last_name }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->password }}</td>
                                    <td>{{ $customer->status }}</td>
                                    <td>{{ $customer->address }}</td>
                                    <td>{{ $customer->city }}</td>
                                    <td>{{ $customer->state }}</td>
                                    <td>{{ $customer->country }}</td>
                                    <td>{{ $customer->zipcode }}</td>
                                    <td>{{ $customer->address_type }}</td>
                                    <td>{{ $customer->created_at }}</td>
                                    <td>{{ $customer->updated_at }}</td>
                                    <td>
                                        <button class="btn btn-success"
                                            onclick="mage.setUrl('customers/add/{{ $customer->id }}').setMethod('get').load()">Edit</button>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger"
                                            onclick="mage.setUrl('customers/destroy/{{ $customer->id }}').setMethod('get').load()">Delete</button>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <form id="paginate" action="{{ url('customers') }}" method="GET">
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
            <a href="javascript:void(0)" name="page" value="{{$i}}" onclick="mage.setUrl('customers/page={{$i}}').setMethod('get').load();" id="{{$i}}" onclick="pagination()" class="btn btn-primary">{{$i}}</a>
        @endfor
        </div>
@endsection
