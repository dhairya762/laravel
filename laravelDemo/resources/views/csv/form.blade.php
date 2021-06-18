@extends('layouts.theme')
@section('content')
<div class="row">
    <div class="col md">
        <form id="upload_media" action="{{ url('csv/import') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="file" name="image" id="image">
            <input type="button" onclick="mage.setImage('upload_media');" class="btn btn-success" name="file"
                value="Upload">
        </form>
    </div>
</div>
<div class="clearflex"><br><br><br></div>
<div class="row">
    <div class="col md">
        <div class="text-center">
            <form id="export_media" method="post" enctype="multipart/form-data">
                @csrf
                <input id="export" type="button" value="Export" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>
<a class="d-n" id="download">Download</a>
@endsection
@section('script')
<script>
    $("#export").click(function() {
        // var csv = "csv";
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: 'csv/exportIntoCSV',
            success: function(data) {
                // setTimeout(function() {
                //     var dlbtn = document.getElementById("download");
                //     var file = new Blob([data], {
                //         type: 'text/csv'
                //     });
                //     dlbtn.href = URL.createObjectURL(file);
                //     dlbtn.download = 'myfile.csv';
                //     console.log(dlbtn);
                //     dlbtn.click();
                // }, 2000);
                var dlbtn = document.getElementById("download");
                var file = new Blob([data], {
                    type: 'text/csv'
                });
                dlbtn.href = URL.createObjectURL(file);
                dlbtn.download = 'myfile.csv';
                console.log(dlbtn);
                dlbtn.click();
            }
        });
    });

</script>
@endsection

