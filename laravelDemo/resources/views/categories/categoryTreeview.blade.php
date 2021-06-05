@extends('layouts.theme')
@section('content')
    <div class="container-fluid">
        <div class="panel panel-primary">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Manage Category</h3>
                        <ul id="tree1">
                            <div class="row">
                                <div class="row-md-2">
                                    <a href="javascript:void(0)" id="add-category" class="btn btn-success add">Add
                                        Root Category</a><br>
                                    <a href="javascript:void(0)" id="add-sub-category" class="btn btn-success d-n">Add Sub
                                        Category</a><br>
                                    <a href="javascript:void(0)" id="cat_del" class="btn btn-danger d-n">Delete</a>
                                </div>
                            </div>
                            @foreach ($categories as $category)
                                <li>
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
                                    <input type="text" name="name" class="form-control" id="root_name"
                                        placeholder="Enter Name" required>
                                </div>
                                <input class="btn btn-success" type="button" value="Add"
                                    onclick="mage.setForm('add_root');">
                            </form>
                        </div>
                        <div id="GFG_DOWN" class="d-n update-category">
                            <h3>Update Category</h3>
                            <form id="update-form" action="" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Catgory Name:</strong>
                                            <input type="text" id="name" name="name" class="form-control"
                                                placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Parent Category:</strong>
                                            <select name="parent_id" id="parentName" class="form-control">
                                                <option value="0">Root Category</option>
                                                @foreach ($allCategories as $value)
                                                    @php
                                                        $categoryPath = explode('=', $value->path);
                                                    @endphp
                                                    <option id="parent_id" value="{{ $value->id }}">
                                                        @foreach ($categoryPath as $value2)
                                                            {{ $path[trim($value2)] }}
                                                            @if (!$loop->last)
                                                                @php
                                                                    echo '/';
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                        <input type="button" class="btn btn-primary" value="Submit"
                                            onclick="mage.setForm('update-form');">
                                    </div>
                            </form>
                        </div>
                    </div>
                    <div id="sub-cat" class="d-n add-sub-category">
                        <h3>Add Sub Category</h3>
                        <form id="sub-form" action="" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="sub-parentName">Parent Category</label>
                                        <select name="parent_id" id="sub-parentName" class="form-control">
                                            <option id="sub-parent_id" value="0">Root Category</option>
                                            @foreach ($allCategories as $value)
                                                @php
                                                    $categoryPath = explode('=', $value->path);
                                                @endphp
                                                <option id="sub-parent_id" value="{{ $value->id }}">
                                                    @foreach ($categoryPath as $value2)
                                                        {{ $path[trim($value2)] }}
                                                        @if (!$loop->last)
                                                            @php
                                                                echo '/';
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <input type="button" class="btn btn-primary" value="Submit"
                                    onclick="mage.setForm('sub-form');">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/treeview.js') }}"></script>
    <script>
        $('#add-category').click(function() {
            $('.add-category').removeClass('d-n');
            $('#GFG_DOWN').addClass('d-n');
            $('#sub-cat').addClass('d-n');
            $('#update-category').removeClass('d-n');
        });
        $('#add-sub-category').click(function() {
            // document.getElementById(GFG_DOWN").className = "col-md-6 d-n"; 
            $('#GFG_DOWN').addClass('d-n');
            // $('#add-sub-category').removeClass('d-n');
            $('#sub-cat').removeClass('d-n');
            $('#update-category').addClass('d-n');
        });


        function getCategoryEdit(id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: 'category/show/' + id,
                data: '_token = <?php echo csrf_token(); ?>',
                success: function(data) {
                    $('#sub-cat').addClass('d-n');
                    $('#update-category').addClass('d-n');
                    // document.getElementById("add-category").className = "btn btn-success add d-n";
                    // document.getElementById("update-category").className = "col-md-6 d-n";
                    document.getElementById("update-category").className = "d-n";
                    // $('.add-category').className = "btn btn-success add d-n";
                    $('#add-sub-category').removeClass('d-n');
                    $('#cat_del').removeClass('d-n');
                    $('#update-form').attr('action', 'category/update/' + data.id);
                    $('#sub-form').attr('action', 'category/add/' + data.id);
                    $('#cat_del').attr('onclick', "mage.setUrl('category/destroy/" + data.id +"').setMethod('get').load()");
                    $('#GFG_DOWN').removeClass('d-n');
                    var name = data.name;
                    var parent_id = data.parent_id;
                    var id = data.id;
                    console.log(id);
                    document.getElementById("parentName").value = parent_id;
                    document.getElementById("sub-parentName").value = id;
                    document.getElementById("name").value = name;
                }
            });
        }

    </script>
@endsection
