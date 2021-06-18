<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ config('app.name', 'Project Title Default') }}</title>

    <!-- Fonts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/treeview.css" rel="stylesheet">
    <link href="/css/custom.css" rel="stylesheet">
    <script src="{{ asset('js/mage.js') }}"></script>
</head>

<body>
    <div id="content">
        <nav class="navbar sticky-top navbar-expand-lg navbar-light bg-success">
            <a class="navbar-brand" href="{{ url('dashboard') }}">Home</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" onclick="mage.setUrl('products').setMethod('get').load();" href="javascript:void(0)">Product<span
                                class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" onclick="mage.setUrl('customers').setMethod('get').removeParam().load();" href="javascript:void(0)">Customer<span class="sr-only"></span></a>
                    </li>
                    {{-- <li class="nav-item active">
                        <a class="nav-link" onclick="mage.setUrl('categories-new').setMethod('get').removeParam().load();" href="javascript:void(0)">Category<span class="sr-only"></span></a>
                    </li> --}}
                    <li class="nav-item active">
                        <a class="nav-link" onclick="mage.setUrl('category').setMethod('get').removeParam().load();" href="javascript:void(0)">Category<span class="sr-only"></span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" onclick="mage.setUrl('payment').setMethod('get').removeParam().load();" href="javascript:void(0)">Payment<span class="sr-only"></span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" onclick="mage.setUrl('shipping').setMethod('get').removeParam().load();" href="javascript:void(0)">Shipping<span class="sr-only"></span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" onclick="mage.setUrl('cart').setMethod('get').removeParam().load();" href="javascript:void(0)">Cart<span class="sr-only"></span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" onclick="mage.setUrl('placeorder').setMethod('get').removeParam().load();" href="javascript:void(0)">PlaceOrder<span class="sr-only"></span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" onclick="mage.setUrl('csv').setMethod('get').removeParam().load();" href="javascript:void(0)">CSV<span class="sr-only"></span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" onclick="mage.setUrl('salesman').setMethod('get').removeParam().load();" href="javascript:void(0)">SalesMan<span class="sr-only"></span></a>
                    </li>
                </ul>
                {{-- <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form> --}}
            </div>
        </nav>
        <div class="clearfix"></div>
        <br>
        <div class="container">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-danger">
                    <p>{{ $message }}</p>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
            <!-- Footer -->
            <footer class="page-footer font-small blue">

                <div class="footer-copyright text-center py-3">
                    <h1>
                        <center>Smile is the best medicine for all the situations.</center>
                    </h1>
                </div>
            </footer>
        </div>
    </div>
</body>
<!-- Footer -->
@yield('script')

</html>
