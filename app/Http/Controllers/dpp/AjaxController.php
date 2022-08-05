<?php

namespace App\Http\Controllers\Dpp;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{User, DetailUsers, Provinsi, Kabupaten, Kecamatan, Kelurahan, Kepengurusan, Jabatan, Kantor};
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DataTables;


class AjaxController extends Controller
{
      public function ajax_anggota( Request $request)
    {
        if(request()->ajax()){
            if(!empty($request->from_date))
            {
                $kabupaten = DetailUsers::whereBetween('created_at', array($request->from_date, $request->to_date))->orderBy('kabupaten_domisili', 'asc')->get();

            }else{
             
             $id = Auth::user()->id;
             $detail= DetailUsers::where('userid',$id)->select('kabupaten_domisili')->first();
    
             $kabupaten = User::join('detail_users', 'users.id', '=', 'detail_users.userid')
                ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                ->join('roles','roles.id','=','model_has_roles.role_id')
                ->join('kabupatens', 'detail_users.kabupaten_domisili', '=', 'kabupatens.id_kab')
                ->selectRaw('detail_users.id, detail_users.no_member ,detail_users.created_by,detail_users.nik, kabupatens.name, detail_users.nickname as nama_anggota, kabupatens.id_kab, detail_users.kabupaten_domisili, users.email ,roles.key, roles.name as nama_roles,detail_users.status_kta, detail_users.gender, detail_users.birth_place, detail_users.no_hp ,detail_users.tgl_lahir,detail_users.pekerjaan, detail_users.status_kawin,detail_users.alamat,detail_users.kelurahan_domisili')
                ->whereIn('kabupatens.id_kab',$detail)
               
                 ->where('detail_users.status_kta', 1)
                ->groupBy('detail_users.id')
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
                ->editColumn('telp', function ($kabupaten) {
                    return $kabupaten->no_hp;
                })
                ->editColumn('nik', function ($kabupaten) {
                    return $kabupaten->nik;
                })
                ->editColumn('gender', function ($kabupaten) {
                    return  \App\Gender::where('id',$kabupaten->gender)->value('name');

                })
                 ->editColumn('tempat_lahir', function ($kabupaten) {
                    return $kabupaten->birth_place;
                })
                ->editColumn('tgl_lahir', function ($kabupaten) {
                    return Carbon::parse($kabupaten->tgl_lahir)->format('d-m-Y');
                })
                ->editColumn('status', function ($kabupaten) {
                    return \App\MaritalStatus::where('id',$kabupaten->status_kawin)->value('nama');
                })
                ->editColumn('pekerjaan', function ($kabupaten) {
                    return \App\Job::where('id',$kabupaten->pekerjaan)->value('name');
                })
                ->editColumn('alamat', function ($kabupaten) {
                    return $kabupaten->alamat;
                })
                 ->editColumn('kabupaten', function ($kabupaten) {
                     return $kabupaten->name;
                })
                ->editColumn('action', function ($kabupaten) {
                    return 
                    '<a href="' . route('dpc.member.cetak', $kabupaten->id) . '"  class="btn btn-sm btn-secondary"><i class="fa-solid fa-print"></i></a>';
                  
                })
                
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }
 
 
    }
     public function ajax_pembatalan( Request $request)
    {
        if(request()->ajax()){
            if(!empty($request->from_date))
            {
                $kabupaten = DetailUsers::whereBetween('created_at', array($request->from_date, $request->to_date))->orderBy('kabupaten_domisili', 'asc')->get();

            }else{
        
             $id = Auth::user()->id;
             $detail= DetailUsers::where('userid',$id)->select('kabupaten_domisili')->first();
    
               $member = User::join('detail_users', 'users.id', '=', 'detail_users.userid')
               ->join('pembatalan_anggota','detail_users.id','=','pembatalan_anggota.id_anggota')
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('kecamatans', 'detail_users.kecamatan', '=', 'kecamatans.id_kec')
                ->join('provinsis', 'detail_users.provinsi', '=', 'provinsis.id_prov')
                ->selectRaw('detail_users.id,detail_users.no_member, detail_users.nik, detail_users.nickname,detail_users.status_kta,
                detail_users.alamat,pembatalan_anggota.alasan_pembatalan, detail_users.avatar, detail_users.no_hp, provinsis.name as nama_provinsi, pembatalan_anggota.status ')
                ->whereIn('detail_users.kabupaten_domisili', $detail)
                
                ->where('detail_users.status_kta', 3)
                ->groupBy('pembatalan_anggota.id')
                ->get();
             
     
                }
            
            return datatables()
                ->of($member)
                ->editColumn('no_anggota', function ($member) {
                   return '<a href="' .route('dpp.pembatalan.show', $member->no_member). '">' .$member->no_member . '</a>';
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
                if($member->status == 4){
                        return '<a class="custom-badge status-red">DiCabut</a>';
                    }
                if($member->status == 3){
                             return '<a class="custom-badge status-green">DiAjukan Pembatalan</a>';
                    }
                if($member->status == 2){
                         return '<a class="custom-badge status-orange">DiTolak</a>';
                    }
                    return $member->status;
                })
                ->editColumn('action', function ($member) {
             
                return '<a href="' . route('dpp.pembatalan.update', $member->id) . '"  class="btn btn-sm btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
                <a href="' . route('dpp.pembatalan.updateDelete', $member->id) . '"  class="btn btn-sm btn-danger"><i class="fa-solid fa-x"></i></a>'; 
                })
                
                
                ->addIndexColumn()
                ->rawColumns(['no_anggota','status','action'])
                ->make(true);
        }
 
 
    }
    public function ajax_kabupaten( Request $request)
    {
        if(request()->ajax()){
            if(!empty($request->from_date))
            {
                $kabupaten = DetailUsers::whereBetween('created_at', array($request->from_date, $request->to_date))->orderBy('kabupaten_domisili', 'asc')->get();

            }else{
                // $kabupaten = DetailUsers::leftJoin('provinsis','detail_users.provinsi_domisili','=','provinsis.id_prov')
                // ->leftJoin('kabupatens','detail_users.kabupaten_domisili','=','kabupatens.id_kab')
                // ->select('kabupatens.name as nama','provinsis.name','detail_users.kabupaten_domisili','detail_users.id')
                // ->orderBy('detail_users.kabupaten_domisili', 'asc')->groupBy('detail_users.kabupaten_domisili')->get();
                $kabupaten = Kabupaten::orderBy('id', 'asc')
                ->whereNull('deleted_at')
                ->groupBy('name')
                ->get();
          
 
            }
            return datatables()
                ->of($kabupaten)
                ->editColumn('kode', function ($kabupaten) {
                     return '<a style="color:#D6A62C; font-weight:bold;" href="' ."/dpp/provinsi/$kabupaten->id_kab/data". '">' .$kabupaten->id_kab. '</a>';
                })
                ->editColumn('kabupaten', function ($kabupaten) {
                    return $kabupaten->name;
                })
                ->editColumn('provinsi', function ($kabupaten) {
                    return \App\Provinsi::where('id_prov', $kabupaten->id_prov)->value('name');
                })
               
               ->editColumn('total', function ($kabupaten) {
                   return  \App\Kantor::where('id_daerah', $kabupaten->id_kab)->where('deleted_at',null)->value('target_dpc');
                    // return \App\DetailUsers::where('detail_users.kabupaten_domisili', $kabupaten->id_kab)
                    //     ->where('detail_users.status_kta', 1)
                    //     ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                    //     ->groupBy('detail_users.nik')
                    //     ->get()
                    //     ->count();
            
                })
                ->editColumn('download', function ($kabupaten) {
                    return '<div class="d-flex justify-content-center">
                    <div class="dropdown">
                          <button class="btn  dropdown-toggle"  style="margin-left:2px; background-color:#D6A62C; color:white; type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          L2-F2 PARPOL
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="/dpp/provinsi/export_parpol/'.$kabupaten->id_kab.'" target="_blank">Lampiran 2 Model F2 Parpol</a>
                            <a class="dropdown-item" href="/dpp/provinsi/export_hp_parpol/'.$kabupaten->id_kab.'" target="_blank">Lampiran 2 Model F2 HP-Parpol</a>
                           
                          </div>
                        </div>
                    <div class="dropdown">
                          <button class="btn  dropdown-toggle"  style="margin-left:2px; background-color:#D6A62C; color:white; type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Daftar Anggota Template KPU
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="' . route('dpp.kabupaten.export' , $kabupaten->id_kab). '">Daftar Anggota Template KPU</a>
                            <a class="dropdown-item" href="' . route('dpp.kabupaten.export_hp' , $kabupaten->id_kab). '">Daftar Anggota Template KPU (HP)</a>
                           
                          </div>
                    </div>
                    <div class="dropdown">
                          <button class="btn  dropdown-toggle"  style="margin-left:2px; background-color:#D6A62C; color:white; type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          KTA & KTP
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="' .route('dpp.kabupaten.show' , $kabupaten->id_kab). '" target="_blank">KTA & KTP</a>
                            <a class="dropdown-item" href="' . route('dpp.kabupaten.show_hp' , $kabupaten->id_kab). '" target="_blank">KTA & KTP (HP)</a>
                           
                          </div>
                    </div>
                    <div class="dropdown">
                          <button class="btn  dropdown-toggle"  style="margin-left:2px; background-color:#D6A62C; color:white; type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          KTA
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="' . route('dpp.kabupaten.showkta' , $kabupaten->id_kab). '" target="_blank">KTA</a>
                            <a class="dropdown-item" href="' . route('dpp.kabupaten.showkta_hp' , $kabupaten->id_kab). '" target="_blank">KTA (HP)</a>
                           
                          </div>
                    </div>
                    </div>
                    ';
                })
                ->editColumn('action', function ($kabupaten) {
                    return '<div class="d-flex justify-content-center">
                    <a data-toggle="tooltip" data-placement="top" title="Perbaiki Kabupaten"href="/dpp/kabupaten/'. $kabupaten->id .'/edit" class="btn btn-sm btn-warning"  style="margin-left:2px; height:30px;"><i class="fa-solid fa-pen"></i></a>
                    <form method="post" action="' . route('dpp.kabupaten.destroy', $kabupaten->id) . '">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                        <button data-toggle="tooltip" data-placement="top" title="Hapus Kabupaten"type="submit" class="btn btn-danger btn-sm btn-secondary "  style="margin-left:2px; height:30px;"><i class="fa-solid fa-trash"></i></button>
                    </form>
                     <a data-toggle="tooltip" data-placement="top" title="Kantor DPC"href="/dpd/kabupaten/'. $kabupaten->id_kab .'/kantor" class="btn btn-sm btn-secondary"  style="margin-left:2px; height:30px;"><i class="fa-solid fa-building"></i></a>
                    <a data-toggle="tooltip" data-placement="top" title="Kepengurusan DPC"href="/dpd/kabupaten/'. $kabupaten->id_kab .'/kepengurusan"class="btn btn-sm btn-secondary"  style="margin-left:2px; height:30px;"><i class="fa-solid fa-person"></i></a>
                    
                </div>
                  ';
                })
                ->addIndexColumn()
                ->rawColumns(['download','kode', 'action'])
                ->make(true);
        }
    }
    
    
     public function ajax_kecamatan( Request $request)
    {

    if(request()->ajax()){
            if(!empty($request->from_date))
            {
                $kecamatan = DetailUsers::whereBetween('created_at', array($request->from_date, $request->to_date))->orderBy('kecamatan_domisili', 'asc')->get();

            }else{
                // $kecamatan = DetailUsers::leftJoin('provinsis','detail_users.provinsi_domisili','=','provinsis.id_prov')
                // ->leftJoin('kecamatans','detail_users.kecamatan_domisili','=','kecamatans.id_kec')
                // ->leftJoin('kabupatens','detail_users.kabupaten_domisili','=','kabupatens.id_kab')
                // ->select('kecamatans.name as namo','kabupatens.name as nama','provinsis.name','detail_users.kecamatan_domisili','detail_users.id')
                // ->orderBy('detail_users.kecamatan_domisili', 'asc')->groupBy('detail_users.kecamatan_domisili')->get();

                $kecamatan = Kecamatan::leftJoin('kabupatens','kecamatans.id_kab','=','kabupatens.id_kab')
                ->leftJoin('detail_users','kecamatans.id_kec','=','detail_users.kecamatan_domisili')
                ->select('kecamatans.id_kec','kecamatans.id_kab','kecamatans.id','kecamatans.name','kabupatens.name as nama','kabupatens.id_prov','detail_users.kecamatan_domisili')
                ->orderBy('kecamatans.id', 'asc')->groupBy('kecamatans.name');
            } 
            return dataTables()
                ->of($kecamatan)
                ->editColumn('id', function ($kecamatan) {
                    return $kecamatan->id;
                })
                ->editColumn('kode', function ($kecamatan) {
                     return '<a  style="color:#D6A62C; font-weight:bold;"  href="' .route('dpp.kecamatan.show', $kecamatan->id_kec). '">' .$kecamatan->id_kec . '</a>';
                })
                ->editColumn('kecamatan', function ($kecamatan) {
                    return $kecamatan->name;
                })
                ->editColumn('kabupaten', function ($kecamatan) {
                    return \App\Kabupaten::where('id_kab', $kecamatan->id_kab)->value('name');
                })
                ->editColumn('provinsi', function ($kecamatan) {
                    return \App\Provinsi::where('id_prov', $kecamatan->id_prov)->value('name');
                })
                ->editColumn('total', function ($kecamatan) {
                    return '<a  style="color:#D6A62C; font-weight:bold;"  href="' .route('dpp.kecamatan.showkecamatan', $kecamatan->id_kec). '">'. \App\DetailUsers::where('kecamatan_domisili', $kecamatan->id_kec)->where('status_kta', 1)->count() . '</a>';
                })
                ->editColumn('download', function ($kecamatan) {
                    return '
                    <div class="d-flex justify-content-center">
                      <div class="dropdown">
                          <button class="btn  dropdown-toggle"  style="margin-left:2px; background-color:#D6A62C; color:white; type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Template kpu - Kecamatan
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="/dpp/kecamatan/export_parpol/'.$kecamatan->id_kec.'">Template kpu - Kecamatan</a>
                            <a class="dropdown-item" href="/dpp/kecamatan/export_hp_parpol/'.$kecamatan->id_kec.'">Template kpu - Kecamatan HP</a>
                           
                          </div>
                        </div>
                    </div>';
                })
                ->editColumn('action', function ($kecamatan) {
                    return '
                    <div class="d-flex justify-content-center">
                        <a data-toggle="tooltip" data-placement="top" title="Perbaiki Kecamatan" href="/dpp/kecamatan/'. $kecamatan->id .'/edit" class="btn btn-sm btn-warning"  style="margin-left:2px; height:30px;"><i class="fa-solid fa-pen"></i></a>
                        <form method="post" action="' . route('dpp.kecamatan.destroy', $kecamatan->id) . '">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <button data-toggle="tooltip" data-placement="top" title="Hapus Kecamatan" type="submit" class="btn btn-danger btn-sm btn-secondary"  style="margin-left:2px; height:30px;"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    <a data-toggle="tooltip" data-placement="top" title="Kantor PAC" href="/dpp/kecamatan/'.$kecamatan->id_kec.'/kantor" class="btn btn-sm btn-secondary"  style="margin-left:2px; height:30px;"><i class="fa-solid fa-building"></i></a>
                    <a data-toggle="tooltip" data-placement="top" title="Kepengurusan PAC"href="/dpp/kecamatan/'.$kecamatan->id_kec.'/kepengurusan"class="btn btn-sm btn-secondary"  style="margin-left:2px; height:30px;"><i class="fa-solid fa-person"></i></a>
                    </div>';
                })
                   ->addIndexColumn()
                ->rawColumns(['download','total', 'kode', 'action','download'])
                 ->make(true);
        }
    }
    
    public function ajax_provinsi( Request $request)
    {
        if(request()->ajax()){
            if(!empty($request->from_date))
            {
                $provinsi = DetailUsers::whereBetween('created_at', array($request->from_date, $request->to_date))->orderBy('provinsi_domisili', 'asc')->get();

            }else{
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
                     return  '<a style="color:#D6A62C; font-weight:bold;" href="' ."/dpp/provinsi/$provinsi->id_prov/showprovinsi". '">' .$provinsi->id_prov. '</a>';
                })
                ->editColumn('provinsi', function ($provinsi) {
                  return $provinsi->name;
                })
                ->editColumn('total_kabupaten', function ($provinsi) {
                    return '<a  style="color:#D6A62C; font-weight:bold;" href="' .route('dpp.provinsi.show', $provinsi->id_prov). '">' .\App\Kabupaten::where('id_prov', $provinsi->id_prov)->where('deleted_at',null)->groupBy('id')->get()->count() . '</a>';
                })
                ->editColumn('total', function ($provinsi) {
                    return \App\DetailUsers::join('users','detail_users.userid','=','users.id')
                     ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                     ->where('detail_users.status_kta',1)
                     ->where(DB::raw('LENGTH(detail_users.no_member)'),'>',[18,20])
                     ->where('detail_users.provinsi_domisili',$provinsi->id_prov)
                     ->groupBy('detail_users.nik') 
                     ->get()
                     ->count();
                })
               
                ->editColumn('download', function ($provinsi) {
                        //  <a href="' . route('dpp.provinsi.edit', $provinsi->id) . '"class="btn btn-sm mr-2 btn-secondary"><i class="fa-solid fa-plus"></i></a>
                    return '<div class="d-flex justify-content-center">
                         <div class="dropdown">
                          <button class="btn  dropdown-toggle"  style="margin-left:2px; background-color:#D6A62C; color:white; type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          L1-F2 PARPOL
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="/dpp/provinsi/lampiran_parpol/'.$provinsi->id_prov.'" target="_blank">Lampiran 1 Model F2 Parpol</a>
                            <a class="dropdown-item" href="/dpp/provinsi/lampiran_hp_parpol/'.$provinsi->id_prov.'" target="_blank">Lampiran 1 Model F2 HP-Parpol</a>
                           
                          </div>
                        </div>
                      
                    </div>
                   ';
                })
                ->editColumn('action', function ($provinsi) {
                        //  <a href="' . route('dpp.provinsi.edit', $provinsi->id) . '"class="btn btn-sm mr-2 btn-secondary"><i class="fa-solid fa-plus"></i></a>
                    return '<div class="d-flex justify-content-center">
                        <a data-toggle="tooltip" data-placement="top" title="Perbaiki Provinsi" href="/dpp/provinsi/'. $provinsi->id .'/edit" class="btn btn-sm btn-warning"   style="margin-left:2px; height:30px;"><i class="fa-solid fa-pen"></i></a>
                        <form method="post" action="' . route('dpp.provinsi.destroy', $provinsi->id) . '">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <button data-toggle="tooltip" data-placement="top" title="Hapus Provinsi"type="submit" class="btn btn-danger btn-sm"  style="margin-left:2px; height:30px;" ><i class="fa-solid fa-trash"></i></button>
                        </form>
                        <a data-toggle="tooltip" data-placement="top" title="Kantor DPD"href="/dpp/provinsi/'. $provinsi->id_prov .'/kantor" class="btn btn-sm btn-secondary"  style="margin-left:2px; height:30px;"><i class="fa-solid fa-building"></i></a>
                         <a data-toggle="tooltip" data-placement="top" title="Kepengurusan DPD"href="/dpp/provinsi/'. $provinsi->id_prov .'/kepengurusan"class="btn btn-sm btn-secondary"  style="margin-left:2px; height:30px;"><i class="fa-solid fa-person"></i></a>
                         
                      
                    </div>
                   ';
                })
                ->addIndexColumn()
                ->rawColumns(['total_kabupaten','bendahara','ketua','sekjen','action','kode','download'])
                ->make(true);
        }
    }
    
    public function ajax_user( Request $request)
    {
        if(request()->ajax()){
            if(!empty($request->from_date))
            {
                $user = DetailUsers::whereBetween('created_at', array($request->from_date, $request->to_date))->orderBy('provinsi_domisili', 'asc')->get();

            }else{
                $user = User::leftJoin('detail_users','users.id','=','detail_users.userid')
                ->leftJoin('model_has_roles','model_has_roles.model_id','=','users.id')
                ->leftJoin('kabupatens','kabupatens.id_kab','=','detail_users.kabupaten_domisili')
                ->leftJoin('provinsis','provinsis.id_prov','=','detail_users.provinsi_domisili')
                ->leftJoin('roles','roles.id','=','model_has_roles.role_id')
                ->where('detail_users.status_kta',1)
                ->where('users.username', '!=', '')
                ->where('users.generated_dpp',0)
                // ->where('model_has_roles.role_id',8)
                ->select('provinsis.name as provinsi','users.super_admin','detail_users.id','users.username','kabupatens.name as nama','users.name','users.email','users.phone_number','roles.key','detail_users.kabupaten_domisili','detail_users.no_member')
                ->orderBy('detail_users.id', 'asc')
                ->groupBy('detail_users.id') 
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
                ->editColumn('tipe', function ($user) {
                    return $user->key;
                })
                ->editColumn('kabupaten', function ($user) {
                    if($user->key == 'DPC'){
                        return $user->nama;
                    }else{
                        return '<a>-</a>';
                    }
                        
                })
                  ->editColumn('provinsi', function ($user) {
                    return $user->provinsi;
                })
                ->editColumn('phone', function ($user) {
                    return $user->phone_number;
                })
                ->editColumn('action', function ($user) {
                if($user->super_admin == 0){
                return '<div class="d-flex justify-content-center">
                 <a  data-toggle="tooltip" data-placement="top" title="Perbaiki User" href="' . route('dpp.user.edit', $user->id) . '"class="btn btn-sm btn-warning" style="margin-left:2px; height:30px;" ><i class="fa-solid fa-pen-to-square"></i></a>
                 <form method="post" action="' . route('dpp.user.destroy', $user->id) . '">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                      <button  data-toggle="tooltip" data-placement="top" title="Hapus User" type="submit" class="btn btn-danger btn-sm btn-secondary mr-1" style=" margin-left:2px; height:30px;"><i class="fa-solid fa-trash"></i></button>
                    </form>'; 
                }else{
                     return '<div class="d-flex justify-content-center">
                    <a  data-toggle="tooltip" data-placement="top" title="Perbaiki User" href="' . route('dpp.user.edit', $user->id) . '"class="btn btn-sm btn-warning" style="margin-left:2px; height:30px;" ><i class="fa-solid fa-pen-to-square"></i></a>
                     <form method="post" action="' . route('dpp.user.destroy', $user->id) . '">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                      <button  disabled data-toggle="tooltip" data-placement="top" title="Hapus User" type="submit" class="btn btn-danger btn-sm btn-secondary mr-3" style=" margin-left:2px; height:30px;"><i class="fa-solid fa-trash"></i></button>
                    </form>
                    </div>'; 
                    
                }
                })
                ->addIndexColumn()
                ->rawColumns(['kabupaten','action'])
                ->make(true);
        }
    }
    
    public function ajax_kepengurusan( Request $request)
    {
        if(request()->ajax()){
            if(!empty($request->from_date))
            {
                $kepengurusan = Kepengurusan::whereBetween('created_at', array($request->from_date, $request->to_date))->orderBy('id_daerah', 'asc')->get();
            }else{
                $kepengurusan = Kepengurusan::where('id_daerah', $request->id_daerah)
                ->orderBy('jabatan','asc')
                ->groupBy('id_kepengurusan')
                ->get();
            }
            return datatables()
                ->of($kepengurusan)
                ->editColumn('nama', function ($kepengurusan) {
                    return $kepengurusan->nama;
                })
              ->editColumn('jabatan', function ($kepengurusan) {
               
                   if(empty($kepengurusan->jabatan)){
                         return '<a>-</a>';
                      }else{
                        return \App\Jabatan::where('kode',$kepengurusan->jabatan)->value('nama');
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
                            <img src='". asset('uploads/img/foto_kepengurusan/'.$kepengurusan->foto) ."' alt='noimage' width='100px' height='100px'>
                        </label>
                    </div>
                    ";
                })
                ->editColumn('ttd', function ($kepengurusan) {
                    return "
                    <div class='click-zoom'>
                        <label>
                            <input type='checkbox'>
                            <img src='". asset('uploads/img/ttd_kta/'.$kepengurusan->ttd) ."' alt='noimage' width='100px' height='100px'>
                        </label>
                    </div>
                    ";
                })
                ->editColumn('alamat_kantor', function ($kepengurusan) {
                    return $kepengurusan->alamat_kantor;
                })
                ->editColumn('action', function ($kepengurusan) {
                    return '<div class="d-flex">
                        <a data-toggle="tooltip" data-placement="top" title="Perbaiki Kepengurusan Pusat" href="' . route('dpp.settings.kepengurusan.edit', $kepengurusan->id_kepengurusan) . '"class="btn btn-sm mr-2 btn-secondary"  style="margin-left:2px; height:30px;"><i class="fa-solid fa-edit"></i></a>
                        <form method="post" action="' . route('dpp.settings.kepengurusan.destroy', $kepengurusan->id_kepengurusan) . '">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <button data-toggle="tooltip" data-placement="top" title="Hapus Kepengurusan Pusat"type="submit" class="btn btn-danger btn-sm btn-secondary"  style="margin-left:2px; height:30px;"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                        ';
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'foto', 'ttd','jabatan'])
                ->make(true);
        }
    }

    public function ajax_kepengurusan_provinsi(Request $request){
        if(request()->ajax()){
            if(!empty($request->from_date))
            {
                $kepengurusan = Kepengurusan::whereBetween('created_at', array($request->from_date, $request->to_date))->orderBy('id_daerah', 'asc')->get();
            }else{
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
               ->editColumn('jabatan', function ($kepengurusan){
               
                   if(empty($kepengurusan->jabatan)){
                         return '<a>-</a>';
                      }else{
                        return \App\Jabatan::where('kode',$kepengurusan->jabatan)->value('nama');
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
                            <img src='". asset('uploads/img/foto_kepengurusan/'.$kepengurusan->foto) ."' alt='noimage' width='100px' height='100px'>
                        </label>
                    </div>
                    ";
                })
                ->editColumn('ttd', function ($kepengurusan) {
                    return "
                    <div class='click-zoom'>
                        <label>
                            <input type='checkbox'>
                            <img src='". asset('uploads/img/ttd_kta/'.$kepengurusan->ttd) ."' alt='noimage' width='100px' height='100px'>
                        </label>
                    </div>
                    ";
                })              
                ->editColumn('alamat_kantor', function ($kepengurusan) {
                    return $kepengurusan->alamat_kantor;
                })
                ->editColumn('action', function ($kepengurusan) use ($request) {
                    return '<div class="d-flex">
                        <a data-toggle="tooltip" data-placement="top" title="Perbaiki Kepengurusan DPD"href="' ."/dpp/provinsi/$request->id_daerah/kepengurusan/$kepengurusan->id_kepengurusan/edit". '"class="btn btn-sm btn-secondary"  style="margin-left:2px; height:30px;"><i class="fa-solid fa-edit"></i></a>
                        <form method="post" action="' ."/dpp/provinsi/$request->id_daerah/kepengurusan/$kepengurusan->id_kepengurusan".  '">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <button data-toggle="tooltip" data-placement="top" title="Hapus Kepengurusan DPD"type="submit" class="btn btn-danger btn-sm btn-secondary"  style="margin-left:2px; height:30px;"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                        ';
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'foto', 'ttd','jabatan'])
                ->make(true);
        }
    }
     public function ajax_kepengurusan_kecamatan(Request $request){
        if(request()->ajax()){
            if(!empty($request->from_date))
            {
                $kepengurusan = Kepengurusan::whereBetween('created_at', array($request->from_date, $request->to_date))->orderBy('id_daerah', 'asc')->get();
            }else{
                $kepengurusan = Kepengurusan::where('id_daerah', $request->id_daerah)->get();
                $jabatan = Jabatan::pluck('kode');
                
            }
            return datatables()
                ->of($kepengurusan, $request)
                ->editColumn('nama', function ($kepengurusan) {
                    return $kepengurusan->nama;
                })
                ->editColumn('jabatan', function ($kepengurusan) {
               
                   if(empty($kepengurusan->jabatan)){
                         return '<a>-</a>';
                      }else{
                        return \App\Jabatan::where('kode',$kepengurusan->jabatan)->value('nama');
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
                            <img src='". asset('uploads/img/foto_kepengurusan/'.$kepengurusan->foto) ."' alt='noimage' width='100px' height='100px'>
                        </label>
                    </div>
                    ";
                })
                ->editColumn('ttd', function ($kepengurusan) {
                    return "
                    <div class='click-zoom'>
                        <label>
                            <input type='checkbox'>
                            <img src='". asset('uploads/img/ttd_kta/'.$kepengurusan->ttd) ."' alt='noimage' width='100px' height='100px'>
                        </label>
                    </div>
                    ";
                })              
                ->editColumn('alamat_kantor', function ($kepengurusan) {
                    return $kepengurusan->alamat_kantor;
                })
                ->editColumn('action', function ($kepengurusan) use ($request) {
                    return '<div class="d-flex">
                        <a data-toggle="tooltip" data-placement="top" title="Perbaiki Kepengurusan PAC" href="' ."/dpp/kecamatan/$request->id_daerah/kepengurusan/$kepengurusan->id_kepengurusan/edit". '"class="btn btn-sm btn-secondary"  style="margin-left:2px; height:30px;"><i class="fa-solid fa-edit"></i></a>
                        <form method="post" action="' ."/dpp/kecamatan/$request->id_daerah/kepengurusan/$kepengurusan->id_kepengurusan".  '">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <button data-toggle="tooltip" data-placement="top" title="Hapus Kepengurusan PAC" type="submit" class="btn btn-danger btn-sm btn-secondary"  style="margin-left:2px; height:30px;"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                        ';
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'foto', 'ttd','jabatan'])
                ->make(true);
        }
    }
    
    public function getKelurahan(Request $request)
    {
        $data = Kelurahan::groupBy('id_kel')->where('id_kec', $request->val)
            ->get();

        return \Response::json($data);
    }

    public function getKecamatan(Request $request)
    {
        $id = Auth::user()->id;
        $detail = DetailUsers::where('userid', $id)->first();
        $data = Kecamatan::groupBy('id_kec')->where('id_kab', $request->val)
            ->get();

        return \Response::json($data);
    }

    public function getKabupaten(Request $request)
    {
        $id = Auth::user()->id;
        $detail = DetailUsers::where('userid', $id)->first();
        $data = Kabupaten::groupBy('id_kab')->where('id_prov', $request->val)
            ->get();

        return \Response::json($data);
    }

}
