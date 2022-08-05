@extends('layouts.admin')

@section('main-content')
<!-- Page Heading -->
<div class="h3 mb-4 text-gray-800">

    @include('sweetalert::alert')

    @if ($errors->any())
    <div class="alert alert-danger border-left-danger" role="alert">
        <ul class="pl-4 my-2">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <a class="btn btn-success btn-icon-split" href="{{ route('MstKaryawan.create') }}">
        <span class="icon text-white-50">
            <i class="fas fa-plus-circle"></i>
        </span>
        <span class="text">{{ __('Tambah') }}</span>
    </a>

    <!-- Topbar Search -->
    {{-- <form action="{{ url()->current() }}"
    class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
    <div class="input-group">
        <input type="text" name="keyword" value="{{ old('keyword') }}" class="form-control bg-light border-1 small"
            placeholder="Cari Nik atau Nama" aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search fa-sm"></i>
            </button>
        </div>
    </div>
    </form> --}}

</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">{{ __('Karyawan') }}</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Tanggal Lahir</th>
                        <th>Jabatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($employees as $item)

                    <tr>
                        <td>{{ $item->nik }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->jenis_kelamin }}</td>
                        {{-- <td><a href="#myModal" data-toggle="modal" data-gallery="example-gallery" class="col-sm-3" data-img-url="{{asset('/img/profile/'.$item->foto)}}">
                            <img src="{{asset('/img/profile/'.$item->foto)}}" class="img-fluid image-control">

                        </a></td> --}}
                        <td>{{$item->tgl_lahir}} </td>
                        <td>{{ $item->jabatan }}</td>
                        {{-- <td>{{ $item->status }}</td> --}}
                        <td>
                            <form action="{{route('MstKaryawan.destroy',$item->users_id)}}" method="post"
                                class="form-inline" onsubmit="return confirm('Yakin hapus data?')">
                                {{--                                    <a href="{{ route('mst-employee.show',$item->id_employee) }}"
                                class="btn btn-info btn-circle btn-sm">
                                <i class="fas fa-eye"></i>
                                </a>--}}
                                <a href="{{ route('MstKaryawan.edit',$item->users_id) }}"
                                    class="btn btn-primary btn-circle btn-sm">
                                    <i class="fa fa-pencil-alt"></i>
                                </a>

                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="btn btn-danger btn-circle btn-sm" ><i
                                        class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>

            {{ $employees->links() }}
        </div>
    </div>
</div>
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img class="" src="#" style="width: 400px; height: 264px;"/>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div>
    </div>
</div>

<script>

    $('div a').click(function(e) {
        $('#myModal img').attr('src', $(this).attr('data-img-url'));
    });

</script>

@endsection
