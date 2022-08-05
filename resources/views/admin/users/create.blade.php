@extends('layouts.master', ['title' => 'Add User'])

@section('content')
<div class="row justify-content-center">
    <div class="col-sm-6">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow" id="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h4 class="page-title">Add User</h4>
                                </div>
                            </div>

                            <form action="{{ route('admin.users.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @include('admin.users.form')

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('footer')
<script>
    $(".select2").select2()

</script>
@stop
