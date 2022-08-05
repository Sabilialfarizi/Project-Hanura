@extends('layouts.master', ['title' => 'Attendance'])

@section('content')
<div class="row">
    <div class="col-sm-12">
        <h4 class="page-title">Attendance Sheet</h4>
    </div>
</div>

<form action="{{ route('admin.attendance.search') }}" method="GET" id="TheSubmitFormForFilterAttendance">
    <div class="row filter-row">
        <div class="col-sm-6 col-md-6">
            <div class="form-group form-focus">
                <label class="focus-label">Employee Name</label>
                @csrf
                <input type="text" value="{{ old('pegawai') }}" class="form-control floating" name="pegawai">
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="form-group form-focus select-focus">
                <label class="focus-label">Select Month</label>
                <select class="select floating" name="month" onchange="TheSubmitFormForFilterAttendance()">
                    <option value="">-</option>
                    <option @if($month == "01") selected @endif value="01">Jan</option>
                    <option @if($month == "02") selected @endif value="02">Feb</option>
                    <option @if($month == "03") selected @endif value="03">Mar</option>
                    <option @if($month == "04") selected @endif value="04">Apr</option>
                    <option @if($month == "05") selected @endif value="05">May</option>
                    <option @if($month == "06") selected @endif value="06">Jun</option>
                    <option @if($month == "07") selected @endif value="07">Jul</option>
                    <option @if($month == "08") selected @endif value="08">Aug</option>
                    <option @if($month == "09") selected @endif value="09">Sep</option>
                    <option @if($month == "10") selected @endif value="10">Oct</option>
                    <option @if($month == "11") selected @endif value="11">Nov</option>
                    <option @if($month == "12") selected @endif value="12">Dec</option>
                </select>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="form-group form-focus select-focus">
                <label class="focus-label">Select Year</label>
                <select class="select floating" name="year" onchange="TheSubmitFormForFilterAttendance()">
                    <option value="">-</option>
                    <option @if($year == '2023') selected @endif>2023</option>
                    <option @if($year == '2022') selected @endif>2022</option>
                    <option @if($year == '2021') selected @endif>2021</option>
                    <option @if($year == '2020') selected @endif>2020</option>
                    <option @if($year == '2019') selected @endif>2019</option>
                    <option @if($year == '2018') selected @endif>2018</option>
                    <option @if($year == '2017') selected @endif>2017</option>
                    <option @if($year == '2016') selected @endif>2016</option>
                    <option @if($year == '2015') selected @endif>2015</option>
                    <option @if($year == '2014') selected @endif>2014</option>
                    <option @if($year == '2013') selected @endif>2013</option>
                </select>
            </div>
        </div>
    </div>
</form>
@if($message = Session::get('error'))
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-danger">
            {{ $message }}
        </div>
    </div>
</div>
@endif

@if($message = Session::get('success'))
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-success">
            {{ $message }}
        </div>
    </div>
</div>
@endif
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div>
                        <a href="{{ route('admin.attendance.update_user', [$month,$year]) }}" class="btn btn-info text-light btn-block" id="tombol-hapus" value="delete">Update User {{ $year }} {{ $month }}</a>
                    </div>
                    <div>
                        <h2><span class="badge badge-success">{{ $year }}-{{ $month }}-{{ $day }}</span></h2>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table border table-bordered table-hover">
                        <tr class="text-center bg-success">
                            <th colspan="{{ 3 + $day }}">
                                <h5 class="text-light">Attendance - {{ $year }} {{ $month }}</h5>
                            </th>
                        </tr>
                        <tr class="text-center bg-info">
                            <th class="text-light">#</th>
                            <th class="text-light">Pegawai</th>
                            <th class="text-light">Role</th>
                            @for($i = 1;$i <= $day;$i++) <th class="text-light">{{ $i }}</th> @endfor
                        </tr>
                        @forelse($user as $data)
                        <tr class="text-center">
                            <td>{{ $data->id }}</td>
                            <td><button type="button" id="{{ $data->id }}" year="{{ $year }}" month="{{ $month }}" class="btn btn-outline-primary button-show" data-toggle="modal" data-target=".bd-example-modal-lg">{{ $data->name }}</button></td>
                            <td>
                                <ul class="list-unstyled">
                                    @foreach($data->roles as $role)
                                    <li>{{ $role->name }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            @for($i = 1; $i <= $day; $i++) <td>
                                @foreach($data->jadwal as $row)
                                    @if(Carbon\Carbon::parse($row->tanggal)->format('Y') == $year)
                                        @if(Carbon\Carbon::parse($row->tanggal)->format('m') == $month)
                                            @if(Carbon\Carbon::parse($row->tanggal)->format('d') == $i)
                                                @if($row->shift->kode == 'SF1'|| $row->shift->kode == 'SF2')
                                                <i class="fa fa-check text-success">{{ $row->shift->kode }}</i>
                                                @else
                                                    @if($row->shift->kode == 'L')
                                                    <i class="fa fa-close text-danger">{{ $row->shift->kode }}</i>
                                                    @else
                                                    <i class="fa fa-info text-warning">{{ $row->shift->kode }}</i>
                                                    @endif
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                                @foreach($holiday as $list)
                                @if(Carbon\Carbon::parse($list->holiday_date)->format('d') == $i)
                                <i class="fa fa-close text-danger">{{ $list->title }}</i>
                                @endif
                                @endforeach
                                </td>
                            @endfor
                        </tr>
                        @empty
                        <tr>
                            <td colspan="40">
                                <div class="alert alert-warning text-center">Data Kosong</div>
                            </td>
                        </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.attendance.modal')
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script>
    const Year = function()
    {
        let start = new Date().getFullYear();
        for (let i = start; i > start - 10; i--){
            console.log(i)
        }
    }
    Year()
    function TheSubmitFormForFilterAttendance(){
        $('#TheSubmitFormForFilterAttendance').submit()
    }
    $('.button-show').click(function() {
        event.preventDefault()
        let id = $(this).attr('id');
        let year = $(this).attr('year')
        let month = $(this).attr('month')
        
        $('#tombol-hapus').attr('year', year);
        $('#tombol-hapus').attr('month', month);
        $('#tombol-hapus').attr('dataID', id);

        $.ajax({
            url: `/admin/attendance/${id}`,
            success: function(result) {
                $("#name_user").val(result.name);
                $("#cabang_id").val(result.cabang_id)
                $('#cabang').val(result.cabang)
                $('#ruangan_id').html('')
                $.each(result.ruangan, function() {
                    $('#ruangan_id').append(`<option value="${this.id}">${this.nama_ruangan}</option>`)
                })
            }
        });

        console.log($('#tombol-hapus-attendance').attr('href', `/admin/attendance/reset/${id}/${year}/${month}`))
        $('#id').val(id)
        $('#show-data').modal('show')
        $('#table-jadwal').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            ajax: ({
                url: `/admin/attendance/edit/${id}/${year}/${month}`,
                type: 'get',
                error: err => {
                    alert(err)
                }
            }),
            columns: [{
                    name: "id",
                    data: "id"
                },
                {
                    name: "tanggal",
                    data: "tanggal"
                },
                {
                    name: "kode",
                    data: "kode"
                },
                {
                    name: "cabang",
                    data: "cabang"
                },
                {
                    name: "ruang",
                    data: "ruang"
                },
                {
                    data: "SF1"
                },
                {
                    data: "SF2"
                },
                {
                    data: 'L'
                }
            ]
        })
    })
</script>
@stop