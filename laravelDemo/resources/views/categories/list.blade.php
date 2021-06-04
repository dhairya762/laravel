@extends('layouts.theme')

@section('content')
@php
// echo "<pre>";
// print_r($path);
//     die;
@endphp
    <h1>List Page</h1>
    <a href="{{ url('categories/add/' . '0') }}"><button class="btn btn-primary">Add</button>
    </a><br><br>
    <div class="row">
        <div class="col table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">CategoryId</th>
                        <th scope="col">Name</th>
                        <th scope="col">ParentId</th>
                        <th scope="col">Path</th>
                        <th scope="col">Status</th>
                        <th colspan="2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $key => $category): ?>
                    <tr>
                        <td>{{$category->id}}</td>
                        <td>
                            @php
                                $categoryPath = explode('=', $category->path);
                            @endphp
                            @foreach ($categoryPath as $value)
                                {{ $path[trim($value)] }}
                                @if (!($loop->last))
                                @php
                                    echo "/";
                                @endphp
                                @endif
                            @endforeach
                        </td>
                        <td>{{$category->parent_id}}</td>
                        <td>
                            {{$category->path ?>
                            
                        </td>
                        <td>{{$category->status}}</td>
                        {{-- <td><?//= $category->created_at ?></td> --}}
                        {{-- <td><?//= $category->updated_at ?></td> --}}
                        <td>
                            <a href="{{ url('categories/add/' . $category->id) }}"><button class="btn btn-success">Edit</button></a>
                        </td>
                        <td>
                            <a href="{{ url('categories/destroy/' . $category->id) }}"><button onclink="del()" class="btn btn-danger">Delete</button></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
        <script>
            function del() {
                alert("Do you want to delete this item?");
            }
        </script>
@endsection
