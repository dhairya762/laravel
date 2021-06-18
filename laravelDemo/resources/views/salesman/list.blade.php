@extends('layouts.theme')
@section('content')
    {{-- <div class="row"> --}}
    <div class="container">
        <form action="{{ url('salesman/search') }}" method="post" id="salesman">
            @csrf
            <div class="input-group">
                <input type="search" id="form1" name="search" class="form-control" />
                <input type="button" class="btn btn-primary" onclick="mage.setForm('salesman')" value="Search">&nbsp;&nbsp;
                <input type="button" class="btn btn-success" id="add" value="Add"
                    onclick="mage.changeAction('salesman', 'salesman/create');">&nbsp;&nbsp;
                <input type="button" class="btn btn-success" id="clear" value="Clear" {{-- onclick="mage.setUrl('salesman', 'salesman/create');">&nbsp;&nbsp; --}}
                    onclick="mage.setUrl('salesman/clear').setMethod('get').resetParams().load();">&nbsp;&nbsp;
            </div>
        </form>
        <br><br>
        @if ($salesman)
            <table class="table">
                <thead>
                    <th>Id</th>
                    <th>Name</th>
                    <th colspan="2">Actions</th>
                </thead>
                @if ($salesman)
                    <tbody>
                        @foreach ($salesman as $key => $value)
                            <tr>
                                <td>{{ $value->id }}</td>
                                <td>{{ $value->name }}</td>
                                <td>
                                    <button class="btn btn-danger"
                                        onclick="mage.setUrl('salesman/destroy/{{ $value->id }}').setMethod('get').resetParams().load()">Delete</button>
                                </td>
                                <td>
                                    <button class="price btn btn-success"
                                        onclick="mage.setUrl('salesman/salesmanId/{{ $value->id }}').resetParams().setMethod('get').load()"
                                        id="{{ $value->id }}">Pricing</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                @else
                    <tr>No salesMan available.</tr>
                @endif
            </table>
        @endif
    </div>
    <br><br>
    <div class="container" id="product">
        @if (!$currentSalesMan)
            <center>
                <strong>
                    No SalesMan Available.
                </strong>
            </center>
        @else
            <h3>Manage Product</h3>
            <form action="{{ url('salesman/product') }}" method="POST" id="salesman_product">
                @csrf
                <input type="button" class="btn btn-success" id="update" value="Update">
                <div class="col table-responsive">
                    <table class="table ">
                        <tr>
                            <th>Id</th>
                            <th>SKU</th>
                            <th>Price</th>
                            <th>Salesman.Price</th>
                            <th>Salesman.Discount</th>
                        </tr>
                        @if ($currentSalesMan)
                            <tr>
                                <td></td>
                                <td><input type="textbox" name="salesman_product[sku]"></td>
                                <td><input type="textbox" name="salesman_product[price]"></td>
                                <td colspan="2">
                                    <input type="button" class="btn btn-primary" onclick="mage.setForm('salesman_product')"
                                        value="Add">
                                </td>
                            </tr>
                            <tbody>
                                @if ($products)
                                    @foreach ($products as $value)
                                        <tr id="{{ $value->price }}">
                                            <td>{{ $value->id }}</td>
                                            <td>{{ $value->sku }}</td>
                                            <td>{{ $value->price }}</td>
                                            <td>
                                                <input type="number" class="sprice"
                                                    id="{{ $value->salesman_id == $id ? $value->spp : '' }}"
                                                    name="sprice[{{ $value->id }}]"
                                                    value="{{ $value->salesman_id == $id ? $value->spp : '' }}">
                                            </td>
                                            <td>
                                                <input type="number" class="discount" name="sdiscount[{{ $value->id }}]"
                                                    value="{{ $value->salesman_id == $id ? $value->discount : 0 }}">
                                            </td>
                                            <script>
                                            </script>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        @else
                            <tr>No Salesman available.</tr>
                        @endif
                    </table>
                </div>
            </form>
        @endif
    </div>
    {{-- </div> --}}
    @php
    $show = session('show');
    $id = session('salesman_id');
    if (!$show) {
        $show = 0;
    }
    @endphp
@endsection
@section('script')
    <script>
        $('.sprice').change(function(e) {
            var td = e.target;
            var value = e.target.value;
            var price = e.target.parentElement.parentElement.id;
            if (parseInt(value) < parseInt(price)) {
                $(td).css("background-color", "red");
                $('#update').hide();
            }
            if (parseInt(value) >= parseInt(price)) {
                $(td).css("background-color", "");
                $('#update').show();
            }
        });

        if ( <?php echo $show; ?> ) {
            $('#product').show();
        } else {
            $('#product').hide();
        }

        $('#update').click(function() {
            $('#salesman_product').attr('action', 'salesman/update/<?= $id ?>');
            $('#salesman_product').attr('onclick', mage.setForm('salesman_product'));
        })

    </script>
@endsection
