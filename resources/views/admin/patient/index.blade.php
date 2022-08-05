    @extends('layouts.master', ['title' => 'Pasien'])

    @section('content')
    <div class="row">
        <div class="col-sm-4 col-3">
            <h4 class="page-title">Pasien</h4>
        </div>
        <div class="col-sm-8 col-9 text-right m-b-20">
            @can('patient-create')
            <a href="{{ route('admin.pasien.create') }}" class="btn btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Pasien</a>
            @endcan
        </div>
    </div>

    <x-alert></x-alert>

    <div class="row">
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-bordered table-striped custom-table" width="100%" id="pasien">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Telp</th>
                            <th>Email</th>
                            <th>TTL</th>
                            <th>Alamat</th>
                            <th>Marketing</th>
                            <th>Cabang</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @stop

    @section('footer')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#pasien').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/admin/pasien/ajax',
                    get: 'get'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'no_telp',
                        name: 'no_telp'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'ttl',
                        name: 'ttl'
                    },
                    {
                        data: 'alamat',
                        name: 'alamat'
                    },
                    {
                        data: 'marketing',
                        name: 'marketing'
                    },
                    {
                        data: 'cabang',
                        name: 'cabang'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            })
        })
    </script>
    @stop