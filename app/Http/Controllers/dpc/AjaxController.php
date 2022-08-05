<?php

namespace App\Http\Controllers\Dpc;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{User, DetailUsers, Provinsi, Kabupaten, Job, Pembatalan, Kelurahan, Kepengurusan, Penghubung, Kecamatan};
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AjaxController extends Controller
{
    public function ajax_anggota(Request $request)
    {
        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $member = User::leftJoin('detail_users', 'users.id', '=', 'detail_users.userid')
                    ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                    ->leftJoin('kecamatans', 'detail_users.kecamatan', '=', 'kecamatans.id_kec')
                    ->leftJoin('provinsis', 'detail_users.provinsi', '=', 'provinsis.id_prov')
                    ->selectRaw('detail_users.created_at', 'detail_users.userid  ,
                        kecamatans.id as kecid ,detail_users.no_member ,
                        users.name ,detail_users.nik ,detail_users.no_hp ,
                        users.email ,users.created_at ,
                        detail_users.status_kta,detail_users.tanggal_masa_berlaku')
                    // ->where('model_has_roles.role_id', 3)
                    ->whereBetween('detail_users.created_at', array($request->from_date, $request->to_date))->orderBy('detail_users.id', 'desc')->get();
            } else {
                $id = Auth::user()->id;
                $detail = DetailUsers::where('userid', $id)->select('kabupaten_domisili')->first();
                $member = User::leftJoin('detail_users', 'users.id', '=', 'detail_users.userid')
                    ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                    ->leftJoin('kecamatans', 'detail_users.kecamatan', '=', 'kecamatans.id_kec')
                    ->leftJoin('provinsis', 'detail_users.provinsi', '=', 'provinsis.id_prov')
                    ->select(
                        'users.id',
                        'kecamatans.id as kecid',
                        'users.name',
                        'detail_users.nik',
                        'detail_users.no_hp',
                        'users.email',
                        'users.created_at',
                        'detail_users.status_kta',
                        'detail_users.no_member',
                        'detail_users.status_kta',
                        'detail_users.created_at'
                    )
                    ->where('model_has_roles.role_id', '!=', 8)
                    ->where('detail_users.status_kta', 1)
                    ->whereIn('detail_users.kabupaten_domisili', $detail)
                    ->groupBy('detail_users.nik')
                    ->get();
            }
            return datatables()
                ->of($member)
                ->editColumn('no_anggota', function ($member) {
                    return $member->no_member;
                })
                ->editColumn('name', function ($member) {
                    return $member->name;
                })
                ->editColumn('nik', function ($member) {
                    return $member->nik;
                })
                ->editColumn('no_hp', function ($member) {
                    return $member->no_hp;
                })
                ->editColumn('email', function ($member) {
                    return $member->email;
                })
                ->editColumn('created_at', function ($member) {
                    return Carbon::parse($member->created_at)->format('d/m/Y');
                })
                ->editColumn('active', function ($member) {
                    if ($member->status_kta == 1) {
                        return '<a> Active</a>';
                    }
                    if ($member->status_kta == 2) {
                        return '<a>Ditolak</a>';
                    }
                    if ($member->status_kta == 3) {
                        return '<a>Dicabut</a>';
                    }
                    if ($member->status_kta == 0) {
                        return '<a>pending</a>';
                    }
                })
                ->editColumn('action', function ($member) {
                    return
                        '<a href="' . route('dpc.member.show', $member->id) . '"class="btn btn-sm btn-success"><i class="fa-solid fa-eye"></i></a>
                   <a href="' . route('dpc.member.edit', $member->id) . '"class="btn btn-sm btn-warning"><i class="fa-solid fa-pen-to-square"></i></a> 
                   <a href="' . route('dpc.member.destroy', $member->id) . '"   class="delete-form btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>';
                })
                ->addIndexColumn()
                ->rawColumns(['active', 'action'])
                ->make(true);
        }
    }

    public function ajax_member(Request $request)
    {
        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $kabupaten = DetailUsers::whereBetween('created_at', array($request->from_date, $request->to_date))->orderBy('kabupaten_domisili', 'asc')->get();
            } else {

                $id = Auth::user()->id;
                $detail = DetailUsers::where('userid', $id)->select('kabupaten_domisili')->first();

                $kabupaten = DetailUsers::orderBy('detail_users.kelurahan_domisili', 'asc')
                    // ->join('users', 'users.id', '=', 'detail_users.userid')
                    // ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                    // ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                    ->join('status_kpu', 'detail_users.status_kpu', '=', 'status_kpu.id_status')
                    // ->join('kabupatens', 'detail_users.kabupaten_domisili', '=', 'kabupatens.id_kab')
                    ->selectRaw('detail_users.id, detail_users.no_member ,detail_users.created_by, detail_users.nik, detail_users.nickname as nama_anggota, detail_users.kabupaten_domisili,detail_users.status_kta, detail_users.gender, detail_users.birth_place, detail_users.tgl_lahir,detail_users.pekerjaan, detail_users.status_kawin,detail_users.alamat,detail_users.kelurahan_domisili, detail_users.status_kpu, status_kpu.warna_status, status_kpu.nama_status, detail_users.created_at')
                    ->whereIn('detail_users.kabupaten_domisili', $detail)
                    ->where('detail_users.status_kta', 1)
                    ->where('detail_users.status_kpu', 1)
                    ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                    ->groupBy('detail_users.nik')
                    ->get();
                // dd($kabupaten);



            }

            return datatables()
                ->of($kabupaten)
                ->editColumn('tanggal', function ($kabupaten) {
                    return Carbon::parse($kabupaten->created_at)->format('d/m/Y, H:i:s');
                })
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
                    return Carbon::parse($kabupaten->tgl_lahir)->format('d/m/Y');
                })
                ->editColumn('tanggal_pengesahan', function($kabupaten){
                    return Carbon::parse($kabupaten->created_at)->format('d/m/y');
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
                ->editColumn('status_kpu', function ($kabupaten) {
                    if ($kabupaten->status_kpu == 1) {

                        return '
                <div class="d-flex justify-content-center">
                 <a class="custom-badge status-' . $kabupaten->warna_status . '">' . $kabupaten->nama_status . '</a>
        
                </div>';
                    }
                    if ($kabupaten->status_kpu == 2) {

                        return '
                <div class="d-flex justify-content-center">
                <a class="custom-badge  status-' . $kabupaten->warna_status . '">' . $kabupaten->nama_status . '</a>
                </div>';
                    }
                    if ($kabupaten->status_kpu == 3) {

                        return '
                <div class="d-flex justify-content-center">
                <a class="custom-badge  status-' . $kabupaten->warna_status . '">' . $kabupaten->nama_status . '</a>
                </div>';
                    }
                    if ($kabupaten->status_kpu == 4) {

                        return '
                <div class="d-flex justify-content-center">
                <a class="custom-badge status-' . $kabupaten->warna_status . '">' . $kabupaten->nama_status . '</a>
                </div>';
                    }
                    if ($kabupaten->status_kpu == 5) {

                        return '
                <div class="d-flex justify-content-center">
                <a class="custom-badge status-' . $kabupaten->warna_status . '">' . $kabupaten->nama_status . '</a>
                </div>';
                    }
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
                // ->editColumn('action', function ($kabupaten) {
                //     if ($kabupaten->super_admin == 0) {
                //         return
                //             '
                //     <div class="d-flex justify-content-center">
                //      <a data-toggle="tooltip" data-placement="top" title="Lihat Anggota" href="/dpc/member/' . $kabupaten->id . '/show" class="btn btn-sm btn-success" style="margin-left:2px; height:30px;"><i class="fa-solid fa-eye"></i></a>
                    
                  
                //   <a  data-toggle="tooltip" data-placement="top" title="Perbaiki Anggota" href="' . route('dpc.member.edit', $kabupaten->id) . '"class="btn btn-sm btn-warning" style="margin-left:2px; height:30px;" ><i class="fa-solid fa-pen-to-square"></i></a> 

                //   <a  data-toggle="tooltip" data-placement="top" title="Cetak KTA Anggota" href="' . route('dpc.member.cetak', $kabupaten->id) . '"  class="btn btn-sm btn-secondary" style="margin-left:2px; height:30px;"><i class="fa-solid fa-print"></i></a>
                //      <a  data-toggle="tooltip" data-placement="top" title="Cetak Surat Pernyataan Anggota" href="' . route('dpc.kabupaten.surat_pernyataan', $kabupaten->id) . '"  class="btn btn-sm btn-secondary" style="margin-left:2px; height:30px;"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                //       <form method="post" action="' . route('dpc.member.destroy', $kabupaten->id) . '">
                //         <input type="hidden" name="_method" value="DELETE">
                //         <input type="hidden" name="_token" value="' . csrf_token() . '">
                //       <button type="submit" data-toggle="tooltip" data-placement="top" title="Hapus Anggota" class="btn btn-danger btn-sm btn-secondary mr-1" style="height:30px; margin-left:2px;"><i class="fa-solid fa-trash"></i></button>
                //     </form>
                  
                //   </div>';
                //     } else {
                //         //  <a href="' . route('dpc.kabupaten.surat_pernyataan', $kabupaten->id) . '"  class="btn btn-sm btn-secondary" style="margin-left:2px; height:30px;"<i class="fa fa-envelope" aria-hidden="true"></i></a>
                //         return
                //             '
                //     <div class="d-flex justify-content-center">
                  
                //     <a  data-toggle="tooltip" data-placement="top" title="Lihat Anggota" href="/dpc/member/' . $kabupaten->id . '/show" class="btn btn-sm btn-success" style="margin-left:2px; height:30px;"><i class="fa-solid fa-eye"></i></a>
                  
                //   <a  data-toggle="tooltip" data-placement="top" title="Perbaiki Anggota" href="' . route('dpc.member.edit', $kabupaten->id) . '"class="btn btn-sm btn-warning" style="margin-left:2px; height:30px;" ><i class="fa-solid fa-pen-to-square"></i></a> 

                //   <a  data-toggle="tooltip" data-placement="top" title="Cetak KTA Anggota" href="' . route('dpc.member.cetak', $kabupaten->id) . '"  class="btn btn-sm btn-secondary" style="margin-left:2px; height:30px;"><i class="fa-solid fa-print"></i></a>
                //      <a  data-toggle="tooltip" data-placement="top" title="Cetak Surat Pernyataan Anggota" href="' . route('dpc.kabupaten.surat_pernyataan', $kabupaten->id) . '"  class="btn btn-sm btn-secondary" style="margin-left:2px; height:30px;"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                //     <form method="post" action="' . route('dpc.member.destroy', $kabupaten->id) . '">
                //         <input type="hidden" name="_method" value="DELETE">
                //         <input type="hidden" name="_token" value="' . csrf_token() . '">
                //       <button data-toggle="tooltip" data-placement="top" title="Hapus Anggota" disabled type="submit" class="btn btn-danger btn-sm btn-secondary" style="margin-left:2px;height:30px;"><i class="fa-solid fa-trash"></i></button>
                //     </form>
                  
                //   </div>';
                //     }
                // })

                ->addIndexColumn()
                ->rawColumns(['active', 'status_kpu'])
                ->make(true);
        }
    }
    public function tdk_memenuhi(Request $request)
    {
        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $kabupaten = DetailUsers::whereBetween('created_at', array($request->from_date, $request->to_date))->orderBy('kabupaten_domisili', 'asc')->get();
            } else {

                $id = Auth::user()->id;
                $detail = DetailUsers::where('userid', $id)->select('kabupaten_domisili')->first();

                $kabupaten = DetailUsers::orderBy('detail_users.kelurahan_domisili', 'asc')
                    // ->join('users', 'users.id', '=', 'detail_users.userid')
                    // ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                    // ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                    ->join('status_kpu', 'detail_users.status_kpu', '=', 'status_kpu.id_status')
                    // ->join('kabupatens', 'detail_users.kabupaten_domisili', '=', 'kabupatens.id_kab')
                    ->selectRaw('detail_users.id, detail_users.no_member ,detail_users.created_by, detail_users.nik, detail_users.nickname as nama_anggota, detail_users.kabupaten_domisili,detail_users.status_kta, detail_users.gender, detail_users.birth_place, detail_users.tgl_lahir,detail_users.pekerjaan, detail_users.status_kawin,detail_users.alamat,detail_users.kelurahan_domisili, detail_users.status_kpu, status_kpu.warna_status, status_kpu.nama_status, detail_users.created_at')
                    ->whereIn('detail_users.kabupaten_domisili', $detail)
                    ->where('detail_users.status_kta', 1)
                    ->where('detail_users.status_kpu', 4)
                    ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                    ->groupBy('detail_users.nik')
                    ->get();
                // dd($kabupaten);



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
                    return Carbon::parse($kabupaten->tgl_lahir)->format('d/m/Y');
                })
                ->editColumn('tanggal_pengesahan', function($kabupaten){
                    return Carbon::parse($kabupaten->created_at)->format('d/m/Y');
                })
             
                ->editColumn('alamat', function ($kabupaten) {
                    return $kabupaten->alamat;
                })
          
                ->editColumn('status_kpu', function ($kabupaten) {
                    if ($kabupaten->status_kpu == 1) {

                        return '
                <div class="d-flex justify-content-center">
                 <a class="custom-badge status-' . $kabupaten->warna_status . '">' . $kabupaten->nama_status . '</a>
        
                </div>';
                    }
                    if ($kabupaten->status_kpu == 2) {

                        return '
                <div class="d-flex justify-content-center">
                <a class="custom-badge  status-' . $kabupaten->warna_status . '">' . $kabupaten->nama_status . '</a>
                </div>';
                    }
                    if ($kabupaten->status_kpu == 3) {

                        return '
                <div class="d-flex justify-content-center">
                <a class="custom-badge  status-' . $kabupaten->warna_status . '">' . $kabupaten->nama_status . '</a>
                </div>';
                    }
                    if ($kabupaten->status_kpu == 4) {

                        return '
                <div class="d-flex justify-content-center">
                <a class="custom-badge status-' . $kabupaten->warna_status . '">' . $kabupaten->nama_status . '</a>
                </div>';
                    }
                    if ($kabupaten->status_kpu == 5) {

                        return '
                <div class="d-flex justify-content-center">
                <a class="custom-badge status-' . $kabupaten->warna_status . '">' . $kabupaten->nama_status . '</a>
                </div>';
                    }
                })
        

                ->addIndexColumn()
                ->rawColumns(['status_kpu'])
                ->make(true);
        }
    }
    public function sdh_transfer(Request $request)
    {
        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $kabupaten = DetailUsers::whereBetween('created_at', array($request->from_date, $request->to_date))->orderBy('kabupaten_domisili', 'asc')->get();
            } else {

                $id = Auth::user()->id;
                $detail = DetailUsers::where('userid', $id)->select('kabupaten_domisili')->first();

                $kabupaten = DetailUsers::orderBy('detail_users.kelurahan_domisili', 'asc')
                    // ->join('users', 'users.id', '=', 'detail_users.userid')
                    // ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                    // ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                    ->join('status_kpu', 'detail_users.status_kpu', '=', 'status_kpu.id_status')
                    // ->join('kabupatens', 'detail_users.kabupaten_domisili', '=', 'kabupatens.id_kab')
                    ->selectRaw('detail_users.id, detail_users.no_member ,detail_users.created_by, detail_users.nik, detail_users.nickname as nama_anggota, detail_users.kabupaten_domisili,detail_users.status_kta, detail_users.gender, detail_users.birth_place, detail_users.tgl_lahir,detail_users.pekerjaan, detail_users.status_kawin,detail_users.alamat,detail_users.kelurahan_domisili, detail_users.status_kpu, status_kpu.warna_status, status_kpu.nama_status, detail_users.created_at')
                    ->whereIn('detail_users.kabupaten_domisili', $detail)
                    ->where('detail_users.status_kta', 1)
                    ->where('detail_users.status_kpu', 2)
                    ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                    ->groupBy('detail_users.nik')
                    ->get();
                // dd($kabupaten);



            }

            return datatables()
                ->of($kabupaten)
                // ->editColumn('tanggal', function ($kabupaten) {
                //     return Carbon::parse($kabupaten->created_at)->format('d/m/Y, H:i:s');
                // })
              
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
                    return Carbon::parse($kabupaten->tgl_lahir)->format('d/m/Y');
                })
                
                ->editColumn('alamat', function ($kabupaten) {
                    return $kabupaten->alamat;
                })
                ->editColumn('tanggal_pengesahan', function ($kabupaten) {
                    return Carbon::parse($kabupaten->created_at)->format('d/m/Y');
                })
               
                ->editColumn('status_kpu', function ($kabupaten) {
                    if ($kabupaten->status_kpu == 1) {

                        return '
                <div class="d-flex justify-content-center">
                 <a class="custom-badge status-' . $kabupaten->warna_status . '">' . $kabupaten->nama_status . '</a>
        
                </div>';
                    }
                    if ($kabupaten->status_kpu == 2) {

                        return '
                <div class="d-flex justify-content-center">
                <a class="custom-badge  status-' . $kabupaten->warna_status . '">' . $kabupaten->nama_status . '</a>
                </div>';
                    }
                    if ($kabupaten->status_kpu == 3) {

                        return '
                <div class="d-flex justify-content-center">
                <a class="custom-badge  status-' . $kabupaten->warna_status . '">' . $kabupaten->nama_status . '</a>
                </div>';
                    }
                    if ($kabupaten->status_kpu == 4) {

                        return '
                <div class="d-flex justify-content-center">
                <a class="custom-badge status-' . $kabupaten->warna_status . '">' . $kabupaten->nama_status . '</a>
                </div>';
                    }
                    if ($kabupaten->status_kpu == 5) {

                        return '
                <div class="d-flex justify-content-center">
                <a class="custom-badge status-' . $kabupaten->warna_status . '">' . $kabupaten->nama_status . '</a>
                </div>';
                    }
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
               

                ->addIndexColumn()
                ->rawColumns(['active', 'status_kpu'])
                ->make(true);
        }
    }
    public function hasil_perbaikan(Request $request)
    {
        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $kabupaten = DetailUsers::whereBetween('created_at', array($request->from_date, $request->to_date))->orderBy('kabupaten_domisili', 'asc')->get();
            } else {

                $id = Auth::user()->id;
                $detail = DetailUsers::where('userid', $id)->select('kabupaten_domisili')->first();
            $kabupaten = DetailUsers::orderBy('detail_users.kelurahan_domisili', 'asc')
                    // ->join('users', 'users.id', '=', 'detail_users.userid')
                    // ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                    // ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                    ->join('status_kpu', 'detail_users.status_kpu', '=', 'status_kpu.id_status')
                    // ->join('kabupatens', 'detail_users.kabupaten_domisili', '=', 'kabupatens.id_kab')
                    ->selectRaw('detail_users.id, detail_users.no_member ,detail_users.created_by, detail_users.nik, detail_users.nickname as nama_anggota, detail_users.kabupaten_domisili,detail_users.status_kta, detail_users.gender, detail_users.birth_place, detail_users.tgl_lahir,detail_users.pekerjaan, detail_users.status_kawin,detail_users.alamat,detail_users.kelurahan_domisili, detail_users.status_kpu, status_kpu.warna_status, status_kpu.nama_status, detail_users.created_at')
                    ->whereIn('detail_users.kabupaten_domisili', $detail)
                    ->where('detail_users.status_kta', 1)
                    ->where('detail_users.status_kpu', '!=', array(2, 3, 4))
                    ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                    ->groupBy('detail_users.nik')
                    ->get();
               
                // dd($kabupaten);



            }

            return datatables()
                ->of($kabupaten)
                ->editColumn('tanggal', function ($kabupaten) {
                    return Carbon::parse($kabupaten->created_at)->format('d/m/Y, H:i:s');
                })
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
                    return Carbon::parse($kabupaten->tgl_lahir)->format('d/m/Y');
                })
                ->editColumn('tanggal_pengesahan', function($kabupaten){
                    return Carbon::parse($kabupaten->created_at)->format('d/m/Y');
                })
                // ->editColumn('status', function ($kabupaten) {
                //     return \App\MaritalStatus::where('id', $kabupaten->status_kawin)->value('nama');
                // })
                // ->editColumn('pekerjaan', function ($kabupaten) {
                //     return \App\Job::where('id', $kabupaten->pekerjaan)->value('name');
                // })
                ->editColumn('alamat', function ($kabupaten) {
                    return $kabupaten->alamat;
                })
                ->editColumn('status_kpu', function ($kabupaten) {
                    if ($kabupaten->status_kpu == 1) {

                        return '
                <div class="d-flex justify-content-center">
                 <a class="custom-badge status-' . $kabupaten->warna_status . '">' . $kabupaten->nama_status . '</a>
        
                </div>';
                    }
                    if ($kabupaten->status_kpu == 2) {

                        return '
                <div class="d-flex justify-content-center">
                <a class="custom-badge  status-' . $kabupaten->warna_status . '">' . $kabupaten->nama_status . '</a>
                </div>';
                    }
                    if ($kabupaten->status_kpu == 3) {

                        return '
                <div class="d-flex justify-content-center">
                <a class="custom-badge  status-' . $kabupaten->warna_status . '">' . $kabupaten->nama_status . '</a>
                </div>';
                    }
                    if ($kabupaten->status_kpu == 4) {

                        return '
                <div class="d-flex justify-content-center">
                <a class="custom-badge status-' . $kabupaten->warna_status . '">' . $kabupaten->nama_status . '</a>
                </div>';
                    }
                    if ($kabupaten->status_kpu == 5) {

                        return '
                <div class="d-flex justify-content-center">
                <a class="custom-badge status-' . $kabupaten->warna_status . '">' . $kabupaten->nama_status . '</a>
                </div>';
                    }
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
                // ->editColumn('action', function ($kabupaten) {
                //     if ($kabupaten->super_admin == 0) {
                //         return
                //             '
                //     <div class="d-flex justify-content-center">
                //      <a data-toggle="tooltip" data-placement="top" title="Lihat Anggota" href="/dpc/member/' . $kabupaten->id . '/show" class="btn btn-sm btn-success" style="margin-left:2px; height:30px;"><i class="fa-solid fa-eye"></i></a>
                  
                //   <a  data-toggle="tooltip" data-placement="top" title="Perbaiki Anggota" href="' . route('dpc.member.edit', $kabupaten->id) . '"class="btn btn-sm btn-warning" style="margin-left:2px; height:30px;" ><i class="fa-solid fa-pen-to-square"></i></a> 

                //   <a  data-toggle="tooltip" data-placement="top" title="Cetak KTA Anggota" href="' . route('dpc.member.cetak', $kabupaten->id) . '"  class="btn btn-sm btn-secondary" style="margin-left:2px; height:30px;"><i class="fa-solid fa-print"></i></a>
                //      <a  data-toggle="tooltip" data-placement="top" title="Cetak Surat Pernyataan Anggota" href="' . route('dpc.kabupaten.surat_pernyataan', $kabupaten->id) . '"  class="btn btn-sm btn-secondary" style="margin-left:2px; height:30px;"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                //       <form method="post" action="' . route('dpc.member.destroy', $kabupaten->id) . '">
                //         <input type="hidden" name="_method" value="DELETE">
                //         <input type="hidden" name="_token" value="' . csrf_token() . '">
                //       <button type="submit" data-toggle="tooltip" data-placement="top" title="Hapus Anggota" class="btn btn-danger btn-sm btn-secondary mr-1" style="height:30px; margin-left:2px;"><i class="fa-solid fa-trash"></i></button>
                //     </form>
                  
                //   </div>';
                //     } else {
                //         //  <a href="' . route('dpc.kabupaten.surat_pernyataan', $kabupaten->id) . '"  class="btn btn-sm btn-secondary" style="margin-left:2px; height:30px;"<i class="fa fa-envelope" aria-hidden="true"></i></a>
                //         return
                //             '
                //     <div class="d-flex justify-content-center">
                  
                //     <a  data-toggle="tooltip" data-placement="top" title="Lihat Anggota" href="/dpc/member/' . $kabupaten->id . '/show" class="btn btn-sm btn-success" style="margin-left:2px; height:30px;"><i class="fa-solid fa-eye"></i></a>
                  
                //   <a  data-toggle="tooltip" data-placement="top" title="Perbaiki Anggota" href="' . route('dpc.member.edit', $kabupaten->id) . '"class="btn btn-sm btn-warning" style="margin-left:2px; height:30px;" ><i class="fa-solid fa-pen-to-square"></i></a> 

                //   <a  data-toggle="tooltip" data-placement="top" title="Cetak KTA Anggota" href="' . route('dpc.member.cetak', $kabupaten->id) . '"  class="btn btn-sm btn-secondary" style="margin-left:2px; height:30px;"><i class="fa-solid fa-print"></i></a>
                //      <a  data-toggle="tooltip" data-placement="top" title="Cetak Surat Pernyataan Anggota" href="' . route('dpc.kabupaten.surat_pernyataan', $kabupaten->id) . '"  class="btn btn-sm btn-secondary" style="margin-left:2px; height:30px;"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                //     <form method="post" action="' . route('dpc.member.destroy', $kabupaten->id) . '">
                //         <input type="hidden" name="_method" value="DELETE">
                //         <input type="hidden" name="_token" value="' . csrf_token() . '">
                //       <button data-toggle="tooltip" data-placement="top" title="Hapus Anggota" disabled type="submit" class="btn btn-danger btn-sm btn-secondary" style="margin-left:2px;height:30px;"><i class="fa-solid fa-trash"></i></button>
                //     </form>
                  
                //   </div>';
                //     }
                // })

                ->addIndexColumn()
                ->rawColumns(['active', 'status_kpu'])
                ->make(true);
        }
    }
    public function ajax_kabupaten(Request $request)
    {
        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $kabupaten = DetailUsers::whereBetween('created_at', array($request->from_date, $request->to_date))->orderBy('kabupaten_domisili', 'asc')->get();
            } else {

                $id = Auth::user()->id;
                $detail = DetailUsers::where('userid', $id)->select('kabupaten_domisili')->first();

                $kabupaten = User::join('detail_users', 'users.id', '=', 'detail_users.userid')
                    ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                    ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                    ->join('status_kpu', 'detail_users.status_kpu', '=', 'status_kpu.id_status')
                    ->join('kabupatens', 'detail_users.kabupaten_domisili', '=', 'kabupatens.id_kab')
                    ->selectRaw('users.super_admin,users.created_at, detail_users.userid ,detail_users.id, detail_users.no_member ,detail_users.created_by,detail_users.nik, kabupatens.name, detail_users.nickname as nama_anggota, kabupatens.id_kab, detail_users.kabupaten_domisili, users.email ,roles.key, roles.name as nama_roles,detail_users.status_kta, detail_users.gender, detail_users.birth_place, detail_users.tgl_lahir,detail_users.pekerjaan, detail_users.status_kawin,detail_users.alamat,detail_users.kelurahan_domisili, detail_users.kecamatan_domisili, detail_users.status_kpu, status_kpu.warna_status, status_kpu.nama_status')
                    
                    ->whereIn('kabupatens.id_kab', $detail)
                    ->where('detail_users.status_kta', 1)
                    ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                    ->groupBy('detail_users.nik')
                    ->orderBy('users.created_at', 'desc')
                    ->get();
                // dd($kabupaten);



            }

            return datatables()
                ->of($kabupaten)
                ->editColumn('tanggal', function ($kabupaten) {
                    return Carbon::parse($kabupaten->created_at)->format('d/m/Y, H:i:s');
                })
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
                    return Carbon::parse($kabupaten->tgl_lahir)->format('d/m/Y');
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
                ->editColumn('kecamatan', function ($kabupaten) {
                    return \App\Kecamatan::where('id_kec', $kabupaten->kecamatan_domisili)->value('name');
                })
                ->editColumn('kelurahan', function ($kabupaten) {
                    return \App\Kelurahan::where('id_kel', $kabupaten->kelurahan_domisili)->value('name');
                })
                ->editColumn('status_kpu', function ($kabupaten) {
                    if ($kabupaten->status_kpu == 1) {

                        return '
                <div class="d-flex justify-content-center">
                 <a class="custom-badge status-' . $kabupaten->warna_status . '">' . $kabupaten->nama_status . '</a>
        
                </div>';
                    }
                    if ($kabupaten->status_kpu == 2) {

                        return '
                <div class="d-flex justify-content-center">
                <a class="custom-badge  status-' . $kabupaten->warna_status . '">' . $kabupaten->nama_status . '</a>
                </div>';
                    }
                    if ($kabupaten->status_kpu == 3) {

                        return '
                <div class="d-flex justify-content-center">
                <a class="custom-badge  status-' . $kabupaten->warna_status . '">' . $kabupaten->nama_status . '</a>
                </div>';
                    }
                    if ($kabupaten->status_kpu == 4) {

                        return '
                <div class="d-flex justify-content-center">
                <a class="custom-badge status-' . $kabupaten->warna_status . '">' . $kabupaten->nama_status . '</a>
                </div>';
                    }
                    if ($kabupaten->status_kpu == 5) {

                        return '
                <div class="d-flex justify-content-center">
                <a class="custom-badge status-' . $kabupaten->warna_status . '">' . $kabupaten->nama_status . '</a>
                </div>';
                    }
                })
                // ->editColumn('active', function ($kabupaten) {
                //     if ($kabupaten->status_kta == 1) {
                //         return '<a> Active</a>';
                //     }
                //     if ($kabupaten->status_kta == 2) {
                //         return '<a>Ditolak</a>';
                //     }
                //     if ($kabupaten->status_kta == 3) {
                //         return '<a>Dicabut</a>';
                //     }
                //     if ($kabupaten->status_kta == 0) {
                //         return '<a>pending</a>';
                //     }
                // })
                ->editColumn('action', function ($kabupaten) {
                    if ($kabupaten->super_admin == 0) {
                        return
                            '
                    <div class="d-flex justify-content-center">
                     <a data-toggle="tooltip" data-placement="top" title="Lihat Anggota" href="/dpc/member/' . $kabupaten->id . '/show" class="btn btn-sm btn-success" style="margin-left:2px; height:30px;"><i class="fa-solid fa-eye"></i></a>
                  
                   <a  data-toggle="tooltip" data-placement="top" title="Perbaiki Anggota" href="' . route('dpc.member.edit', $kabupaten->id) . '"class="btn btn-sm btn-warning" style="margin-left:2px; height:30px;" ><i class="fa-solid fa-pen-to-square"></i></a> 
                      <a data-toggle="tooltip" data-placement="top" title="Cetak KTP dan KTA" href="/dpp/kecamatan/cetaks/' . $kabupaten->userid . '" class="btn btn-sm btn-secondary" style="margin-left:2px; height:30px;"><i class="fa-solid fa-users"></i></a>
                   <a  data-toggle="tooltip" data-placement="top" title="Cetak KTA Anggota" href="/dpc/member/' .$kabupaten->id .'/cetak_background"  class="btn btn-sm btn-secondary" style="margin-left:2px; height:30px;"><i class="fa-solid fa-print"></i></a>
                     <a  data-toggle="tooltip" data-placement="top" title="Cetak KTA Anggota Depan" href="/dpc/anggota/kta_depan/1"  class="btn btn-sm btn-secondary" style="margin-left:2px; height:30px;"><i class="fa-solid fa-print"></i></a>
                     <a  data-toggle="tooltip" data-placement="top" title="Cetak Surat Pernyataan Anggota" href="' . route('dpc.kabupaten.surat_pernyataan', $kabupaten->id) . '"  class="btn btn-sm btn-secondary" style="margin-left:2px; height:30px;"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                      <form method="post" action="' . route('dpc.member.destroy', $kabupaten->id) . '">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                       <button type="submit" data-toggle="tooltip" data-placement="top" title="Hapus Anggota" class="btn btn-danger btn-sm btn-secondary mr-1" style="height:30px; margin-left:2px;"><i class="fa-solid fa-trash"></i></button>
                    </form>
                  
                   </div>';
                    } else {
                        //  <a href="' . route('dpc.kabupaten.surat_pernyataan', $kabupaten->id) . '"  class="btn btn-sm btn-secondary" style="margin-left:2px; height:30px;"<i class="fa fa-envelope" aria-hidden="true"></i></a>
                        return
                            '
                    <div class="d-flex justify-content-center">
                  
                    <a  data-toggle="tooltip" data-placement="top" title="Lihat Anggota" href="/dpc/member/' . $kabupaten->id . '/show" class="btn btn-sm btn-success" style="margin-left:2px; height:30px;"><i class="fa-solid fa-eye"></i></a>
                  
                   <a  data-toggle="tooltip" data-placement="top" title="Perbaiki Anggota" href="' . route('dpc.member.edit', $kabupaten->id) . '"class="btn btn-sm btn-warning" style="margin-left:2px; height:30px;" ><i class="fa-solid fa-pen-to-square"></i></a> 
                     <a data-toggle="tooltip" data-placement="top" title="Cetak KTP dan KTA" href="/dpp/kecamatan/cetaks/' . $kabupaten->userid . '" class="btn btn-sm btn-secondary" style="margin-left:2px; height:30px;"><i class="fa-solid fa-users"></i></a>

                     <a  data-toggle="tooltip" data-placement="top" title="Cetak KTA Anggota" href="/dpc/member/' .$kabupaten->id .'/cetak_background"  class="btn btn-sm btn-secondary" style="margin-left:2px; height:30px;"><i class="fa-solid fa-print"></i></a>
                        <a  data-toggle="tooltip" data-placement="top" title="Cetak KTA Anggota Depan" href="/dpc/anggota/kta_depan/1"  class="btn btn-sm btn-secondary" style="margin-left:2px; height:30px;"><i class="fa-solid fa-print"></i></a>
                     <a  data-toggle="tooltip" data-placement="top" title="Cetak Surat Pernyataan Anggota" href="' . route('dpc.kabupaten.surat_pernyataan', $kabupaten->id) . '"  class="btn btn-sm btn-secondary" style="margin-left:2px; height:30px;"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                    <form method="post" action="' . route('dpc.member.destroy', $kabupaten->id) . '">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                       <button data-toggle="tooltip" data-placement="top" title="Hapus Anggota" disabled type="submit" class="btn btn-danger btn-sm btn-secondary" style="margin-left:2px;height:30px;"><i class="fa-solid fa-trash"></i></button>
                    </form>
                  
                   </div>';
                    }
                })

                ->addIndexColumn()
                ->rawColumns(['action', 'active', 'status_kpu'])
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
                $provinsi = Provinsi::orderBy('id', 'asc')->groupBy('id_prov')->get();
            }

            return datatables()
                ->of($provinsi)
                ->editColumn('kode', function ($provinsi) {
                    return  $provinsi->id_prov;
                })
                ->editColumn('provinsi', function ($provinsi) {
                    return $provinsi->name;
                })
                ->editColumn('total_kabupaten', function ($provinsi) {
                    return '<a  style="color:#D6A62C; font-weight:bold;" href="' . route('dpc.provinsi.show', $provinsi->id_prov) . '">' . \App\Kabupaten::where('id_prov', $provinsi->id_prov)->groupBy('id')->get()->count() . '</a>';
                })
                ->editColumn('total', function ($provinsi) {
                    return DB::table('detail_users')
                        ->where('provinsi_domisili', $provinsi->id_prov)
                        ->where('status_kta', 1)
                        ->where(DB::raw('LENGTH(no_member)'), '>', [18, 20])
                        ->groupBy('nik')
                        ->get()
                        ->count();
                })

                ->addIndexColumn()
                ->rawColumns(['total_kabupaten'])
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
                $detail = DetailUsers::where('userid', $id)->select('kabupaten_domisili')->first();
                $user = User::leftJoin('detail_users', 'users.id', '=', 'detail_users.userid')
                    ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                    ->leftJoin('kabupatens', 'kabupatens.id_kab', '=', 'detail_users.kabupaten_domisili')
                    ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
                    ->select('users.super_admin', 'detail_users.id', 'users.username', 'kabupatens.name as nama', 'users.name', 'users.email', 'users.phone_number', 'roles.key', 'detail_users.kabupaten_domisili', 'detail_users.no_member')
                    ->whereIn('kabupatens.id_kab', $detail)
                    ->whereIn('model_has_roles.role_id', array(4, 5))
                    ->where('users.username', '!=', '')
                    ->where('detail_users.status_kta', 1)
                    ->orderBy('users.created_at', 'asc')
                    ->groupBy('detail_users.nik')
                    ->get();
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

                ->editColumn('kabupaten', function ($user) {
                    return $user->nama;
                })
                ->editColumn('phone', function ($user) {
                    return $user->phone_number;
                })
                ->editColumn('tipe', function ($user) {
                    if ($user->key == 'DPC') {
                        return '<div class="d-flex justify-content-center">
                            <a class="custom-badge status-orange">User DPC</a>
                    </div>';
                    } else {
                        return '<div class="d-flex justify-content-center">
                            <a class="custom-badge status-green">User PAC</a>
                    </div>';
                    }
                })
                ->editColumn('action', function ($user) {
                    if ($user->super_admin == 0) {
                        return '<div class="d-flex justify-content-center">
                 <a  data-toggle="tooltip" data-placement="top" title="Perbaiki Anggota" href="' . route('dpc.listuser.edit', $user->id) . '"class="btn btn-sm btn-warning" style="margin-left:2px; height:30px;" ><i class="fa-solid fa-pen-to-square"></i></a>
                 <form method="post" action="' . route('dpc.listuser.destroy', $user->id) . '">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                       <button  data-toggle="tooltip" data-placement="top" title="Hapus Anggota" type="submit" class="btn btn-danger btn-sm btn-secondary"  style="margin-left:2px; height:30px;"><i class="fa-solid fa-trash"></i></button>
                    </form>
                    </div>';
                    } else {
                        return '<div class="d-flex justify-content-center">
                 <a  data-toggle="tooltip" data-placement="top" title="Perbaiki User" href="' . route('dpc.listuser.edit', $user->id) . '"class="btn btn-sm btn-warning" style="margin-left:2px; height:30px;" ><i class="fa-solid fa-pen-to-square"></i></a>
                 <form method="post" action="' . route('dpc.listuser.destroy', $user->id) . '">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                       <button  disabled data-toggle="tooltip" data-placement="top" title="Hapus User" type="submit" class="btn btn-danger btn-sm btn-secondary"  style="margin-left:2px; height:30px;"><i class="fa-solid fa-trash"></i></button>
                    </form>
                    </div>';
                    }
                })


                ->addIndexColumn()
                ->rawColumns(['kabupaten', 'action', 'tipe'])
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
                $detail = DetailUsers::where('userid', $id)->select('kabupaten_domisili')->first();

                $pending = User::leftJoin('detail_users', 'users.id', '=', 'detail_users.userid')
                    ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                    ->leftJoin('jenis_kelamin', 'detail_users.gender', '=', 'jenis_kelamin.id')
                    ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
                    ->leftJoin('kecamatans', 'detail_users.kecamatan_domisili', '=', 'kecamatans.id_kec')
                    ->leftJoin('provinsis', 'detail_users.provinsi_domisili', '=', 'provinsis.id_prov')
                    ->selectRaw('jenis_kelamin.name as gender,users.created_at, roles.key,detail_users.id, detail_users.no_member, detail_users.nik, detail_users.nickname, detail_users.birth_place, detail_users.tgl_lahir')
                    ->where('detail_users.kabupaten_domisili', '=', $detail->kabupaten_domisili)
                    ->where('model_has_roles.role_id', '!=', 8)
                    ->where('detail_users.status_kta', 0)
                    ->groupBy('detail_users.nik')
                    ->orderBy('users.created_at', 'asc')
                    ->get();
            }

            return datatables()
                ->of($pending)

                ->editColumn('nik', function ($pending) {
                    return $pending->nik;
                })
                ->editColumn('no_anggota', function ($pending) {
                    return $pending->gender;
                })
                ->editColumn('name', function ($pending) {
                    return $pending->nickname;
                })
                ->editColumn('jabatan', function ($pending) {
                    return $pending->key;
                })
                ->editColumn('tempat_lahir', function ($pending) {
                    return
                        '<a>' . $pending->birth_place . '</a>,
                   <a>' . Carbon::parse($pending->tgl_lahir)->format('d/m/Y') . '</a>';
                })
                ->editColumn('tanggal', function ($pending) {
                    return Carbon::parse($pending->created_at)->format('d/m/Y ,H:i:s');
                })

                ->editColumn('action', function ($pending) {
                    return '
                    <div class="d-flex justify-content-center">
                    <a data-toggle="tooltip" data-placement="top" title="Acc Anggota" href="' . route('dpc.pending.edit', $pending->id) . '" class="btn btn-sm btn-success" style="margin-left:2px; height:30px;"><i class="fa fa-check" aria-hidden="true"></i></a>
                    <a  data-toggle="tooltip" data-placement="top" title="Perbaiki Anggota" href="' . route('dpc.pending.ganti', $pending->id) . '"class="btn btn-sm btn-warning" style="margin-left:2px; height:30px;" ><i class="fa-solid fa-pen-to-square"></i></a>
                 <form method="post" action="' . route('dpc.pending.destroy', $pending->id) . '">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                       <button  data-toggle="tooltip" data-placement="top" title="Hapus Anggota" type="submit" class="btn btn-danger btn-sm btn-secondary mr-1" style="margin-left:2px; height:30px;"><i class="fa-solid fa-trash"></i></button>
                    </form> 
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
                $detail = DetailUsers::where('userid', $id)->select('kabupaten_domisili')->first();

                $member = User::join('detail_users', 'users.id', '=', 'detail_users.userid')
                    ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                    ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                    ->join('kecamatans', 'detail_users.kecamatan_domisili', '=', 'kecamatans.id_kec')
                    ->join('provinsis', 'detail_users.provinsi_domisili', '=', 'provinsis.id_prov')
                    ->selectRaw('roles.key,detail_users.id, detail_users.no_member, detail_users.nik, detail_users.nickname, detail_users.alamat, detail_users.deleted_at')
                    ->whereIn('detail_users.kabupaten_domisili', $detail)
                    ->where('detail_users.status_kta', 4)
                    ->groupBy('detail_users.nik')
                    ->orderBy('detail_users.no_member', 'asc')
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
                ->editColumn('jabatan', function ($member) {
                    return $member->key;
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
                $detail = DetailUsers::where('userid', $id)->select('kabupaten_domisili')->first();

                $member = User::join('detail_users', 'users.id', '=', 'detail_users.userid')
                    ->join('pembatalan_anggota', 'detail_users.id', '=', 'pembatalan_anggota.id_anggota')
                    ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                    ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                    ->join('kecamatans', 'detail_users.kecamatan_domisili', '=', 'kecamatans.id_kec')
                    ->join('provinsis', 'detail_users.provinsi_domisili', '=', 'provinsis.id_prov')
                    ->selectRaw('roles.key, detail_users.id,detail_users.no_member, detail_users.nik, detail_users.nickname,detail_users.status_kta,
                detail_users.alamat,pembatalan_anggota.alasan_pembatalan, detail_users.avatar, detail_users.no_hp, provinsis.name as nama_provinsi, pembatalan_anggota.status ')
                    ->whereIn('detail_users.kabupaten_domisili', $detail)
                    ->orderBy('detail_users.no_member', 'asc')
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
                ->editColumn('jabatan', function ($member) {
                    return $member->key;
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
                <a data-toggle="tooltip" data-placement="top" title="Acc Pembatalan" href="' . route('dpc.pembatalan.updateDelete', $member->id) . '"  class="btn btn-sm btn-success" style="margin-left:2px; height:30px;"><i class="fa fa-check" aria-hidden="true"></i></a>
                <a data-toggle="tooltip" data-placement="top" title="Menolak Pembatalan" href="' . route('dpc.pembatalan.update', $member->id) . '"  class="btn btn-sm btn-danger" style="margin-left:2px; height:30px;"><i class="fa-solid fa-x"></i></a>
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
                $detail = DetailUsers::where('userid', $id)->select('kabupaten_domisili')->first();


                $member = User::join('detail_users', 'users.id', '=', 'detail_users.userid')
                    ->join('pembatalan_anggota', 'detail_users.id', '=', 'pembatalan_anggota.id_anggota')
                    ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                    ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                    ->join('kecamatans', 'detail_users.kecamatan_domisili', '=', 'kecamatans.id_kec')
                    ->join('provinsis', 'detail_users.provinsi_domisili', '=', 'provinsis.id_prov')
                    ->selectRaw('pembatalan_anggota.created_at,roles.key,detail_users.id,detail_users.no_member, detail_users.nik, detail_users.nickname,detail_users.status_kta,
                detail_users.alamat,pembatalan_anggota.alasan_pembatalan, detail_users.avatar, detail_users.no_hp, provinsis.name as nama_provinsi, pembatalan_anggota.status ')
                    ->whereIn('detail_users.kabupaten_domisili', $detail)
                    ->where('detail_users.status_kta', 2)
                    ->orderBy('pembatalan_anggota.created_at', 'asc')
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
                ->editColumn('jabatan', function ($member) {
                    return $member->key;
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
                ->editColumn('tanggal', function ($member) {
                    return Carbon::parse($member->created_at)->format('d/m/Y ,H:i:s');
                })
                ->editColumn('action', function ($member) {

                    return '<div class="d-flex justify-content-center">
                 <a  data-toggle="tooltip" data-placement="top" title="Perbaiki Anggota" href="' . route('dpc.repair.edit', $member->id) . '"class="btn btn-sm btn-warning" style="margin-left:2px; height:30px;" ><i class="fa-solid fa-pen-to-square"></i></a>
                 <form method="post" action="' . route('dpc.repair.destroy', $member->id) . '">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                       <button  data-toggle="tooltip" data-placement="top" title="Hapus Anggota" type="submit" class="btn btn-danger btn-sm "  style="margin-left:2px; height:30px;"><i class="fa-solid fa-trash"></i></button>
                    </form>';
                })


                ->addIndexColumn()
                ->rawColumns(['no_anggota', 'status', 'action'])
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
                $detail = DetailUsers::where('userid', $id)->select('kabupaten_domisili')->first();
                $kec = DetailUsers::where('userid', $id)->select('kecamatan_domisili')->first();

                // $kecamatan = DetailUsers::join('kecamatans', 'detail_users.kabupaten_domisili', '=', 'kecamatans.id_kab')
                //     ->selectRaw('kecamatans.name, kecamatans.id_kec, kecamatans.id_kab ,detail_users.status_kta,detail_users.kecamatan_domisili,kecamatans.kuota')
                //     ->whereIn('kecamatans.id_kab', $detail)
                //     ->where('detail_users.status_kta', 1)
                //     ->where('kecamatans.deleted_at', null)
                //     ->groupBy('kecamatans.id_kec')
                //     ->get();
                $kecamatan = Kecamatan::selectRaw('kecamatans.name, kecamatans.id_kec, kecamatans.id_kab')
                    ->whereIn('kecamatans.id_kab', $detail)
                    ->where('kecamatans.deleted_at', null)
                    ->groupBy('kecamatans.id_kec')
                    ->get();
            }

            return datatables()
                ->of($kecamatan)
                ->editColumn('kode', function ($kecamatan) {
                    return $kecamatan->id_kec;
                })
                ->editColumn('kecamatan', function ($kecamatan) {
                    return '<a  style="color:#D6A62C; font-weight:bold;" href="' . route('dpc.kecamatan.show', $kecamatan->id_kec) . '">' . $kecamatan->name . '</a>';
                })

                // ->editColumn('laki', function ($kecamatan) {
                //     return DetailUsers::where('detail_users.kecamatan_domisili', $kecamatan->id_kec)
                //         ->where('detail_users.gender', 1)
                //         ->where('detail_users.status_kta', 1)
                //         ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                //         ->groupBy('detail_users.nik')
                //         ->get()
                //         ->count();
                // })
                // ->editColumn('perempuan', function ($kecamatan) {
                //     return DetailUsers::where('detail_users.kecamatan_domisili', $kecamatan->id_kec)
                //         ->where('detail_users.gender', 2)
                //         ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                //         ->where('detail_users.status_kta', 1)
                //         ->groupBy('detail_users.nik')
                //         ->get()
                //         ->count();
                // })
                 ->editColumn('bt', function ($kecamatan) {
                   return DetailUsers::where('detail_users.kecamatan_domisili', $kecamatan->id_kec)
                        ->where('detail_users.status_kta', 1)
                        ->where('detail_users.status_kpu', 1)
                        ->groupBy('detail_users.nik')
                        ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                        ->get()
                        ->count();
                })
                ->editColumn('st', function ($kecamatan) {
                    return DetailUsers::where('detail_users.kecamatan_domisili', $kecamatan->id_kec)
                        ->where('detail_users.status_kta', 1)
                        ->where('detail_users.status_kpu', 2)
                             ->groupBy('detail_users.nik')
                        ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                        ->get()
                        ->count();
                })
                
                ->editColumn('generated', function ($kecamatan) {
                    return '  <a style="color:#D6A62C; font-weight:bold;"
                                        href="/dpc/kecamatan/'.$kecamatan->id_kec.'/generated">'.DetailUsers::where('detail_users.kecamatan_domisili', $kecamatan->id_kec)
                        ->where('detail_users.status_kta', 1)
                        ->where('detail_users.status_generate', 2)
                        ->groupBy('detail_users.nik')
                        ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                        ->get()
                        ->count().'</a>';
                })
                // ->editColumn('hp', function ($kecamatan) {
                //      return DetailUsers::where('detail_users.kecamatan_domisili', $kecamatan->id_kec)
                //         ->where('detail_users.status_kta', 1)
                //         ->where('detail_users.status_kpu',4)
                //              ->groupBy('detail_users.nik')
                //         ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                //         ->get()
                //         ->count();
                // })
                // ->editColumn('tms', function ($kecamatan) {
                //     return DetailUsers::where('detail_users.kecamatan_domisili', $kecamatan->id_kec)
                //         ->where('detail_users.status_kta', 1)
                //         ->where('detail_users.status_kpu',5)
                //              ->groupBy('detail_users.nik')
                //         ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                //         ->get()
                //         ->count();
                // })
                ->editColumn('download', function ($kecamatan) {
               
                        return '
                            <div class="d-flex justify-content-center">
							 <a data-toggle="tooltip" data-placement="top" title="Export File Zip"  href="/dpc/exports/' . $kecamatan->id_kec . '" class="btn btn-sm btn-secondary mr-2"><i class="fa-solid fa-print"></i></a>
                           
                             </div>';
        //     
                })
                // ->editColumn('kuota', function ($kecamatan) {
                //      if($kecamatan->kuota == null){
                //  <a href="/dpp/kta-ktp/cetak/kecamatan/'.$kecamatan->id_kab.'/'.$kecamatan->id_kec.'"
                //                     target="_blank" class="btn" style="margin-left: 2px;background-color:#D6A62C; color:#ffff;">Download All (ZIP) A
                //             </a>
                //           <a href="/dpp/man-kta-ktp/cetak/kecamatan/'.$kecamatan->id_kab.'/'.$kecamatan->id_kec.'"
                //                     target="_blank" class="btn" style="margin-left: 2px;background-color:#D6A62C; color:#ffff;">Download All (ZIP) M
                //             </a>
                //         return '<a> 0</a>';
                //     }else{
                //         return $kecamatan->kuota;
                //     }
                // })
                ->editColumn('total', function ($kecamatan) {
                    return User::join('detail_users', 'detail_users.userid', '=', 'users.id')
                        ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                        ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                        ->where('detail_users.kecamatan_domisili', $kecamatan->id_kec)
                        ->where('detail_users.status_kta', 1)
                        ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                        ->groupBy('detail_users.nik')
                        ->get()
                        ->count();
                })
                // ->editColumn('pengurus', function ($kecamatan) {
                //     return \App\Kepengurusan::where('id_daerah', $kecamatan->id_kec)->where('deleted_at', null)->get()->count();
                // })
                ->editColumn('action', function ($kecamatan) {
                    return
                        '  <div class="d-flex justify-content-center">
                    <a data-toggle="tooltip" data-placement="top" title="Kantor PAC" href="/dpp/kecamatan/' . $kecamatan->id_kec . '/kantor" class="btn btn-sm btn-secondary mr-2"><i class="fa-solid fa-building"></i></a>
                    <a data-toggle="tooltip" data-placement="top" title="Kepengurusan PAC" href="/dpp/kecamatan/' . $kecamatan->id_kec . '/kepengurusan"class="btn btn-sm btn-secondary mr-2"><i class="fa-solid fa-person"></i></a>
                    <a data-toggle="tooltip" data-placement="top" title="Petugas Penghubung"  href="/dpc/kecamatan/' . $kecamatan->id_kec . '/penghubungs" class="btn btn-sm btn-secondary mr-2"><i class="fa-solid fa-person-arrow-down-to-line"></i></a>
                     <a data-toggle="tooltip" data-placement="top" title="Excel Kelurahan"  href="/dpc/kecamatan/'.$kecamatan->id_kec.'/kecamatan_export" class="btn btn-sm btn-secondary mr-2"><i class="fa-solid fa-file-csv"></i></a>
                    </div>';
                    // <a href="/dpc/kecamatan/'. $kecamatan->id_kec .'/kuota"class="btn btn-sm btn-warning"><i class="fa-solid fa-users-viewfinder"></i></a>

                })
                ->addIndexColumn()
                ->rawColumns(['kecamatan', 'laki', 'perempuan', 'kuota', 'action','download','generated'])
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
                    ->select('detail_users.nickname', 'petugas_penghubung.no_sk', 'petugas_penghubung.no_telp', 'petugas_penghubung.jabatan', 'petugas_penghubung.id', 'petugas_penghubung.attachment', 'petugas_penghubung.tanggal_sk', 'petugas_penghubung.name')
                    ->where('petugas_penghubung.roles_id', 4)
                    ->where('petugas_penghubung.kabupaten_domisili', $detail->kabupaten_domisili)
                     ->groupBy('petugas_penghubung.koordinator')
                     ->where('petugas_penghubung.deleted_at', null)
                     ->orderBy('petugas_penghubung.id','asc')
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
                    return '<a href="' . asset("/uploads/file/petugas_penghubung/$penghubung->attachment") . '" class="btn btn-primary"><i class="glyphicon glyphicon-download-alt"></i></a>';
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
                    $detail = DetailUsers::where('userid', $id)->select('kabupaten_domisili')->first();
                    return
                        '  <div class="d-flex justify-content-center">
                    <a  href="/dpc/penghubung/' . $penghubung->id . '/edit" style="height: 30px;" class="btn btn-sm btn-warning mr-2"><i class="fas fa-edit"></i></a>
                      <form method="post" action="' . "/dpc/penghubung/$penghubung->id" .  '">
                            <input type="hidden" class="form-control" name="_method" value="DELETE">
                            <input type="hidden" class="form-control" name="_token" value="' . csrf_token() . '">
                    <button style="height: 30px;" class="btn btn-sm btn-danger "><i class="fa-solid fa-trash"></i></button>
                    </form>
                    </div>';
                    // <a href="/dpc/kecamatan/'. $kecamatan->id_kec .'/kuota"class="btn btn-sm btn-warning"><i class="fa-solid fa-users-viewfinder"></i></a>

                })
                ->addIndexColumn()
                ->rawColumns(['koordinator', 'jabatan', 'no_telp', 'no_sk', 'tanggal_sk', 'attachment', 'action'])
                ->make(true);
        }
    }
    public function ajax_penghubung_kecamatan(Request $request, $id_daerah)
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
                    ->select('detail_users.nickname', 'petugas_penghubung.no_sk', 'petugas_penghubung.no_telp', 'petugas_penghubung.jabatan', 'petugas_penghubung.id', 'petugas_penghubung.attachment', 'petugas_penghubung.kecamatan_domisili', 'petugas_penghubung.tanggal_sk', 'petugas_penghubung.name')
                    ->where('petugas_penghubung.roles_id', 5)
                    ->where('petugas_penghubung.kecamatan_domisili', $id_daerah)
                    ->where('petugas_penghubung.deleted_at',null)
                    ->groupBy('petugas_penghubung.koordinator')
                    ->orderBy('petugas_penghubung.id','asc')
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
                    return $penghubung->tanggal_sk;
                })
                ->editColumn('attachment', function ($penghubung) {
                    // $file= public_path(). "/uploads/file/";
                    return '<a href="' . asset("/uploads/file/petugas_penghubung/$penghubung->attachment") . '" class="btn btn-primary"><i class="glyphicon glyphicon-download-alt"></i></a>';
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
                    $detail = DetailUsers::where('userid', $id)->select('kabupaten_domisili')->first();
                    return
                        '  <div class="d-flex justify-content-center">
                    <a  href="/dpc/kecamatan/' . $penghubung->kecamatan_domisili . '/penghubungs/' . $penghubung->id . '/edit" style="height: 30px;" class="btn btn-sm btn-warning mr-2"><i class="fas fa-edit"></i></a>
                      <form method="post" action="' . "/dpc/kecamatan/$penghubung->kecamatan_domisili/penghubungs/$penghubung->id" .  '">
                            <input type="hidden" class="form-control" name="_method" value="DELETE">
                            <input type="hidden" class="form-control" name="_token" value="' . csrf_token() . '">
                    <button style="height: 30px;" class="btn btn-sm btn-danger "><i class="fa-solid fa-trash"></i></button>
                    </form>
                    </div>';
                    // <a href="/dpc/kecamatan/'. $kecamatan->id_kec .'/kuota"class="btn btn-sm btn-warning"><i class="fa-solid fa-users-viewfinder"></i></a>

                })
                ->addIndexColumn()
                ->rawColumns(['koordinator', 'jabatan', 'no_telp', 'no_sk', 'tanggal_sk', 'attachment', 'action'])
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
                $detail = DetailUsers::where('userid', $id)->value('kabupaten_domisili');


                $kel = substr($detail, 0, 4);


                $kelurahan = Kelurahan::where(DB::raw('substr(id_kel, 1, 4)  '), '=', $detail)
                    ->where('deleted_at', null)
                    ->get();
            }


            return datatables()
                ->of($kelurahan)
                ->editColumn('kode', function ($kelurahan) {
                    return $kelurahan->id_kel;
                })
                ->editColumn('kelurahan', function ($kelurahan) {
                    return '<a  style="color:#D6A62C; font-weight:bold;" href="' . route('dpc.kelurahan.show', $kelurahan->id_kel) . '">' . $kelurahan->name . '</a>';
                })

                ->editColumn('laki', function ($kelurahan) {
                    return DetailUsers::where('kelurahan_domisili', $kelurahan->id_kel)
                        ->where('gender', 1)
                        ->where(DB::raw('LENGTH(no_member)'), '>', [18, 20])
                        ->where('status_kta', 1)
                        ->groupBy('nik')
                        ->get()
                        ->count();
                })
                ->editColumn('perempuan', function ($kelurahan) {

                   return DetailUsers::where('kelurahan_domisili', $kelurahan->id_kel)
                        ->where('gender', 2)
                        ->where(DB::raw('LENGTH(no_member)'), '>', [18, 20])
                        ->where('status_kta', 1)
                        ->groupBy('nik')
                        ->get()
                        ->count();
                })
                ->editColumn('total', function ($kelurahan) {
                    return DetailUsers::where('kelurahan_domisili', $kelurahan->id_kel)
                        ->where('status_kta', 1)
                        ->where(DB::raw('LENGTH(no_member)'), '>', [18, 20])
                        ->groupBy('nik')
                        ->get()
                        ->count();
                })
                ->editColumn('download', function ($kelurahan) {
                    
                    return '<div class="d-flex justify-content-center">
							 <a data-toggle="tooltip" data-placement="top" title="Excel Kelurahan"  href="/dpc/kelurahan/'.$kelurahan->id_kel.'/kelurahan_export" class="btn btn-sm btn-secondary mr-2"><i class="fa-solid fa-file-csv"></i></a>
                           
                             </div>';
                })
                
                ->addIndexColumn()
                ->rawColumns(['kelurahan','download'])
                ->make(true);
        }
    }
}
