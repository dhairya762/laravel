@extends('layouts.theme')
@section('content')
    <div class="container-fluid">
        <div class="panel panel-primary">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Manage Category</h3>
                        <div class="row">
                            <div class="row-md-2">
                                <a href="javascript:void(0)" id="add-category" class="btn btn-success add">Add
                                    Root Category</a><br>
                                <a href="javascript:void(0)" id="add-sub-category" class="btn btn-success d-n">Add Sub
                                    Category</a><br>
                                <a href="javascript:void(0)" id="cat_del" class="btn btn-danger d-n">Delete</a>
                            </div>
                        </div>
                        <ul id="tree1">
                            @foreach ($categories as $category)
                                <li id="main-{{ $category->id }}" class="{{ $category->id }}">
                                    <a href="javascript:void(0)" id="{{ $category->id }}"
                                        onclick="getCategoryEdit(this.id)">
                                        {{ $category->name }}
                                    </a>
                                    @if (count($category->childs))
                                        @include('categories/manageChild',['childs' => $category->childs])
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div id="content" class="col-md-6">
                        <div id="update-category" class="d-n add-category">
                            <h3>Add Root Category</h3>
                            <form action="{{ url('category/add_category') }}" method="POST" id="add_root">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="root_category" class="form-control" id="root_name"
                                        placeholder="Enter Name" required>
                                </div>
                                <input class="btn btn-success" type="button" value="Add"
                                   id="add_category">
                                    {{-- mage.setForm('add_root');"> --}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('script')
        <script src="{{ asset('js/treeview.js') }}"></script>
        <script>
        $( document ).ready(function() {
            $('#add_category').click(function () {
                 $.ajax({
                     type:'POST',
                     url:'category/add_category',
                     data:$("#add_root").serialize(),
                     success:function(data) {
                         //   $("#msg").html(data.msg);
                         console.log(data);
                         var data = data.category;
                         var newRow = "<li id='main-"+data.id+"' class='"+data.id+"'> <a href='javascript:void(0)' id='"+data.id+"' onclick='getCategoryEdit("+data.id+")'>"+data.name+"</a></li>";
                         console.log(newRow);
                         $("#tree1").append(newRow);
                         
                        }
                    });
            });
        })
    </script>
    @endsection
