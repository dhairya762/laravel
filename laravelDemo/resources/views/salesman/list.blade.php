@extends('layouts.theme')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <form action="{{ url('salesman/search') }}" method="post" id="salesman">
                @csrf
                <div class="input-group">
                    <input type="search" id="form1" name="search" class="form-control" value="{{$search != null ? $search : ''}}" />
                    <input type="button" id="search" class="btn btn-primary" onclick="mage.setForm('salesman');" value="Search">&nbsp;&nbsp;
                    <input type="button" class="btn btn-success" id="add" value="Add" onclick="mage.changeAction('salesman', 'salesman/create')">&nbsp;&nbsp;
                    <input type="button" class="btn btn-success" id="clear" value="Clear" {{-- onclick="mage.setUrl('salesman', 'salesman/create');">&nbsp;&nbsp; --}}
                        onclick="mage.setUrl('salesman/clear').setMethod('get').resetParams().load();">
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
                                        {{-- <button class="price btn btn-success selected""{{()}}" --}}
                                        <button
                                            class="{{ $id == $value->id ? 'price btn btn-success selected' : 'price btn btn-success' }}"
                                            onclick="mage.setUrl('salesman/salesmanId/{{ $value->id }}').resetParams().setMethod('get').load()"
                                            id="{{ $value->id }}">Pricing</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    @else
                        <center>
                            <strong>
                                No Salesman Available.
                            </strong>
                        </center>
                        </tr>
                    @endif
                </table>
            @endif
        </div>
        <div class="col-md-6">
            <div id="product">
                <h3>Manage Product</h3>
                <form action="{{ url('salesman/product') }}" method="POST" id="salesman_product">
                    @csrf
                    @if ($id)

                        <input type="button" class="btn btn-success" id="update" value="Update"
                            onclick="mage.changeAction('salesman_product', 'salesman/update/{{ $id }}')">
                    @endif
                    <div class="col table-responsive">
                        <table class="table ">
                            @if ($currentSalesMan)
                                <tr>
                                    <th>Id</th>
                                    <th>SKU</th>
                                    <th>Price</th>
                                    <th>Salesman.Price</th>
                                    <th>Salesman.Discount</th>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><input type="textbox" name="salesman_product[sku]"></td>
                                    <td><input type="textbox" name="salesman_product[price]"></td>
                                    <td colspan="2">
                                        <input type="button" class="btn btn-primary"
                                            onclick="mage.setForm('salesman_product')" value="Add">
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
                                                    <input type="number" class="discount"
                                                        name="sdiscount[{{ $value->id }}]"
                                                        value="{{ $value->salesman_id == $id ? $value->discount : 0 }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            @else
                                <tr>
                                    <center>
                                        <strong>
                                            No Salesman Selected.
                                        </strong>
                                    </center>
                                </tr>
                            @endif
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @php
    $show = session('show');
    // $id = session('salesman_id');
    if (!$show) {
        $show = 0;
    }
    @endphp
@endsection
@section('script')
    <script>
        $('.sprice').change(function(e) {
            var td = $(e.target);
            var value = $(e.target).val();
            // var price = e.target.parentElement.parentElement.id;
            var price = $(e.target).parent().parent().attr('id');
            if (parseInt(value) < parseInt(price)) {
                $(td).css("background-color", "red");
                $('#update').hide();
                alert('Salesman Prics should be more than or equal to Product Price');
            }
            if (parseInt(value) >= parseInt(price)) {
                $(td).css("background-color", "");
                $('#update').show();
            }
        });

        if ("<?php echo $show; ?>") {
            $('#product').show();
        } else {
            $('#product').hide();
        }

        var data = $('#form1').text();
        $('#form1').change(function() {
            $('#search').show();
            $('#add').show();
        });

        if (!data) {
            $('#search').attr('onclick', "mage.setForm('salesman')");
            $('#search').hide();
            $('#add').hide();
        } 
        // else {
        //     $('#search').attr('onclick', "mage.setForm('salesman')");
        //     $('#add').attr('onclick', "mage.changeAction('salesman', 'salesman/create');");
        // }
        // $('#update').click(function() {
        //     $('#salesman_product').attr('action', 'salesman/update/<?= $id ?>');
        //     $('#salesman_product').attr('onclick', mage.setForm('salesman_product'));
        // })
    </script>
@endsection
