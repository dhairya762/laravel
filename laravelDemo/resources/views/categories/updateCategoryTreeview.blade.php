{{-- @extends('layouts.theme') --}}
<!DOCTYPE html>
<html>
<head>
	<title>Laravel Category Treeview Example</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link href="/css/treeview.css" rel="stylesheet">
</head>
<body>
	<div class="container">     
		<div class="panel panel-primary">
	  		<div class="panel-body">
	  			<div class="row">
	  				<div class="col-md-6">
	  					<h3>Category List</h3>
				        <ul id="tree1">
				            @foreach($categories as $category)
                            <a href="{{url('category/edit/'.$category->id)}}" class="btn btn-success">Edit</a>
							    <a href="{{url('category/destroy/'.$category->id)}}"  class="btn btn-danger">Delete</a>
				                <li>
				                    {{ $category->name }}
				                    @if(count($category->childs))
				                        @include('categories/manageChild',['childs' => $category->childs])
				                    @endif
				                </li>
				            @endforeach
				        </ul>
	  				</div>
                    <div class="col-md-6">
                    <h3>Update Category</h3>
                    <form action="{{url('category/update/'.$id)}}" method="POST" id="update_category_form">
                    @csrf
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Catgory Name:</strong>
                                <input type="text" name="name" class="form-control" value="{{$currentCategory->name }}" placeholder="Address">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Parent Category:</strong>
                                <select name="parent_id" class="form-control">
                                <option value="0" <?php if($currentCategory->parent_id==0){echo "selected";}?>>Root Category</option>
                                <?php foreach($allCategories as $key=>$value):?>
                                     <option value="{{$value->id}}" <?php if($value->id==$currentCategory->parent_id){echo "selected";}?>>{{$value->name}}</option>
                                <?php endforeach;?>     
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="button" class="btn btn-primary" onclick="mage.setForm('update_category_form');">Submit</button>
                        </div>
                    </form>
                    </div>
	  			</div>
        </div>
    </div>
    <script src="/js/treeview.js"></script>
</body>
</html>