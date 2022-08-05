<div class="modal fade bd-example-modal-lg" id="show-data" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-judul"></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.attendance.store') }}" id="form-store" method="post">
                    <input type="hidden" name="year" value="{{ $year }}">
                    <input type="hidden" name="month" value="{{ $month }}">
                    <div class="row">
                        @csrf
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" readonly name="user_id" id="id">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" disabled name="name" id="name_user">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="cabang" id="cabang" disabled class="form-control">
                                <input type="hidden" name="cabang_id" id="cabang_id" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <select name="ruangan_id" id="ruangan_id" class="form-control">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table id="table-jadwal" class="table taable-bordered table-striped">
                                    <thead class="text-center">
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>kode</th>
                                            <th>cabang</th>
                                            <th>ruang</th>
                                            @foreach($shift as $th)
                                            <th>{{$th}}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="text-center"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-6 col-md-6">
                        <button class="btn btn-primary" onclick="ClickMeAndSeeTheMagic()" id="tombol-simpan" value="create">Simpan
                        </button>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <a class="btn btn-danger text-light" id="tombol-hapus-attendance" value="delete">Reset</a>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function ClickMeAndSeeTheMagic() {
        $('#form-store').submit()
    }
</script>