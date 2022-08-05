<?php

namespace App\Http\Controllers\Dpd;

use Carbon\carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\{User, Kantor, DetailUsers, Provinsi, Kabupaten, Kecamatan, Kepengurusan, Kelurahan, Jabatan, Penghubung};


class AjaxController extends Controller
{
    public function ajax_anggota(Request $request)
    {
        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $kabupaten = DetailUsers::whereBetween('created_at', array($request->from_date, $request->to_date))->orderBy('kabupaten_domisili', 'asc')->get();
            } else {

                $id = Auth::user()->id;
                $detail = DetailUsers::where('userid', $id)->select('provinsi_domisili')->first();

                $kabupaten = User::join('detail_users', 'users.id', '=', 'detail_users.userid')
                    ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                    ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                    ->join('provinsis', 'detail_users.provinsi_domisili', '=', 'provinsis.id_prov')
                    ->selectRaw('users.super_admin, detail_users.id, detail_users.no_member ,detail_users.created_by,detail_users.nik, provinsis.name, detail_users.nickname as nama_anggota, provinsis.id_prov, detail_users.kabupaten_domisili, users.email ,roles.key, roles.name as nama_roles,detail_users.status_kta, detail_users.gender, detail_users.birth_place, detail_users.tgl_lahir,detail_users.pekerjaan, detail_users.status_kawin,detail_users.alamat,detail_users.kelurahan_domisili')
                    ->whereIn('provinsis.id_prov', $detail)
                    ->where('detail_users.status_kta', 1)
                    ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                         ->groupBy('detail_users.nik')
                    ->orderBy('detail_users.id', 'desc')
                    ->get();
            }
            return datatables()
                ->of($kabupaten)
                ->editColumn('no_anggota', function ($kabupaten) {
                    return $kabupaten->no_member;
                })
                ->editColumn('name', function ($kabupaten) {
                    return $kabupaten->nama_anggota;
                })
                ->editColumn('nik', function ($kabupaten) {
                    return $kabupaten->nik;
                })
                ->editColumn('gender', function ($kabupaten) {
                    return  \App\Gender::where('id', $kabupaten->gender)->value('name');
                })
                ->editColumn('tempat_lahir', function ($kabupaten) {
                    return $kabupaten->birth_place;
                })
                ->editColumn('tgl_lahir', function ($kabupaten) {
                    return Carbon::parse($kabupaten->tgl_lahir)->format('d-m-Y');
                })
                ->editColumn('status', function ($kabupaten) {
                    return \App\MaritalStatus::where('id', $kabupaten->status_kawin)->value('nama');
                })
                ->editColumn('pekerjaan', function ($kabupaten) {
                    return \App\Job::where('id', $kabupaten->pekerjaan)->value('name');
                })
                ->editColumn('alamat', function ($kabupaten) {
                    return $kabupaten->alamat;
                })
                ->editColumn('active', function ($kabupaten) {
                    if ($kabupaten->status_kta == 1) {
                        return '<a> Active</a>';
                    }
                    if ($kabupaten->status_kta == 2) {
                        return '<a>Ditolak</a>';
                    }
                    if ($kabupaten->status_kta == 3) {
                        return '<a>Dicabut</a>';
                    }
                    if ($kabupaten->status_kta == 0) {
                        return '<a>pending</a>';
                    }
                })
                ->editColumn('action', function ($kabupaten) {
                    if ($kabupaten->super_admin == 0) {
                        return '<div class="d-flex justify-content-center">
                    <a data-toggle="tooltip" data-placement="top" title="Lihat Anggota" href="' . route('dpd.member.show', $kabupaten->id) . '"class="btn btn-sm btn-success" style="margin-left:2px; height:30px;"><i class="fa-solid fa-eye"></i></a>
                    <a data-toggle="tooltip" data-placement="top" title="Cetak KTA Anggota" href="' . route('dpd.member.cetak', $kabupaten->id) . '"  class="btn btn-sm btn-secondary" style="margin-left:2px; height:30px;"><i class="fa-solid fa-print"></i></a>
                  
                   </div>';
                        //      <a href="' . route('dpd.member.edit', $kabupaten->id) . '"class="btn btn-sm btn-warning" style="margin-left:2px; height:30px;" ><i class="fa-solid fa-pen-to-square"></i></a> 
                        //       <form method="post" action="' . route('dpd.member.destroy', $kabupaten->id) . '">
                        //         <input type="hidden" name="_method" value="DELETE">
                        //         <input type="hidden" name="_token" value="'.csrf_token().'">
                        //       <button type="submit" class="btn btn-danger btn-sm btn-secondary"  style="margin-left:2px; height:30px;"><i class="fa-solid fa-trash"></i></button>
                        //     </form>

                    }
                    return '<div class="d-flex justify-content-center">
                    <a data-toggle="tooltip" data-placement="top" title="Lihat Anggota" href="' . route('dpd.member.show', $kabupaten->id) . '"class="btn btn-sm btn-success" style="margin-left:2px; height:30px;"><i class="fa-solid fa-eye"></i></a>
                  

                   <a data-toggle="tooltip" data-placement="top" title="Cetak KTA Anggota" href="' . route('dpd.member.cetak', $kabupaten->id) . '"  class="btn btn-sm btn-secondary" style="margin-left:2px; height:30px;"><i class="fa-solid fa-print"></i></a>
                 
                  
                   </div>';
                    //  <a href="' . route('dpd.member.edit', $kabupaten->id) . '"class="btn btn-sm btn-warning" style="margin-left:2px; height:30px;" ><i class="fa-solid fa-pen-to-square"></i></a> 
                    //   <form disabled method="post" action="' . route('dpd.member.destroy', $kabupaten->id) . '">
                    //     <input type="hidden" name="_method" value="DELETE">
                    //     <input type="hidden" name="_token" value="'.csrf_token().'">
                    //   <button disabled type="submit" class="btn btn-danger btn-sm btn-secondary"  style="margin-left:2px; height:30px;"><i class="fa-solid fa-trash"></i></button>
                    // </form>

                })
                ->addIndexColumn()
                ->rawColumns(['action', 'active'])
                ->make(true);
        }
    }
    public function ajax_kelurahan(Request $request)
    {
        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $kelurahan = DetailUsers::whereBetween('created_at', array($request->from_date, $request->to_date))->orderBy('kabupaten_domisili', 'asc')->get();
            } else {

                $id = Auth::user()->id;
                $detail = DetailUsers::where('userid', $id)->value('provinsi_domisili');


                $kel = substr($detail, 0, 2);



                $kelurahan = Kelurahan::join('kecamatans', 'kelurahans.id_kec', '=', 'kecamatans.id_kec')
                    ->join('kabupatens', 'kecamatans.id_kab', '=', 'kabupatens.id_kab')
                    ->where(DB::raw('substr(kelurahans.id_kel, 1, 2)  '), '=', $detail)
                    ->select('kelurahans.*', 'kecamatans.name as kecamatans', 'kabupatens.name as kabupatens')
                    ->groupBy('kelurahans.id_kel')
                    ->orderBy('kelurahans.id_kel', 'asc')
                    ->get();
            }


            return datatables()
                ->of($kelurahan)
                ->editColumn('kode', function ($kelurahan) {
                    return '<a  style="color:#D6A62C; font-weight:bold;" href="' . route('dpd.kelurahan.show', $kelurahan->id_kel) . '">' . $kelurahan->id_kel . '</a>';
                })
                ->editColumn('kelurahan', function ($kelurahan) {
                    return $kelurahan->name;
                })
                ->editColumn('kabupaten', function ($kelurahan) {
                    return $kelurahan->kabupatens;
                })
                ->editColumn('kecamatan', function ($kelurahan) {
                    return $kelurahan->kecamatans;
                })

                ->editColumn('laki', function ($kelurahan) {
                    return User::join('detail_users', 'detail_users.userid', '=', 'users.id')
                        ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                        ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                        ->where('detail_users.kelurahan_domisili', $kelurahan->id_kel)
                        ->where('detail_users.gender', 1)
                        ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                        ->where('detail_users.status_kta', 1)
                             ->groupBy('detail_users.nik')
                        ->get()
                        ->count();
                })
                ->editColumn('perempuan', function ($kelurahan) {

                    return User::join('detail_users', 'detail_users.userid', '=', 'users.id')
                        ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                        ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                        ->where('detail_users.kelurahan_domisili', $kelurahan->id_kel)
                        ->where('detail_users.gender', 2)
                        ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                        ->where('detail_users.status_kta', 1)
                             ->groupBy('detail_users.nik')
                        ->get()
                        ->count();
                })
                ->editColumn('total', function ($kelurahan) {
                    return User::join('detail_users', 'detail_users.userid', '=', 'users.id')
                        ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                        ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                        ->where('detail_users.kelurahan_domisili', $kelurahan->id_kel)
                        ->where('detail_users.status_kta', 1)
                        ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                             ->groupBy('detail_users.nik')
                        ->get()
                        ->count();
                })
                ->addIndexColumn()
                ->rawColumns(['kelurahan', 'kode'])
                ->make(true);
        }
    }
    public function ajax_kabupaten(Request $request)
    {
        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $kabupaten = DetailUsers::whereBetween('created_at', array($request->from_date, $request->to_date))->orderBy('kabupaten_domisili', 'asc')->get();
            } else {
                // $kabupaten = DetailUsers::leftJoin('provinsis','detail_users.provinsi_domisili','=','provinsis.id_prov')
                // ->leftJoin('kabupatens','detail_users.kabupaten_domisili','=','kabupatens.id_kab')
                // ->select('kabupatens.name as nama','provinsis.name','detail_users.kabupaten_domisili','detail_users.id')
                // ->orderBy('detail_users.kabupaten_domisili', 'asc')->groupBy('detail_users.kabupaten_domisili')->get();
                $id = Auth::user()->id;
                $detail = DetailUsers::where('userid', $id)->value('provinsi_domisili');
                $kab = DetailUsers::where('userid', $id)->value('kabupaten_domisili');
                $kabupaten = Kabupaten::where('id_prov', $detail)
                    ->orderBy('id', 'asc')->groupBy('name')->get();
            }
            return datatables()
                ->of($kabupaten)
                ->editColumn('kode', function ($kabupaten) {
                    return '<a  style="color:#D6A62C; font-weight:bold;" href="' . route('dpd.kabupaten.show', $kabupaten->id_kab) . '">' . $kabupaten->id_kab . '</a>';
                })
                ->editColumn('kabupaten', function ($kabupaten) {
                    return $kabupaten->name;
                })
                ->editColumn('provinsi', function ($kabupaten) {
                    return \App\Provinsi::where('id_prov', $kabupaten->id_prov)->value('name');
                })
                ->editColumn('total', function ($kabupaten) {
                    return \App\DetailUsers::join('model_has_roles', 'detail_users.userid', '=', 'model_has_roles.model_id')
                        ->join('users', 'detail_users.userid', '=', 'users.id')
                        ->where('detail_users.kabupaten_domisili', $kabupaten->id_kab)
                        ->where('detail_users.status_kta', 1)
                        ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                             ->groupBy('detail_users.nik')
                        ->get()
                        ->count();
                })
                ->editColumn('pengurus', function ($kabupaten) {
                    return \App\Kepengurusan::where(function($query) use ($kabupaten){
                         $query->where('id_daerah', $kabupaten->id_kab);
                          $query->orwhere(DB::raw('substr(id_daerah, 1, 4)  '), '=', $kabupaten->id_kab);
                    })
                    ->where('deleted_at', null)
                    ->get()
                    ->count();
                })
                // ->editColumn('download', function ($kabupaten) {
                //     return '<a href="' . route('dpp.kabupaten.export' , $kabupaten->id_kab). '">Anggota</a> | <a href="' .route('dpp.kabupaten.show' , $kabupaten->id_kab). '">KTA & KTP</a>';
                // })
                ->editColumn('action', function ($kabupaten) {
                    return '<div class="d-flex">
                        <a data-toggle="tooltip" data-placement="top" title="Kantor DPC" href="/dpd/kabupaten/' . $kabupaten->id_kab . '/kantor" class="btn btn-sm btn-secondary"  style="margin-left:2px; height:30px;"><i class="fa-solid fa-building"></i></a>
                         <a data-toggle="tooltip" data-placement="top" title="Kepengurusan DPC" href="/dpd/kabupaten/' . $kabupaten->id_kab . '/kepengurusan"class="btn btn-sm btn-secondary"  style="margin-left:2px; height:30px;"><i class="fa-solid fa-person"></i></a>
                    </div>
                   ';
                })
                ->addIndexColumn()
                ->rawColumns(['kode', 'action'])
                ->make(true);
        }
    }

   public function ajax_penghubung(Request $request)
    {
        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $kabupaten = DetailUsers::whereBetween('created_at', array($request->from_date, $request->to_date))->orderBy('kabupaten_domisili', 'asc')->get();
            } else {

                $id = Auth::user()->id;
                $detail = DetailUsers::where('userid', $id)->select('kabupaten_domisili')->first();
                $provinsi = DetailUsers::where('userid', $id)->select('provinsi_domisili')->first();
                $kec = DetailUsers::where('userid', $id)->select('kecamatan_domisili')->first();

                // $kecamatan = User::join('detail_users', 'users.id', '=', 'detail_users.userid')
                //     ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                //     ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                //     ->join('kecamatans', 'detail_users.kabupaten_domisili', '=', 'kecamatans.id_kab')
                //     ->selectRaw('kecamatans.name, kecamatans.id_kec, detail_users.status_kta, detail_users.kecamatan_domisili,roles.key, roles.name as nama_roles, kecamatans.kuota')
                //     ->whereIn('kecamatans.id_kab', $detail)
                //     ->where('detail_users.status_kta', 1)
                //     ->groupBy('kecamatans.id_kec')
                //     ->get();
                
                $penghubung = Penghubung::join('detail_users', 'petugas_penghubung.koordinator', '=', 'detail_users.id')
                    ->select('detail_users.nickname', 'petugas_penghubung.no_sk', 'petugas_penghubung.no_telp', 'petugas_penghubung.jabatan', 'petugas_penghubung.id', 'petugas_penghubung.tanggal_sk', 'petugas_penghubung.name', 'petugas_penghubung.attachment')
                    ->where('petugas_penghubung.provinsi_domisili', $provinsi->provinsi_domisili)
                    ->where('petugas_penghubung.roles_id', 11)
                    ->groupBy('petugas_penghubung.koordinator')
                    ->where('petugas_penghubung.deleted_at',null)
                    ->orderBy('petugas_penghubung.id')
                    ->get();
            }

            return datatables()
                ->of($penghubung)
                ->editColumn('koordinator', function ($penghubung) {
                    return $penghubung->name;
                })
                ->editColumn('jabatan', function ($penghubung) {
                    return $penghubung->jabatan;
                })
                ->editColumn('no_telp', function ($penghubung) {
                    return $penghubung->no_telp;
                })
                ->editColumn('no_sk', function ($penghubung) {
                    return $penghubung->no_sk;
                })
                ->editColumn('tanggal_sk', function ($penghubung) {
                    $tanggal = \Carbon\Carbon::parse($penghubung->tanggal_sk)->format('d-m-Y');
                    return $tanggal;
                })
                ->editColumn('attachment', function ($penghubung) {
                    // $file= public_path(). "/uploads/file/";
                    return '<a href="'.asset("/uploads/file/petugas_penghubung/$penghubung->attachment") .'" class="btn btn-primary"><i class="glyphicon glyphicon-download-alt"></i></a>';
                })
                // ->editColumn('kecamatan', function ($kecamatan) {
                //     return '<a  style="color:#D6A62C; font-weight:bold;" href="' . route('dpc.kecamatan.show', $kecamatan->id_kec) . '">' . $kecamatan->name . '</a>';
                // })

                // ->editColumn('laki', function ($kecamatan) {
                //     return User::join('detail_users', 'detail_users.userid', '=', 'users.id')
                //         ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                //         ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                //         ->where('detail_users.kecamatan_domisili', $kecamatan->id_kec)
                //         ->where('detail_users.gender', 1)
                //         ->where('detail_users.status_kta', 1)
                //         ->where('users.username', '=', '')
                //         ->groupBy('detail_users.id')
                //         ->where('model_has_roles.role_id', 4)
                //         ->get()
                //         ->count();
                // })
                // ->editColumn('perempuan', function ($kecamatan) {
                //     return User::join('detail_users', 'detail_users.userid', '=', 'users.id')
                //         ->join('model_has_roles', 'detail_users.userid', '=', 'model_has_roles.model_id')
                //         ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                //         ->where('detail_users.kecamatan_domisili', $kecamatan->id_kec)
                //         ->where('detail_users.gender', 2)
                //         ->where('users.username', '=', '')
                //         ->where('detail_users.status_kta', 1)
                //         ->groupBy('detail_users.id')
                //         ->where('model_has_roles.role_id', 4)
                //         ->get()
                //         ->count();
                // })
                // ->editColumn('kuota', function ($kecamatan) {
                //      if($kecamatan->kuota == null){
                //         return '<a> 0</a>';
                //     }else{
                //         return $kecamatan->kuota;
                //     }
                // })
                // ->editColumn('total', function ($kecamatan) {
                //     return User::join('detail_users', 'detail_users.userid', '=', 'users.id')
                //         ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                //         ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                //         ->where('detail_users.kecamatan_domisili', $kecamatan->id_kec)
                //         ->where('detail_users.status_kta', 1)
                //         ->where('users.username', '=', '')
                //         ->groupBy('detail_users.id')
                //         ->where('model_has_roles.role_id', 4)
                //         ->get()
                //         ->count();
                // })
                // ->editColumn('pengurus', function ($kecamatan) {
                //     return \App\Kepengurusan::where('id_daerah', $kecamatan->id_kec)->where('deleted_at', null)->get()->count();
                // })
                ->editColumn('action', function ($penghubung) {
                   $id = Auth::user()->id;
                  $detail = DetailUsers::where('userid', $id)->select('provinsi_domisili')->first();
                    return
                        '  <div class="d-flex justify-content-center">
                    <a style="height: 30px;" data-toggle="tooltip" data-placement="top" title="Edit petugas penghubung" href="/dpd/penghubung/'.$penghubung->id.'/edit" class="btn btn-sm btn-warning mr-2"><i class="fas fa-edit"></i></a>
                     <form method="post" action="' . "/dpd/penghubung/$penghubung->id" .  '">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <button style="height: 30px;" data-toggle="tooltip" data-placement="top" title="Hapus Petugas Penghubung"  class="btn btn-sm btn-danger mr-2"><i class="fa-solid fa-trash"></i></button>
                    </form>
                    </div>';
                    // <a href="/dpc/kecamatan/'. $kecamatan->id_kec .'/kuota"class="btn btn-sm btn-warning"><i class="fa-solid fa-users-viewfinder"></i></a>

                })
                ->addIndexColumn()
                ->rawColumns(['koordinator', 'jabatan', 'no_telp', 'no_sk', 'tanggal_sk', 'attachment' ,'action'])
                ->make(true);
        }
    }
    public function ajax_pengurus(Request $request)
    {
        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $kabupaten = DetailUsers::whereBetween('created_at', array($request->from_date, $request->to_date))->orderBy('kabupaten_domisili', 'asc')->get();
            } else {
                $id = Auth::user()->id;
                $detail = DetailUsers::where('userid', $id)->value('provinsi_domisili');
                $kab = DetailUsers::where('userid', $id)->value('kabupaten_domisili');
                // $kabupaten = Kabupaten::join('kantor','kabupatens.id_kab','=','kantor.id_daerah')
                // ->where('kabupatens.id_prov', $detail)
                // ->select('kabupatens.id_kab','kabupatens.name','kantor.alamat','kantor.no_telp','kantor.email','kantor.fax','kantor.rt_rw')
                // ->orderBy('kabupatens.id_kab','asc')
                // ->get();
                $kabupaten = Kabupaten::where('id_prov', $detail)
                    ->orderBy('id', 'asc')->groupBy('name')->get();
            }
            return datatables()
                ->of($kabupaten)
                ->editColumn('kode', function ($kabupaten) {
                    return '<a  style="color:#D6A62C; font-weight:bold;" href="' . route('dpd.pengurus.show', $kabupaten->id_kab) . '">' . $kabupaten->id_kab . '</a>';
                })
                ->editColumn('kabupaten', function ($kabupaten) {
                    return '<a>DPC ' . $kabupaten->name . '</a>';
                })
                ->editColumn('ketua', function ($kabupaten) {
                    return Kepengurusan::join('kabupatens', 'kepengurusan.id_daerah', '=', 'kabupatens.id_kab')
                        ->where('kepengurusan.id_daerah', $kabupaten->id_kab)
                        ->where('kepengurusan.jabatan', 3001)
                        ->where('kepengurusan.deleted_at', null)
                        ->value('kepengurusan.nama');
                })
                ->editColumn('sekre', function ($kabupaten) {
                    return Kepengurusan::where('id_daerah', $kabupaten->id_kab)
                        ->where('jabatan', 3002)
                        ->where('deleted_at', null)
                        ->value('nama');
                })
                ->editColumn('benda', function ($kabupaten) {
                    return Kepengurusan::where('id_daerah', $kabupaten->id_kab)
                        ->where('jabatan', 3003)
                        ->where('deleted_at', null)
                        ->value('nama');
                })
                ->editColumn('alamat', function ($kabupaten) {
                    return Kantor::where('id_daerah', $kabupaten->id_kab)
                        ->groupBy('id_kantor')
                        ->value('alamat');
                })
                ->editColumn('rt', function ($kabupaten) {
                    return Kantor::where('id_daerah', $kabupaten->id_kab)
                        ->groupBy('id_kantor')
                        ->value('rt_rw');
                })
                ->editColumn('telp', function ($kabupaten) {
                    return Kantor::where('id_daerah', $kabupaten->id_kab)
                        ->groupBy('id_kantor')
                        ->value('no_telp');
                })
                ->editColumn('fax', function ($kabupaten) {
                    return Kantor::where('id_daerah', $kabupaten->id_kab)
                        ->groupBy('id_kantor')
                        ->value('fax');
                })
                ->editColumn('email', function ($kabupaten) {
                    return Kantor::where('id_daerah', $kabupaten->id_kab)
                        ->groupBy('id_kantor')
                        ->value('email');
                })
                ->addIndexColumn()
                ->rawColumns(['kode', 'ketua', 'kabupaten'])
                ->make(true);
        }
    }

    public function ajax_kecamatan(Request $request)
    {
        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $kabupaten = DetailUsers::whereBetween('created_at', array($request->from_date, $request->to_date))->orderBy('kabupaten_domisili', 'asc')->get();
            } else {

                $id = Auth::user()->id;

                $detail = DetailUsers::where('userid', $id)->value('provinsi_domisili');
                $kec = DetailUsers::where('userid', $id)->value('kecamatan_domisili');
                $kel = substr($kec, 0, 2);

                $kecamatan = Kecamatan::join('kabupatens', 'kecamatans.id_kab', '=', 'kabupatens.id_kab')
                    ->where(DB::raw('substr(kecamatans.id_kec, 1, 2)  '), '=', $detail)
                    ->groupBy('kecamatans.id_kec')->orderBy('kecamatans.id_kec', 'asc')
                    ->select('kecamatans.*', 'kabupatens.name as kabupaten','kabupatens.id_prov')
                    ->get();

                //  $kecamatan = User::join('detail_users', 'users.id', '=', 'detail_users.userid')
                //     ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                //     ->join('roles','roles.id','=','model_has_roles.role_id')
                //     ->join('kecamatans', 'detail_users.kabupaten_domisili', '=', 'kecamatans.id_kab')
                //     ->selectRaw('kecamatans.name, kecamatans.id_kec, detail_users.status_kta, detail_users.kecamatan_domisili,roles.key, roles.name as nama_roles')
                //     ->whereIn('kecamatans.id_kab',$detail)
                //     ->where('detail_users.status_kta',1)
                //     ->groupBy('kecamatans.id_kec')
                //     ->get();



            }

            return datatables()
                ->of($kecamatan)
                ->editColumn('kode', function ($kecamatan) {
                    return '<a  style="color:#D6A62C; font-weight:bold;" href="' . route('dpd.kecamatan.show', $kecamatan->id_kec) . '">' . $kecamatan->id_kec . '</a>';
                })
                ->editColumn('kabupaten', function ($kecamatan) {
                    return $kecamatan->kabupaten;
                })
                ->editColumn('kecamatan', function ($kecamatan) {
                    return $kecamatan->name;
                })

                // ->editColumn('laki', function ($kecamatan) {
                //     return User::join('detail_users', 'detail_users.userid', '=', 'users.id')
                //         ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                //         ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                //         ->where('detail_users.kecamatan_domisili', $kecamatan->id_kec)
                //         ->where('detail_users.gender', 1)
                //         ->where('detail_users.status_kta', 1)
                //         ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                //              ->groupBy('detail_users.nik')
                //         ->get()
                //         ->count();
                // })
                // ->editColumn('perempuan', function ($kecamatan) {
                //     return User::join('detail_users', 'detail_users.userid', '=', 'users.id')
                //         ->join('model_has_roles', 'detail_users.userid', '=', 'model_has_roles.model_id')
                //         ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                //         ->where('detail_users.kecamatan_domisili', $kecamatan->id_kec)
                //         ->where('detail_users.gender', 2)
                //         ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                //         ->where('detail_users.status_kta', 1)
                //              ->groupBy('detail_users.nik')
                //         ->get()
                //         ->count();
                // })
                ->editColumn('total', function ($kecamatan) {
                    return User::join('detail_users', 'detail_users.userid', '=', 'users.id')
                        ->join('model_has_roles', 'detail_users.userid', '=', 'model_has_roles.model_id')
                        ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                        ->where('detail_users.kecamatan_domisili', $kecamatan->id_kec)
                        ->where('detail_users.status_kta', 1)
                             ->groupBy('detail_users.nik')
                        ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                        ->get()
                        ->count();
                })
                ->editColumn('pengurus', function ($kecamatan) {
                    return \App\Kepengurusan::where('id_daerah', $kecamatan->id_kec)->where('deleted_at', null)->get()->count();
                })
                ->editColumn('bt', function ($kecamatan) {
                   return User::join('detail_users', 'detail_users.userid', '=', 'users.id')
                        ->join('model_has_roles', 'detail_users.userid', '=', 'model_has_roles.model_id')
                        ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                        ->where('detail_users.kecamatan_domisili', $kecamatan->id_kec)
                        ->where('detail_users.status_kta', 1)
                        ->where('detail_users.status_kpu', 1)
                             ->groupBy('detail_users.nik')
                        ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                        ->get()
                        ->count();
                })
                ->editColumn('st', function ($kecamatan) {
                    return User::join('detail_users', 'detail_users.userid', '=', 'users.id')
                        ->join('model_has_roles', 'detail_users.userid', '=', 'model_has_roles.model_id')
                        ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                        ->where('detail_users.kecamatan_domisili', $kecamatan->id_kec)
                        ->where('detail_users.status_kta', 1)
                        ->where('detail_users.status_kpu', 2)
                             ->groupBy('detail_users.nik')
                        ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                        ->get()
                        ->count();
                })
                ->editColumn('hp', function ($kecamatan) {
                     return User::join('detail_users', 'detail_users.userid', '=', 'users.id')
                        ->join('model_has_roles', 'detail_users.userid', '=', 'model_has_roles.model_id')
                        ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                        ->where('detail_users.kecamatan_domisili', $kecamatan->id_kec)
                        ->where('detail_users.status_kta', 1)
                        ->where('detail_users.status_kpu',4)
                             ->groupBy('detail_users.nik')
                        ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                        ->get()
                        ->count();
                })
                ->editColumn('tms', function ($kecamatan) {
                    return User::join('detail_users', 'detail_users.userid', '=', 'users.id')
                        ->join('model_has_roles', 'detail_users.userid', '=', 'model_has_roles.model_id')
                        ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                        ->where('detail_users.kecamatan_domisili', $kecamatan->id_kec)
                        ->where('detail_users.status_kta', 1)
                        ->where('detail_users.status_kpu',5)
                             ->groupBy('detail_users.nik')
                        ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                        ->get()
                        ->count();
                })
                ->editColumn('download', function ($kecamatan) {
                    if (!file_exists('/www/wwwroot/siap.partaihanura.or.id/uploads/ktp-kta-zip/'. $kecamatan->id_prov . '_' . $kecamatan->id_kab . '_' . $kecamatan->id_kec . '_' . strtoupper($kecamatan->name) . '.zip')) {
                        return '
                            <div class="d-flex justify-content-center">
                             <a target="_blank" class="btn" disabled style="margin-left: 2px;background-color:#D6A62C; color:#ffff;">Download All (ZIP) A </a>
                            
                             </div>';
                    }else{
                       return ' 
                       <div class="d-flex justify-content-center">
                           <a href="/dpp/kta-ktp/cetak/kecamatan/'.$kecamatan->id_kab.'/'.$kecamatan->id_kec.'"
                                    target="_blank" class="btn" style="margin-left: 2px;background-color:#D6A62C; color:#ffff;">Download All (ZIP) A
                            </a>
                           
                        </div>';
                        // <a href="/dpp/man-kta-ktp/cetak/kecamatan/'.$kecamatan->id_kab.'/'.$kecamatan->id_kec.'"
                        //             target="_blank" class="btn" style="margin-left: 2px;background-color:#D6A62C; color:#ffff;">Download All (ZIP) M
                        //     </a>
                    }
                })
                
                ->editColumn('action', function ($kecamatan) {
                    return '<div class="d-flex">
                        <a data-toggle="tooltip" data-placement="top" title="Kantor DPC" href="/dpp/kecamatan/' . $kecamatan->id_kec . '/kantor" class="btn btn-sm btn-secondary"  style="margin-left:2px; height:30px;"><i class="fa-solid fa-building"></i></a>
                         <a data-toggle="tooltip" data-placement="top" title="Kepengurusan DPC" href="/dpp/kecamatan/' . $kecamatan->id_kec . '/kepengurusan"class="btn btn-sm btn-secondary"  style="margin-left:2px; height:30px;"><i class="fa-solid fa-person"></i></a>
                    </div>
                   ';
                })
                ->addIndexColumn()
                ->rawColumns(['kecamatan', 'laki', 'perempuan', 'kode', 'action','download'])
                ->make(true);
        }
    }
    public function ajax_provinsi(Request $request)
    {
        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $provinsi = DetailUsers::whereBetween('created_at', array($request->from_date, $request->to_date))->orderBy('provinsi_domisili', 'asc')->get();
            } else {
                // $provinsi = DetailUsers::leftJoin('provinsis','detail_users.provinsi_domisili','=','provinsis.id_prov')
                // ->leftJoin('kecamatans','detail_users.kecamatan_domisili','=','kecamatans.id_kec')
                // ->leftJoin('kabupatens','detail_users.kabupaten_domisili','=','kabupatens.id_kab')
                // ->select('kecamatans.name as namo','kabupatens.name as nama','provinsis.name','detail_users.provinsi_domisili','detail_users.kabupaten_domisili','detail_users.id')
                // ->orderBy('detail_users.provinsi_domisili', 'asc')->groupBy('detail_users.provinsi_domisili')->get();
                $provinsi = Provinsi::orderBy('id', 'asc')->groupBy('id_prov')->orderBy('id_prov', 'desc')->get();
            }
            return datatables()
                ->of($provinsi)
                ->editColumn('kode', function ($provinsi) {
                    return  '<a style="color:#D6A62C; font-weight:bold;" href="' . "/dpp/provinsi/$provinsi->id_prov/showprovinsi" . '">' . $provinsi->id_prov . '</a>';
                })
                ->editColumn('provinsi', function ($provinsi) {
                    return $provinsi->name;
                })
                ->editColumn('total_kabupaten', function ($provinsi) {
                    return \App\Kabupaten::where('id_prov', $provinsi->id_prov)->groupBy('id')->get()->count();
                })
                ->editColumn('total', function ($provinsi) {
                    return \App\DetailUsers::join('users', 'detail_users.userid', '=', 'users.id')
                        ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                        ->where('detail_users.status_kta', 1)
                        ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                        ->where('detail_users.provinsi_domisili', $provinsi->id_prov)
                             ->groupBy('detail_users.nik')
                        ->get()
                        ->count();
                })
                ->addIndexColumn()
                ->rawColumns(['kode'])
                ->make(true);
        }
    }
    public function ajax_user(Request $request)
    {
        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $user = DetailUsers::whereBetween('created_at', array($request->from_date, $request->to_date))->orderBy('provinsi_domisili', 'asc')->get();
            } else {
                $id = Auth::user()->id;
                $detail = DetailUsers::where('userid', $id)->select('provinsi_domisili')->first();
                $user = User::leftJoin('detail_users', 'users.id', '=', 'detail_users.userid')
                    ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                    ->leftJoin('kabupatens', 'kabupatens.id_kab', '=', 'detail_users.kabupaten_domisili')
                    ->leftJoin('provinsis', 'provinsis.id_prov', '=', 'detail_users.provinsi_domisili')
                    ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
                    ->select('users.super_admin', 'detail_users.id', 'users.username', 'provinsis.name as nama', 'users.name', 'users.email', 'users.phone_number', 'roles.key', 'detail_users.provinsi_domisili', 'detail_users.no_member')
                    ->where('detail_users.status_kta', 1)
                    ->whereIn('model_has_roles.role_id', array(11,4))
                    ->where('users.username', '!=', '')
                    ->whereIn('provinsis.id_prov', $detail)
                    ->orderBy('detail_users.id', 'desc')
                    ->groupBy('detail_users.id')->get();
            }
            return datatables()
                ->of($user)
                ->editColumn('kode', function ($user) {
                    return $user->no_member;
                })
                ->editColumn('user', function ($user) {
                    return $user->name;
                })
                ->editColumn('username', function ($user) {

                    return $user->username;
                })
                ->editColumn('email', function ($user) {
                    return $user->email;
                })
                ->editColumn('tipe', function ($user) {
                    return $user->key;
                })
                ->editColumn('provinsi', function ($user) {

                    return $user->nama;
                })
                ->editColumn('phone', function ($user) {
                    return $user->phone_number;
                })
                ->editColumn('action', function ($user) {
                    if ($user->super_admin == 0) {
                        return '<div class="d-flex justify-content-center">
                        <a  data-toggle="tooltip" data-placement="top" title="Perbaiki User" href="' . route('dpd.listuser.edit', $user->id) . '"class="btn btn-sm btn-warning" style="margin-left:2px; height:30px;" ><i class="fa-solid fa-pen-to-square"></i></a>
                        <form method="post" action="' . route('dpd.listuser.destroy', $user->id) . '">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                           <button  data-toggle="tooltip" data-placement="top" title="Hapus User" type="submit" class="btn btn-danger btn-sm btn-secondary"  style="margin-left:2px; height:30px;"><i class="fa-solid fa-trash"></i></button>
                        </form>
                        </div>';
                    } else {
                        return '<div class="d-flex justify-content-center">
                        <a  data-toggle="tooltip" data-placement="top" title="Perbaiki User" href="' . route('dpd.listuser.edit', $user->id) . '"class="btn btn-sm btn-warning" style="margin-left:2px; height:30px;" ><i class="fa-solid fa-pen-to-square"></i></a>
                        <form method="post" action="' . route('dpd.listuser.destroy', $user->id) . '">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                           <button  disabled data-toggle="tooltip" data-placement="top" title="Hapus User" type="submit" class="btn btn-danger btn-sm btn-secondary"  style="margin-left:2px; height:30px;"><i class="fa-solid fa-trash"></i></button>
                        </form>
                        </div>';
                    }
                })
                ->addIndexColumn()
                ->rawColumns(['provinsi', 'action'])
                ->make(true);
        }
    }

    public function ajax_kepengurusan_kabupaten(Request $request)
    {
        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $kepengurusan = Kepengurusan::whereBetween('created_at', array($request->from_date, $request->to_date))->orderBy('id_daerah', 'asc')->get();
            } else {
                $kepengurusan = Kepengurusan::where('id_daerah', $request->id_daerah)
                ->orderBy('jabatan','asc')
                ->groupBy('id_kepengurusan')
                ->get();
            }
            return datatables()
                ->of($kepengurusan, $request)
                ->editColumn('nama', function ($kepengurusan) {
                    return $kepengurusan->nama;
                })
                ->editColumn('jabatan', function ($kepengurusan) {

                    if (empty($kepengurusan->jabatan)) {
                        return '<a>-</a>';
                    } else {
                        return \App\Jabatan::where('kode', $kepengurusan->jabatan)->value('nama');
                    }
                })
                ->editColumn('kode_jabatan', function ($kepengurusan) {
                    return $kepengurusan->jabatan;
                })
                ->editColumn('nik', function ($kepengurusan) {
                    return $kepengurusan->nik;
                })
                ->editColumn('kta', function ($kepengurusan) {
                    return $kepengurusan->kta;
                })
                ->editColumn('no_sk', function ($kepengurusan) {
                    return $kepengurusan->no_sk;
                })
                ->editColumn('foto', function ($kepengurusan) {
                    return "
                    <div class='click-zoom'>
                        <label>
                            <input type='checkbox'>
                            <img src='" . asset('uploads/img/foto_kepengurusan/' . $kepengurusan->foto) . "' alt='noimage' width='100px' height='100px'>
                        </label>
                    </div>
                    ";
                })
                ->editColumn('ttd', function ($kepengurusan) {
                    return "
                    <div class='click-zoom'>
                        <label>
                            <input type='checkbox'>
                            <img src='" . asset('uploads/img/ttd_kta/' . $kepengurusan->ttd) . "' alt='noimage' width='100px' height='100px'>
                        </label>
                    </div>
                    ";
                })
                ->editColumn('alamat_kantor', function ($kepengurusan) {
                    return $kepengurusan->alamat_kantor;
                })
                ->editColumn('action', function ($kepengurusan) use ($request) {
                    return '<div class="d-flex">
                        <a data-toggle="tooltip" data-placement="top" title="Perbaiki Kepengurusan DPC" href="' . "/dpd/kabupaten/$request->id_daerah/kepengurusan/$kepengurusan->id_kepengurusan/edit" . '"class="btn btn-sm btn-secondary"  style="margin-left:2px; height:30px;"><i class="fa-solid fa-edit"></i></a>
                        <form method="post" action="' . "/dpd/kabupaten/$request->id_daerah/kepengurusan/$kepengurusan->id_kepengurusan" .  '">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                            <button data-toggle="tooltip" data-placement="top" title="Hapus Kepengurusan DPC" type="submit" class="btn btn-danger btn-sm btn-secondary"  style="margin-left:2px; height:30px;"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                        ';
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'foto', 'ttd', 'jabatan'])
                ->make(true);
        }
    }


    public function ajax_acc_anggota(Request $request)
    {
        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $kabupaten = DetailUsers::whereBetween('created_at', array($request->from_date, $request->to_date))->orderBy('kabupaten_domisili', 'asc')->get();
            } else {

                $id = Auth::user()->id;
                $detail = DetailUsers::where('userid', $id)->select('provinsi_domisili')->first();

                $pending = User::join('detail_users', 'users.id', '=', 'detail_users.userid')
                    ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                    ->join('kecamatans', 'detail_users.kecamatan_domisili', '=', 'kecamatans.id_kec')
                    ->join('provinsis', 'detail_users.provinsi_domisili', '=', 'provinsis.id_prov')
                    ->selectRaw('detail_users.id, detail_users.no_member, detail_users.nik, detail_users.nickname, detail_users.birth_place, detail_users.tgl_lahir')
                    ->whereIn('detail_users.provinsi_domisili', $detail)
                    ->where('model_has_roles.role_id', 11)
                    ->where('detail_users.status_kta', 0)
                    ->get();
            }

            return datatables()
                ->of($pending)
                ->editColumn('no_anggota', function ($pending) {
                    return $pending->no_member;
                })
                ->editColumn('nik', function ($pending) {
                    return $pending->nik;
                })
                ->editColumn('name', function ($pending) {
                    return $pending->nickname;
                })
                ->editColumn('tempat_lahir', function ($pending) {
                    return
                        '<a>' . $pending->birth_place . '</a>,
                   <a>' . Carbon::parse($pending->tgl_lahir)->format('d-m-Y') . '</a>';
                })

                ->editColumn('action', function ($pending) {
                    return '
                    <div class="d-flex justify-content-center">
                    <a href="' . route('dpd.pending.edit', $pending->id) . '"  class="btn btn-sm btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
                    </div>';
                })

                ->addIndexColumn()
                ->rawColumns(['action', 'tempat_lahir', 'no_anggota'])
                ->make(true);
        }
    }
    public function ajax_restore(Request $request)
    {
        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $kabupaten = DetailUsers::whereBetween('created_at', array($request->from_date, $request->to_date))->orderBy('kabupaten_domisili', 'asc')->get();
            } else {

                $id = Auth::user()->id;
                $detail = DetailUsers::where('userid', $id)->select('provinsi_domisili')->first();

                $member = User::join('detail_users', 'users.id', '=', 'detail_users.userid')
                    ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                    ->join('kecamatans', 'detail_users.kecamatan_domisili', '=', 'kecamatans.id_kec')
                    ->join('provinsis', 'detail_users.provinsi_domisili', '=', 'provinsis.id_prov')
                    ->selectRaw('detail_users.id, detail_users.no_member, detail_users.nik, detail_users.nickname, detail_users.alamat, detail_users.deleted_at')
                    ->whereIn('detail_users.provinsi_domisili', $detail)
                    ->where('model_has_roles.role_id', 11)
                    ->where('detail_users.status_kta', 4)
                    ->get();
            }

            return datatables()
                ->of($member)
                ->editColumn('no_anggota', function ($member) {
                    return '<a  style="color:#D6A62C; font-weight:bold;" href="' . route('dpc.restore.show', $member->no_member) . '">' . $member->no_member . '</a>';
                })
                ->editColumn('nik', function ($member) {
                    return $member->nik;
                })
                ->editColumn('name', function ($member) {
                    return $member->nickname;
                })
                ->editColumn('alamat', function ($member) {
                    return $member->alamat;
                })
                ->editColumn('deleted_at', function ($member) {
                    return Carbon::parse($member->deleted_at)->format('d/m/Y');
                })
                ->editColumn('action', function ($member) {
                    return
                        '<div class="d-flex justify-content-center">
                    <a href="' . route('dpc.restore.destroy', $member->id) . '"   class="delete-form btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                    </div>';
                })

                ->addIndexColumn()
                ->rawColumns(['no_anggota', 'status', 'deleted_at', 'action'])
                ->make(true);
        }
    }
    public function ajax_pembatalan(Request $request)
    {
        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $kabupaten = DetailUsers::whereBetween('created_at', array($request->from_date, $request->to_date))->orderBy('kabupaten_domisili', 'asc')->get();
            } else {

                $id = Auth::user()->id;
                $detail = DetailUsers::where('userid', $id)->select('provinsi_domisili')->first();

                $member = User::join('detail_users', 'users.id', '=', 'detail_users.userid')
                    ->join('pembatalan_anggota', 'detail_users.id', '=', 'pembatalan_anggota.id_anggota')
                    ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                    ->join('kecamatans', 'detail_users.kecamatan_domisili', '=', 'kecamatans.id_kec')
                    ->join('provinsis', 'detail_users.provinsi_domisili', '=', 'provinsis.id_prov')
                    ->selectRaw('detail_users.id,detail_users.no_member, detail_users.nik, detail_users.nickname,detail_users.status_kta,
                detail_users.alamat,pembatalan_anggota.alasan_pembatalan, detail_users.avatar, detail_users.no_hp, provinsis.name as nama_provinsi, pembatalan_anggota.status ')
                    ->whereIn('detail_users.provinsi_domisili', $detail)
                    ->where('model_has_roles.role_id', 11)

                    ->where('detail_users.status_kta', 3)
                    ->groupBy('pembatalan_anggota.id')
                    ->get();
            }

            return datatables()
                ->of($member)
                ->editColumn('no_anggota', function ($member) {
                    return '<a  style="color:#D6A62C; font-weight:bold;" href="' . route('dpc.pembatalan.show', $member->no_member) . '">' . $member->no_member . '</a>';
                })
                ->editColumn('name', function ($member) {
                    return $member->nickname;
                })
                ->editColumn('nik', function ($member) {
                    return $member->nik;
                })
                ->editColumn('alamat', function ($member) {
                    return $member->alamat;
                })
                ->editColumn('alasan', function ($member) {
                    return $member->alasan_pembatalan;
                })
                ->editColumn('status', function ($member) {
                    if ($member->status == 4) {
                        return '<a class="custom-badge status-red">DiCabut</a>';
                    }
                    if ($member->status == 3) {
                        return '<a class="custom-badge status-green">DiAjukan Pembatalan</a>';
                    }
                    if ($member->status == 2) {
                        return '<a class="custom-badge status-orange">DiTolak</a>';
                    }
                    return $member->status;
                })
                ->editColumn('action', function ($member) {

                    return '
                <div class="d-flex justify-content-center">
                <a data-toggle="tooltip" data-placement="top" title="Acc Pembatalan" href="' . route('dpc.pembatalan.updateDelete', $member->id) . '"  class="btn btn-sm btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
                <a data-toggle="tooltip" data-placement="top" title="Menolak Pembatalan" href="' . route('dpc.pembatalan.update', $member->id) . '"  class="btn btn-sm btn-danger"><i class="fa-solid fa-x"></i></a>
                </div>';
                })


                ->addIndexColumn()
                ->rawColumns(['no_anggota', 'status', 'action'])
                ->make(true);
        }
    }
    public function ajax_repair(Request $request)
    {
        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $kabupaten = DetailUsers::whereBetween('created_at', array($request->from_date, $request->to_date))->orderBy('kabupaten_domisili', 'asc')->get();
            } else {

                $id = Auth::user()->id;
                $detail = DetailUsers::where('userid', $id)->select('provinsi_domisili')->first();

                $member = User::join('detail_users', 'users.id', '=', 'detail_users.userid')
                    ->join('pembatalan_anggota', 'detail_users.id', '=', 'pembatalan_anggota.id_anggota')
                    ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                    ->join('kecamatans', 'detail_users.kecamatan_domisili', '=', 'kecamatans.id_kec')
                    ->join('provinsis', 'detail_users.provinsi_domisili', '=', 'provinsis.id_prov')
                    ->selectRaw('detail_users.id,detail_users.no_member, detail_users.nik, detail_users.nickname,detail_users.status_kta,
                detail_users.alamat,pembatalan_anggota.alasan_pembatalan, detail_users.avatar, detail_users.no_hp, provinsis.name as nama_provinsi, pembatalan_anggota.status ')
                    ->whereIn('detail_users.provinsi_domisili', $detail)
                    ->where('model_has_roles.role_id', 11)
                    ->where('detail_users.status_kta', 2)
                    ->groupBy('pembatalan_anggota.id')
                    ->get();
            }

            return datatables()
                ->of($member)
                ->editColumn('no_anggota', function ($member) {
                    return '<a style="color:#D6A62C; font-weight:bold;" href="' . route('dpc.repair.show', $member->no_member) . '">' . $member->no_member . '</a>';
                })
                ->editColumn('name', function ($member) {
                    return $member->nickname;
                })
                ->editColumn('nik', function ($member) {
                    return $member->nik;
                })
                ->editColumn('alamat', function ($member) {
                    return $member->alamat;
                })
                ->editColumn('alasan', function ($member) {
                    return $member->alasan_pembatalan;
                })
                ->editColumn('action', function ($member) {

                    // return '<div class="d-flex justify-content-center"><a href="' . route('dpc.pembatalan.update', $member->id) . '"  class="btn btn-sm btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
                    // <a href="' . route('dpc.pembatalan.updateDelete', $member->id) . '"  class="btn btn-sm btn-danger"><i class="fa-solid fa-x"></i></a></div>'; 
                })


                ->addIndexColumn()
                ->rawColumns(['no_anggota', 'status', 'action'])
                ->make(true);
        }
    }
}
