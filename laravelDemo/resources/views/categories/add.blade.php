<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Project Title Default') }}</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link href="/css/treeview.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

	<div class="container-fluid"> 
		<nav class="navbar sticky-top navbar-expand-lg navbar-light bg-success">
        <a class="navbar-brand" href="{{url('dashboard')}}">Home</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ url('products') }}">Product<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ url('customers') }}">Customer<span class="sr-only"></span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ url('category') }}">Category<span class="sr-only"></span></a>
                </li>
            </ul>
            {{-- <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form> --}}
        </div>
    </nav>    
		<div class="panel panel-primary">
	  		<div class="panel-body">
	  			<div class="row">
	  				<div class="col-md-6">
	  					<h3>Manage Category</h3>
				        <ul id="tree1">
				            @foreach($categories as $category)
								{{-- <a href="{{url('category/edit/'.$category->id)}}" class="btn btn-success">Edit</a> --}}
							    {{-- <a href="{{url('category/destroy/'.$category->id)}}"  class="btn btn-danger">Delete</a> --}}
				                <li>
				                    {{ $category->name }}
									
				                    @if(count($category->childs))
				                    <button>
										@include('categories/manageChild',['childs' => $category->childs])
									</button>    
				                    @endif
				                </li>
				            @endforeach
				        </ul>
	  				</div>
	  				<div class="col-md-6">
	  					<h3>Add New Category</h3>
				  			{!! Form::open(['route'=>'add.category']) !!}

				  				@if ($message = Session::get('success'))
									<div class="alert alert-success alert-block">
										<button type="button" class="close" data-dismiss="alert">×</button>	
									        <strong>{{ $message }}</strong>
									</div>
								@endif


				  				<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
									{!! Form::label('name:') !!}
									{!! Form::text('name', old('name'), ['class'=>'form-control', 'placeholder'=>'Enter name']) !!}
									<span class="text-danger">{{ $errors->first('name') }}</span>
								</div>


								{{-- <div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
									{!! Form::label('Category:') !!}
									{!! Form::select('parent_id',$allCategories, old('parent_id'), ['class'=>'form-control', 'placeholder'=>'Root Category']) !!}
									<span class="text-danger">{{ $errors->first('parent_id') }}</span>
								</div> --}}


								<div class="form-group">
									<button class="btn btn-success">Add New Root Category</button>
								</div>
				  			{!! Form::close() !!}
	  				</div>
	  			</div>
        </div>
    </div>
    <script src="/js/treeview.js"></script>
</body>
</html>