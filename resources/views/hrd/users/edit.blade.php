@extends('layouts.master', ['title' => 'Edit User'])

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h4 class="page-title">Edit User</h4>
    </div>
</div>

<form action="{{ route('hrd.users.update', $user->id) }}" method="post" enctype="multipart/form-data">
    @method('PATCH')
    @csrf
      @include('hrd.users.form')
</form>
@stop

@section('footer')
</html>
<script>
    $(document).ready(function () {
            $('.select2').select2();
            $('.dynamic').change(function () {
                var id = $(this).val();
                var div = $(this).parent();
                var op = "";
                $.ajax({
                    url: `/hrd/where/project`,
                    method: "get",
                    data: {
                        'id': id
                    },
                    success: function (data) {
                        console.log(data);
                        for (var i = 0; i < data.length; i++) {
                            op += '<option value="' + data[i].nama_project + '">' + data[i]
                                .nama_project + '</option>'
                        };
                        $('.root1').html(op);
                    },
                    error: function () {

                    }
                })
            })
        })

</script>
@stop