<?php

namespace App\Http\Controllers\Dpc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{User,DetailUsers,MaritalStatus,Job,Provinsi,Kepengurusan,Kabupaten,Kecamatan,Kelurahan,Kantor};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ListingKTPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::user()->id;
        $detail = DetailUsers::join('kabupatens','detail_users.kabupaten_domisili','=','kabupatens.id_kab')
        ->where('detail_users.userid', $id)
        ->select('kabupatens.name')
        ->first();
       
        
        return view('dpc.listingKTP.index',compact('detail'));
    }
    
    
   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     
     
      public function ajax_listingKTP(Request $request)
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
                    ->selectRaw('users.super_admin,users.created_at, detail_users.id, detail_users.no_member ,detail_users.created_by,detail_users.nik, kabupatens.name, detail_users.nickname as nama_anggota, kabupatens.id_kab, detail_users.kabupaten_domisili, users.email ,roles.key, roles.name as nama_roles,detail_users.status_kta, detail_users.gender, detail_users.birth_place, detail_users.tgl_lahir,detail_users.pekerjaan, detail_users.status_kawin,detail_users.alamat,detail_users.kelurahan_domisili, detail_users.kecamatan_domisili, detail_users.status_kpu, status_kpu.warna_status, status_kpu.nama_status, detail_users.foto_ktp')
                    
                    ->whereIn('kabupatens.id_kab', $detail)
                    ->where('detail_users.status_kta', 1)
                    ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                    // ->where(DB::raw('LENGTH(detail_users.nik)'), '>', 16)
                    ->groupBy('detail_users.nik')
                    ->orderBy('detail_users.id', 'desc')
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
               ->editColumn('foto', function ($kabupaten){
                    $url= asset('uploads/img/foto_ktp/'.$kabupaten->foto_ktp);
                   
                  return '<div class="click-zoom">
                  
                             <label>
                                    <input type="checkbox">
                                    <img src=" '.$url.' " alt="noimage" width="240px" height="180px">
                            </label>
                        </div>';
               })
               ->editColumn('nik', function ($kabupaten) {
                    return $kabupaten->nik;
                })
               ->editColumn('keterangan', function ($kabupaten) {
                 
                   if(strlen($kabupaten->nik) > 16){
                        return '<div class="d-flex justify-content-center">
                                    <a class="custom-badge status-red"> Nik Lebih dari 16</a>
                              </div>' ;
                   }else if(strlen($kabupaten->nik) < 16){
                     
                       return '<div class="d-flex justify-content-center">
                                    <a class="custom-badge status-red"> Nik Kurang Lebih dari 16</a>
                              </div>';
                   }else{
                       return '<div class="d-flex justify-content-center">
                                    <a class="custom-badge status-green">Completed</a>
                              </div>';
                   }
                })
                ->editColumn('action', function ($kabupaten) {
                return
                '<div class="d-flex justify-content-center">
                     <a data-toggle="tooltip" data-placement="top" target="_blank_" title="Lihat Anggota" href="/dpc/member/' . $kabupaten->id . '/show" class="btn btn-sm btn-success" style="margin-left:2px; height:30px;"><i class="fa-solid fa-eye"></i></a>
                     <a  data-toggle="tooltip" data-placement="top" target="_blank_" title="Perbaiki Anggota" href="' . route('dpc.listingKTP.edit', $kabupaten->id) . '"class="btn btn-sm btn-warning" style="margin-left:2px; height:30px;" ><i class="fa-solid fa-pen-to-square"></i></a>
                </div>';
                })

                ->addIndexColumn()
                ->rawColumns(['action', 'active', 'status_kpu','keterangan','foto'])
                ->make(true);
        }
    }
    public function edit($id)
    {
        // abort_unless(\Gate::allows('member_edit'), 403);
    
        $member = DetailUsers::find($id);
 
        $detail = User::join('model_has_roles','users.id','=','model_has_roles.model_id')
        ->where('users.id', $member->userid)->first();
        // dd($detail);

        $marital = DB::table('status_pernikahans')->where('aktifya', 1)->pluck('nama', 'id');
        $roles = DB::table('roles')->whereBetween('id', array(4,5))->pluck('key', 'id');
        $provinsi = Provinsi::where('status', 1)->pluck('name', 'id_prov');
        $pendidikan = DB::table('pendidikans')->where('status', 1)->pluck('nama','id');
        $jenis_kelamin = DB::table('jenis_kelamin')->pluck('name','id');
        $anggota = DB::table('status_anggota')->where('status', 1)->pluck('name','id');
        $kabupaten =  Kabupaten::where('status', 1)->pluck('name', 'id_kab');
        $kecamatan =  Kecamatan::where('status', 1)->where('id_kab', $member->kabupaten_domisili)->pluck('name', 'id_kec');
        $kelurahan =  Kelurahan::where('status', 1)->where('id_kec' ,$member->kecamatan_domisili)->pluck('name', 'id_kel');
      
        $job = Job::where('status', 1)->pluck('name', 'id');
        $agama = DB::table('agamas')->where('status', 1)->pluck('nama','id');
        
        return view('dpc.listingKTP.edit', compact('kecamatan','kelurahan','member','detail','agama','jenis_kelamin','roles','marital', 'anggota','provinsi', 'kabupaten', 'job','pendidikan'));

    }
  

   
    public function update(Request $request, $id)
    {
         $request->validate([
      
            'avatar'    => 'max:10048',
            'foto_ktp'  => 'max:10048',
            // 'pakta_intergritas'  => 'max:2048',
    
        ]);
    
        
        $member = DetailUsers::where('id',$id)->first();
        $detail = User::where('id',$member->userid)->first();
        $avatarlama = '/www/wwwroot/hanura.net/uploads/img/users/' . $member->avatar;
        $fotolama = '/www/wwwroot/hanura.net/uploads/img/foto_ktp/' . $member->foto_ktp;
        // $paktalama = '/www/wwwroot/hanura.net/uploads/file/pakta_integritas/' . $member->pakta_intergritas;
     
         \DB::beginTransaction();
        
           
            $message['is_error'] = true;
            $message['error_msg'] = "";
            $dob = date("Y-m-d", strtotime($request->tgl_lahir));
            $count = DetailUsers::count();
            $no_member = str_pad($count+1,7,"0",STR_PAD_LEFT);
            
            $check = User::where('email', $request->emailaddress)
                    ->select('id')
                    ->first();
        
        $files = ['avatar', 'foto_ktp'];
                
            foreach($files as $file){
                if($request->file($file)){
                    $uploadedFile = $request->file($file);
                    $filename = time() . '.' . $uploadedFile->getClientOriginalName();
                    
               
                   if ($file == 'avatar') {
                        // File::delete($avatarlama);
                        Image::make($uploadedFile)->resize(250, 300)->save('uploads/img/users/' . $filename);
                    }else{
                       File::delete($fotolama);
                        Image::make($uploadedFile)->resize(500, 400)->save('uploads/img/foto_ktp/' . $filename);
                        
                    }
                    
                        $files[$file] = $filename;
                    }else{
                    $oldFile = $file . '_lama';
                 
                    if($request->input($oldFile) !== 'profile.png' && $request->input($oldFile) !== ''){
                        $files[$file] = $request->input($oldFile);
                    }else{
                        $files[$file] = 'profile.png';
                    }
                }
            }
         
        
                $detailUsers = DetailUsers::where('id',$id)->first();
                
                $user = array(
                    'name'          => $request->name,
                    'updated_at'    => date('Y-m-d H:i:s'),
                    'image'         => $files['avatar'],
               
                );
           
           
               $users = array(
                 
                    'nickname'          => $request->name,
                    'nik'               => $request->nik,
                    'avatar'            => $files['avatar'],
                    'foto_ktp'          => $files['foto_ktp'],
                    'updated_at'        => date('Y-m-d H:i:s')
                );
                // dd($user);
                // dd($users);
                $use = User::where('id', $detailUsers->userid)->update($user);
                $detail = DetailUsers::where('id', $id)->update($users);
                 \DB::commit();
          return redirect()->route('dpc.listingKTP.index')->with('success','Data berhasil diupdate');
        
    }


   
}
