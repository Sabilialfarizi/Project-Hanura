<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered custom-table report" width="100%">
                <thead>
                    <tr>
                        <th style="text-align: center;">No</th>
                        <th>Nama Item</th>
                        <th>Supllier</th>
                        <th>Project</th>
                        <th>Warehouse</th>
                        {{-- <th>Before</th> --}}
                       
                        <th>Waktu</th>
                        <th>Admin</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($barangs as $barang)
                    <tr>
                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                        <td>{{ $barang->barang->nama_barang }}</td>
                        <td>{{ $barang->supplier->nama ?? '-' }}</td>
                        <td>
                            @if($barang->project_id)
                            {{ $barang->project->nama_project }}
                            @endif
                        </td>   
                        <td>{{ $barang->warehouse->nama_warehouse }}</td>
                 
                        <td>{{ Carbon\Carbon::parse($barang->created_at)->format('d/m/Y') }}</td>
                        <td>{{ $barang->admin->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
         
            </table>
        </div>
    </div>
</div>