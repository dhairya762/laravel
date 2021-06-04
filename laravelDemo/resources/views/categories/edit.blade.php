@extends('layouts.theme')

@section('content')
<div class="row">
  <div class="col-md-6">
    <h3>Manage Category</h3>
    <ul id="tree1">
        <div class="row">
            <div class="row-md-2">
                <input type="button" class="btn btn-success add" value="Add Root Category" id="add-category">
                <input type="button" class="btn btn-success d-n" value="Add Sub Category" id="add-sub-category">
                <input type="button" class="btn btn-danger d-n" value="Delete" id="cat_del">
                {{-- <a href="#" id="add-category" class="btn btn-success add">Add Root Category</a><br> --}}
                {{-- <a href="#" id="add-sub-category" class="btn btn-success d-n">Add Sub Category</a><br> --}}
                {{-- <a href="#" id="cat_del" class="btn btn-danger d-n">Delete</a> --}}
            </div>
        </div>
        @foreach ($categories as $category)
            <li>
                <a href="javascript:void('0')" id="{{ $category->id }}" onclick="mage.setUrl('category/show/{{$category->id}}').setMethod('post').load();getCategoryEdit(this.id)">
                    {{ $category->name }}
                </a>

                @if (count($category->childs))
                    @include('categories/manageChild',['childs' => $category->childs])
                @endif
            </li>
        @endforeach
    </ul>
</div>
      <div class="col-10">
          <h1>Edit Category</h1>
            <form action="{{ url('categories/store/'.$id) }}" method="post">
                @csrf
                <select class="form-control" name = "category[parent_id]" id="parent_id">
                    @foreach ($categories as $value)
                    <option value="{{$value->id}}" <?php if($value->id == $category->parent_id){echo "selected";}?>>{{$value->name}}</option>
                    @endforeach
                </select>
                    <div class="form-group">
                      <label for="name">Name</label>
                      <input type="text" class="form-control"  value="{{$category->name}}" name = "category[name]" id="name" aria-describedby="emailHelp" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" name = "category[status]" id="ststus" value="{{$category->status}}">
                          <option value="Enable">Enable</option>
                          <option value="Disable">Disable</option>
                        </select>
                      </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
