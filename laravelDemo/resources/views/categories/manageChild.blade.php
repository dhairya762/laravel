<ul>
    @foreach ($childs as $child)
        <li>
            <a href="javascript:void(0)" id="{{ $child->id }}" onclick="getCategoryEdit(this.id)">
                {{ $child->name }}
            </a>
            @if (count($child->childs))
                @include('categories/manageChild',['childs' => $child->childs])
            @endif
        </li>
    @endforeach
</ul>
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
                // document.getElementById("add-category").className = "btn btn-success add d-n";
                document.getElementById("update-category").className = "col-md-6 d-n";
                // $('.add-category').className = "btn btn-success add d-n";
                $('#add-sub-category').removeClass('d-n');
                $('#cat_del').removeClass('d-n');
                $('#update-form').attr('action', 'category/update/' + data.id);
                $('#sub-form').attr('action', 'category/add/' + data.id);
                $('#cat_del').attr('href', 'category/destroy/' + data.id);
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

