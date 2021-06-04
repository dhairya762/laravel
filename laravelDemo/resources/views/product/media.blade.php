@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-10">
            <h1>
                <center>Product Media</center>
            </h1>
            <form action="{{ url('products/save-media/' . $id) }}" method="post" enctype="multipart/form-data" id="media_form">
                @csrf
                <input type="button" value="Update" class="btn btn-success" onclick="mage.setForm('media_form');">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Label</th>
                            <th scope="col">Small</th>
                            <th scope="col">Thumb</th>
                            <th scope="col">Base</th>
                            <th scope="col">Gallery</th>
                            <th scope="col">Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($media) <= 0)
                            <tr>
                                <td colspan="7">No media avaialable.</td>
                            </tr>
                        @else
                        @foreach ($media as $value)
                        <tr>
                            <td><img src="{{ asset('upload\product\\').$value->image }}" alt="{{ $value->image }}" height="100" , width="100">
                            </td>
                            <td><input type="text" name="label[{{$value->id}}]"
                                value="{{$value->label}}" required></td>
                                <td><input type="radio" name="small" value="{{$value->id}}" {{($value->small) ? 'checked' : '' }}>
                            </td>
                            <td><input type="radio" name="thumb" value="{{$value->id}}" {{($value->thumb) ? 'checked' : ''}}>
                            </td>
                            <td><input type="radio" name="base" value="{{$value->id}}" {{($value->base) ? 'checked' : ''}}>
                            </td>
                            <td><input type="checkbox" name="gallery[{{$value->id}}]" {{($value->gallery) ? 'checked' : ''}}>
                            </td>
                            <td><input type="checkbox"
                                name="delete[{{$value->id}}]"></td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                
            </form>
            <form id="upload_media" action="{{url('products/upload-media/'. $id)}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="file" name="image" id="image">
                <input type="button" onclick="mage.setImage('upload_media');" class="btn btn-success" name="image" value="Upload">
            </form>
        </div>
    @endsection
    @section('script')
    @endsection
