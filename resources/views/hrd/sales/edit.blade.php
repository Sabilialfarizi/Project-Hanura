@extends('layouts.master', ['title' => 'Edit Team Sales'])

@section('content')
<div class="row justify-content-center text-center">
    <div class="col-md-6">
        <h4 class="page-title">Edit Team Sales</h4>
    </div>
</div>

<form action="{{ route('hrd.sales.update', $sale->id) }}" method="post" enctype="multipart/form-data">
    @method('PATCH')
    @csrf
    <div class="row justify-content-left text-left">
        <div class="col-md-12">
            <div class="card shadow" id="card">
                <div class="card-body">
    
                    
                    <div class="form-group">
                        <label for="id_manager">Nama Manager Marketing</label>
                        <select name="id_manager" required="" id="id_manager" class="form-control">
                            <option disabled selected>-- Select Nama Manager Marketing --</option>
                            @foreach($manager_marketing as $manager_marketings)
                            <option {{ $team->id_manager == $manager_marketings->id ? 'selected' : '' }}
                                value="{{ $manager_marketings->id }}">{{ $manager_marketings->name }}</option>
                                @endforeach
                            </select>
    
                        @error('id_manager')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="user_id">Nama Spv</label>
                        <select name="user_id" id="user_id" class="form-control">
                            <option disabled selected>-- Select Nama SPV --</option>
                            @foreach($spv as $spvs)
    
                            <option {{ $team->user_id == $spvs->id ? 'selected' : '' }} value="{{ $spvs->id }}">
                                {{ $spvs->name }}</option>
                            @endforeach
                        </select>
    
                        @error('user_id')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="id_sales">Nama Sales </label>
                        <select name="id_sales[]" id="id_sales"  class="form-control select2" multiple="multiple">
                           
                            @foreach($sale->sales as $pur)
                                    <option selected value="{{ $pur->id_sales }}">{{ $pur->user->name }}</option>
                            @endforeach
                            @foreach($staff_marketing as $staff)
                            <option value="{{ $staff->id }}">
                                {{ $staff->name }}</option>
                            @endforeach
                        </select>
    
                        @error('id_sales')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    
                    
                    <div class="m-t-20 text-center">
                        <button type="submit" class="btn btn-primary submit-btn"><i class="fa fa-save"></i> Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    </html>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script>
        $(document).ready(function () {
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
    
</form>
@stop

@section('footer')
<script>
    $(".select2").select2()
</script>
@stop