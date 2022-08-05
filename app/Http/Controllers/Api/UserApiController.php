<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use App\{User,Job,Kabupaten,Kepengurusan, Provinsi, Kecamatan , Kelurahan, Kantor};
use App\Mail\VerifyEmail;
use Illuminate\Support\Str;
use App\DetailUsers;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use URL;
use PDF;




class UserApiController extends Controller
{
       public function job()
    {
        $job = Job::where('status', 1)->pluck('name', 'id');
      

        return response([
            'success'   => true,
            'message'   => 'List Semua Pekerjaan',
            'data'      => $job
        ], 200);
    }


    public function nikah()
    {
        
        $nikah = DB::table('status_pernikahans')->where('aktifya', 1)->pluck('nama', 'id');
        
      

        return response([
            'success'   => true,
            'message'   => 'List Status Pernikahan',
            'data'      => $nikah
        ], 200);
    }
    public function agama()
    {
        
        $agama = DB::table('agamas')->where('status', 1)->pluck('nama', 'id');
      

        return response([
            'success'   => true,
            'message'   => 'List Status Agama',
            'data'      => $agama
        ], 200);
    }

    public function getPOB(Request $request)
    {

        $id = Auth::user()->id;
        $detail= DetailUsers::where('userid',$id)->select('kabupaten_domisili')->first();
       
        $data = User::join('detail_users', 'users.id', '=', 'detail_users.userid')
            ->join('kabupatens', 'detail_users.kabupaten_domisili', '=', 'kabupatens.id_kab')
            ->selectRaw('kabupatens.name, kabupatens.id_kab')
           ->where('detail_users.status_kta',1)
            ->whereIn('kabupatens.id_kab',$detail)
            ->groupBy('kabupatens.id_kab')
            ->get();
    

        if(is_null($data)){
            return Response([
                'success'   => true,
                'messages'  => 'Data Not Found',
            ], 404);
        }

        return response([
            'success'   => true,
            'message'    => 'List Kabupaten Sesuai Login',
            'data'      => $data
        ], 200);
     
    }
    public function getKec(Request $request)
    {

        $id = Auth::user()->id;
        $detail= DetailUsers::where('userid',$id)->select('kabupaten_domisili')->first();
       
        $data = User::join('detail_users', 'users.id', '=', 'detail_users.userid')
            ->join('kecamatans', 'detail_users.kabupaten_domisili', '=', 'kecamatans.id_kab')
            ->selectRaw('kecamatans.name, kecamatans.id_kec,kecamatans.id_kab')
            ->whereIn('kecamatans.id_kab',$detail)
            ->where('detail_users.status_kta',1)
            ->groupBy('kecamatans.id_kec')
            ->get();
    

        if(is_null($data)){
            return Response([
                'success'   => true,
                'messages'  => 'Data Not Found',
            ], 404);
        }

        return response([
            'success'   => true,
            'message'    => 'List Kecamatan Sesuai Login',
            'data'      => $data
        ], 200);
     
    }

    public function getProv()
    {
        
        $id = Auth::user()->id;
        $detail= DetailUsers::where('userid',$id)->select('provinsi_domisili')->first();
       
        $data = User::join('detail_users', 'users.id', '=', 'detail_users.userid')
            ->join('provinsis', 'detail_users.provinsi_domisili', '=', 'provinsis.id_prov')
            ->selectRaw('provinsis.name, provinsis.id_prov')
            ->whereIn('provinsis.id_prov',$detail)
           ->where('detail_users.status_kta',1)
            ->groupBy('provinsis.id_prov')
            ->get();
    

        if(is_null($data)){
            return Response([
                'success'   => true,
                'messages'  => 'Data Not Found',
            ], 404);
        }

        return response([
            'success'   => true,
            'message'    => 'List Provinsi Sesuai Login',
            'data'      => $data
        ], 200);
    }
     public function loadpegawai(Request $request)
    {
        $data = [];
        $cari = $request->cari;
        $id = Auth::user()->id;
        $detail= DetailUsers::where('userid',$id)->select('kabupaten_domisili')->first();
        $pegawai =  User::join('detail_users','detail_users.userid','=','users.id')
        ->leftJoin('jobs','detail_users.pekerjaan','=','jobs.id')
        ->leftJoin('status_pernikahans','detail_users.status_kawin','=','status_pernikahans.id')
        ->leftJoin('jenis_kelamin','detail_users.gender','=','jenis_kelamin.id')
         ->orWhereIn('detail_users.kabupaten_domisili', $detail)
        ->orwhere('detail_users.status_kta',1)
         ->Where('detail_users.no_member','like',"%".$cari."%")
         ->orWhere('detail_users.nik','like',"%".$cari."%" )
         ->orWhere('users.username','like',"%".$cari."%")
         ->select('detail_users.kabupaten_domisili','users.name as nama_anggota','users.username','users.id','detail_users.no_member','detail_users.nik','detail_users.rt_rw','detail_users.alamat'
         ,'detail_users.birth_place','detail_users.tgl_lahir','detail_users.avatar','detail_users.foto_ktp','detail_users.kelurahan_domisili','detail_users.created_by','jenis_kelamin.name as gender','jobs.name as pekerjaan','status_pernikahans.nama as nikah')
         ->groupBy('detail_users.nik')
            ->get();
        foreach ($pegawai as $row) {
            $data[] = ['id' => $row->id,  
                        'username' => $row->username,
                        'nama_anggota' => $row->nama_anggota,
                        'nik' => $row->nik,
                        'jenis_kelamin'=> $row->gender,
                        'status_kawin' => $row->nikah,
                        'status_pekerjaan' => $row->pekerjaan,
                        'penerbit_kta' => $row->created_by,
                        'no_member' => $row->no_member,
                        'tempat_lahir' => $row->birth_place,
                        'tanggal_lahir' => $row->tgl_lahir,
                        'alamat' => $row->alamat,
                        'Kelurahan_id' => $row->kelurahan_domisili,
                        'foto_profile' => $row->avatar,
                        'foto_ktp' => $row->foto_ktp,
                        'kabupaten_domisili' => $row->kabupaten_domisili];
        }
    	 if(count($data)== null){
            return Response([
                'success'   => true,
                'messages'  => 'Data Not Found',
            ], 404);
        }

        return response([
            'success'   => true,
            'message'    => 'Berhasil Menampilkan Data',
            'data'      => $data
        ], 200);
        

    }
     public function detailUser(Request $request, $id)
    {
        $auth = Auth::user()->id;
        $detail= DetailUsers::where('userid',$auth)->select('kabupaten_domisili')->first();
        $data = DetailUsers::join('kabupatens','kabupatens.id_kab','=','detail_users.kabupaten_domisili')
        ->join('jenis_kelamin','jenis_kelamin.id','=','detail_users.gender')
        ->join('status_pernikahans','status_pernikahans.id','=','detail_users.status_kawin')
        ->join('jobs','jobs.id','=','detail_users.pekerjaan')
        ->join('kelurahans','kelurahans.id_kel','=','detail_users.kelurahan_domisili')
        ->join('kecamatans','kecamatans.id_kec','=','detail_users.kecamatan_domisili')
        ->where('detail_users.no_member',$id)
       ->where('detail_users.status_kta',1)
        ->whereIn('detail_users.kabupaten_domisili', $detail)
        ->select('detail_users.created_by as penerbit_kta','detail_users.no_member','detail_users.nickname','detail_users.nik','jenis_kelamin.name as gender','kabupatens.name as nama_kabupaten','kecamatans.name as nama_kecamatan','kelurahans.name as nama_kelurahan','detail_users.birth_place','detail_users.tgl_lahir','status_pernikahans.nama as status_nikah','jobs.name as status_pekerjaan','detail_users.alamat','detail_users.rt_rw','detail_users.kelurahan_domisili as id_kelurahan','detail_users.avatar','detail_users.foto_ktp')
        ->groupBy('detail_users.nik')
        ->get();

    	if(count($data) == null){
            return Response([
                'success'   => true,
                'messages'  => 'Data Not Found',
            ], 404);
        }

        return response([
            'success'   => true,
            'message'    => 'Berhasil Menampilkan Data',
            'data'      => $data
        ], 200);
        
    }
     public function getKtaDepan(Request $request, $id)
    {
        $settings = DB::table('settings')->where('id',$id)->select('pic_kta_depan')->first();
       $customPaper = array(10,0,320,210);
       
        $pdf = PDF::loadview('dpc.member.kta_depan',['settings'=>$settings])->setPaper($customPaper,'portrait') ;
        
        $filename = 'Kta Depan Partai Hanura';
          return $pdf->stream($filename.".pdf");
   
 
    }
     public function getPDF(Request $request, $id)
    {
        
      
        $details = DetailUsers::where('id', $id)->where('status_kta', 1)
                ->first();
                 $member = User::where('id', $details->userid)->first();

        $ketua = Kepengurusan::where('id_daerah', $details->kabupaten_domisili)->where('jabatan', 3001)->first();
 
        $sekre = Kepengurusan::where('id_daerah', $details->kabupaten_domisili)->where('jabatan', 3002)->first();
        $kantor = Kantor::where('id_daerah', $details->kabupaten_domisili)->first();
         
        $kabupaten = Kabupaten::whereIn('id_kab',$details)->first();
        $customPaper = array(10,0,320,210);
        $pdf = PDF::loadview('dpc.member.cetak',['details'=>$details,'member'=>$member,'kantor'=>$kantor, 'ketua'=>$ketua,'sekre'=>$sekre,'kabupaten'=>$kabupaten])->setPaper($customPaper,'portrait') ;
       
       $filename ='Kta_';
          return $pdf->stream($filename. ucwords(strtolower($details->nickname)).".pdf");
        
    }
    public function getKel()
    {
        
        $id = Auth::user()->id;
        $detail= DetailUsers::where('userid',$id)->select('kecamatan_domisili')->first();
       
        $data = User::join('detail_users', 'users.id', '=', 'detail_users.userid')
            ->join('kelurahans', 'detail_users.kecamatan_domisili', '=', 'kelurahans.id_kec')
            ->selectRaw('kelurahans.name, kelurahans.id_kel,kelurahans.id_kec')
            ->whereIn('kelurahans.id_kec',$detail)
           ->where('detail_users.status_kta',1)
            ->groupBy('kelurahans.id_kel')
            ->get();
    

       	if(count($data) == null){
            return Response([
                'success'   => true,
                'messages'  => 'Data Not Found',
            ], 404);
        }

        return response([
            'success'   => true,
            'message'    => 'List Kelurahan Sesuai Login',
            'data'      => $data
        ], 200);
    }

    public function updatepass(Request $request)
    {
        $input = $request->all();
        $userid = Auth::user()->id;
        $rules = array(
            'old_password' => 'required',
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password',
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $arr = array("status" => 400, "message" => $validator->errors()->first());
        } else {
            try {
                if ((Hash::check(request('old_password'), Auth::user()->password)) == false) {
                    $arr = array("status" => 400, "message" => "Check your old password.");
                } else if ((Hash::check(request('new_password'), Auth::user()->password)) == true) {
                    $arr = array("status" => 400, "message" => "Please enter a password which is not similar then current password.");
                } else {
                    User::where('id', $userid)->update(['password' => Hash::make($input['new_password'])]);
                    $arr = array("status" => 200, "message" => "Password updated successfully.");
                }
            } catch (\Exception $ex) {
                if (isset($ex->errorInfo[2])) {
                    $msg = $ex->errorInfo[2];
                } else {
                    $msg = $ex->getMessage();
                }
                $arr = array("status" => 400, "message" => $msg);
            }
        }
        return \Response::json($arr);
    }
    public function getAuthenticatedUser()
    {
        try {

            if ( !$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }
        $email = Auth::user()->email;
        $user = DB::table('detail_users')
        ->leftJoin('users','detail_users.userid','=','users.id')
        ->leftJoin('model_has_roles','model_has_roles.model_id','=','users.id')
        ->leftJoin('roles','roles.id','=','model_has_roles.role_id')
        ->select('roles.key','users.name','detail_users.no_member','detail_users.nickname','detail_users.nik')
        ->where('users.email',$email)
        ->first();
        
      
       	if($user == null){
            return Response([
                'success'   => true,
                'messages'  => 'Data Not Found',
            ], 404);
        }
       

        $response = [
            'StatusCode' => 200,
            'message'    => 'Berhasil menampilkan Data',
            'Data'       => $user,
        ];   
        return response()->json(['result' =>$response ]);
    }
    public function getKab()
    {
      
        $id = Auth::user()->id;
        $detail= DetailUsers::where('userid',$id)->select('kabupaten_domisili')->first();
        
        $data = DB::table('kepengurusan')->where('id_daerah',$detail->kabupaten_domisili)
          ->leftJoin('jabatans','kepengurusan.jabatan','=','jabatans.kode')
          ->select('kepengurusan.nama as name','kepengurusan.kta','jabatans.nama','jabatans.urutan','kepengurusan.foto','kepengurusan.ttd')
        ->where('kepengurusan.deleted_at',null)
          ->orderBy('jabatans.urutan','asc')
          ->groupBy('kepengurusan.id_kepengurusan')
          ->get();

        
       	if($data == null){
            return Response([
                'success'   => true,
                'messages'  => 'Data Not Found',
            ], 404);
        }

        return response([
            'success'   => true,
            'message'    => 'Berhasil menampilkan Data Pengurus kabupaten',
            'data'      => $data
        ], 200);
     
       
    }
    public function getKantor()
    {
      
        $id = Auth::user()->id;
        $detail= DetailUsers::where('userid',$id)->select('kabupaten_domisili')->first();
        
        $data = DB::table('kantor')->where('id_daerah',$detail->kabupaten_domisili)->first();

        
       	if($data == null){
            return Response([
                'success'   => true,
                'messages'  => 'Data Not Found',
            ], 404);
        }

        return response([
            'success'   => true,
            'message'    => 'Berhasil menampilkan Data Kantor',
            'data'      => $data
        ], 200);
     
       
    }
    public function getProvinsi()
    {
      
        $id = Auth::user()->id;
        $detail= DetailUsers::where('userid',$id)->select('provinsi_domisili')->first();
        // $roles = DetailUsers::join('model_has_roles','detail_users.userid','=','model_has_roles.model_id')
        // ->join('roles','roles.id','=','model_has_roles.role_id')
        // ->value('roles.id');
          
          $data =  DB::table('kepengurusan')->whereBetween('jabatan',[2001,2003])
          ->leftJoin('jabatans','kepengurusan.jabatan','=','jabatans.kode')
          ->select('kepengurusan.nama as name','kepengurusan.nik','kepengurusan.kta','kepengurusan.id_daerah','jabatans.nama','jabatans.urutan','kepengurusan.jabatan','kepengurusan.alamat_kantor','kepengurusan.foto','kepengurusan.ttd')
          ->where('kepengurusan.deleted_at',null)
          ->whereIn('kepengurusan.id_daerah', $detail)
        //   ->orderBy('jabatans.urutan','asc')
          ->orderBy('kepengurusan.id_daerah','asc')
          ->groupBy('kepengurusan.jabatan')
          ->groupBy('kepengurusan.id_kepengurusan')
          ->get();
         
       
       	if($data == null){
            return Response([
                'success'   => true,
                'messages'  => 'Data Not Found',
            ], 404);
        }
        
        return response([
            'success'   => true,
            'message'    => 'Berhasil menampilkan Data Pengurus Provinsi',
            'data'      => $data
        ], 200);
     
       
    }
    public function getPusat()
    {
        
          $data =  DB::table('kepengurusan')->where('id_daerah', 0)
          ->leftJoin('jabatans','kepengurusan.jabatan','=','jabatans.kode')
          ->select('kepengurusan.nama as name','kepengurusan.kta','jabatans.nama','jabatans.urutan','kepengurusan.foto','kepengurusan.ttd')
          ->where('kepengurusan.deleted_at',null)
          ->orderBy('jabatans.urutan','asc')
          ->groupBy('kepengurusan.id_kepengurusan')
          ->get();
    

       	if(count($data) == null){
            return Response([
                'success'   => true,
                'messages'  => 'Data Not Found',
            ], 404);
        }

        return response([
            'success'   => true,
            'message'    => 'Berhasil menampilkan Data Pengurus Pusat',
            'data'      => $data
        ], 200);
     
    }
    public function getAnggotaKab()
    {
        $id = Auth::user()->id;
        $detail= DetailUsers::where('userid',$id)->select('kabupaten_domisili')->first();
        $created_by = DetailUsers::join('users','detail_users.created_by','=','users.id')
        ->whereIn('detail_users.kabupaten_domisili',$detail)
        ->get('users.name');
        $data = User::join('detail_users', 'users.id', '=', 'detail_users.userid')
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('status_anggota','status_anggota.id','=','detail_users.status_kta')
                ->join('status_pernikahans','detail_users.status_kawin','=','status_pernikahans.id')
                ->join('jobs','detail_users.pekerjaan','=','jobs.id')
                ->join('kecamatans', 'detail_users.kecamatan_domisili', '=', 'kecamatans.id_kec')
                ->join('jenis_kelamin','detail_users.gender','=','jenis_kelamin.id')
                ->join('kabupatens', 'detail_users.kabupaten_domisili', '=', 'kabupatens.id_kab')
                ->join('provinsis', 'detail_users.provinsi_domisili', '=', 'provinsis.id_prov')
                ->join('kelurahans', 'detail_users.kelurahan_domisili', '=', 'kelurahans.id_kel')
                ->selectRaw(' detail_users.id,users.id_settings,detail_users.userid ,provinsis.zona_waktu as provid ,
                        kecamatans.id as kecid ,detail_users.no_member ,
                        users.name ,detail_users.nik ,detail_users.no_member, detail_users.no_hp ,
                        users.email ,jenis_kelamin.name as gender, detail_users.created_by as penerbit_kta, status_pernikahans.nama as status_pernikahan, jobs.name as status_pekerjaan, detail_users.birth_place as tempat_lahir,status_anggota.name as status_anggota,provinsis.name as nama_provinsi, kabupatens.name as nama_kabupaten, kecamatans.name as nama_kecamatan, kelurahans.name as nama_kelurahan,detail_users.rt_rw, detail_users.alamat ,detail_users.kelurahan_domisili as id_kelurahan,detail_users.tgl_lahir ,detail_users.avatar, detail_users.foto_ktp')
                ->whereIn('kabupatens.id_kab',$detail)
                ->where('detail_users.status_kta', 1)
                ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18,20])
                ->orderBy('users.created_at','asc')
               ->groupBy('detail_users.nik')
                ->get();
                
            
              

        
       	if(count($data) == null){
            return Response([
                'success'   => true,
                'messages'  => 'Data Not Found',
            ], 404);
        }

        return response([
            'success'   => true,
            'message'   => 'List Semua Member',
            'data'      => $data,
            // 'created_by'=>$created_by
        ], 200);
    }
    public function getAnggotaPending()
    {
        $id = Auth::user()->id;
        $detail= DetailUsers::where('userid',$id)->select('kabupaten_domisili')->first();
       
         $data = User::leftjoin('detail_users', 'users.id', '=', 'detail_users.userid')
                ->leftjoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                //->leftjoin('kecamatans', 'detail_users.kecamatan_domisili', '=', 'kecamatans.id_kec')
                ->leftjoin('provinsis', 'detail_users.provinsi_domisili', '=', 'provinsis.id_prov')
                ->selectRaw('detail_users.id, detail_users.no_member, detail_users.nik, detail_users.nickname,detail_users.gender,detail_users.pendidikan,detail_users.status_kawin,detail_users.agama, detail_users.pekerjaan, detail_users.birth_place, detail_users.tgl_lahir, detail_users.provinsi_domisili, detail_users.kabupaten_domisili, detail_users.kecamatan_domisili, detail_users.kelurahan_domisili, detail_users.alamat_domisili, detail_users.rt_rw, detail_users.foto_ktp, detail_users.avatar, detail_users.no_hp')
                ->whereIn('detail_users.kabupaten_domisili', $detail)
                // ->where('model_has_roles.role_id', 4)
                // ->where('users.username','=','')
                ->whereIn('model_has_roles.role_id',array(4,5))
                ->orderBy('users.created_at','asc')
                ->where('detail_users.status_kta', 0)
                ->get();
                
       	if(count($data) == null){
            return Response([
                'success'   => true,
                'messages'  => 'Data Not Found',
            ], 404);
        }

        return response([
            'success'   => true,
            'message'   => 'List Semua Member Pending',
            'data'      => $data
        ], 200);
    }
    public function getkategori()
    {
      
        $user = DB::table('article_categories')
        ->select('name')
        ->get();
       

        
       	if(count($user) == null){
            return Response([
                'success'   => true,
                'messages'  => 'Data Not Found',
            ], 404);
        }
        
        $response = [
            'StatusCode' => 200,
            'message'    => 'Berhasil menampilkan Data',
            'Data'       => $user,
        ];   
        return response()->json(['result' =>$response ]);
    }
    public function getTentang()
    {
        $tentang = DB::table('settings')->select('about_us','pic_tentang_kami as pic_about_us','pic_login','pic_after_login')->first();
        
        
       	if($tentang == null){
            return Response([
                'success'   => true,
                'messages'  => 'Data Not Found',
            ], 404);
        }
        $response = [
            'StatusCode' => 200,
            'message'    => 'Berhasil menampilkan Data Tentang Kamis',
            'Data'       => $tentang,
        ];   
        return response()->json(['result' =>$response ]);
    }
    public function getartikel()
    {
       
    
        $user = DB::table('information')
        ->leftJoin('article_categories','information.kategori_id','=','article_categories.id')
        ->select('article_categories.name as nama','information.name','information.gambar','information.content','information.created_at')
        ->get();
       
       
       	if(count($user) == null){
            return Response([
                'success'   => true,
                'messages'  => 'Data Not Found',
            ], 404);
        }
        $response = [
            'StatusCode' => 200,
            'message'    => 'Berhasil menampilkan Data',
            'Data'       => $user,
        ];   
        return response()->json(['result' =>$response ]);
    }
    public function login(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
     
        $credentials = $request->only('username', 'password');
  
      
        $token = null;

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid username or Password',
            ], 401);
        }
      

        //mencari email dan pass

        $user = DB::table('detail_users')
        ->leftJoin('model_has_roles','detail_users.userid','=','model_has_roles.model_id')
        ->leftJoin('roles','model_has_roles.role_id','=','roles.id')
        ->leftJoin('users','detail_users.userid','=','users.id')
        ->select('users.name','users.email','detail_users.no_member','detail_users.nickname','detail_users.nik','roles.name as roles')
        ->whereIn('model_has_roles.role_id', array(4,5))
        ->where('detail_users.status_kta', 1)
        ->where('users.username',$request->get('username'))
        ->first();
        
        if (! $user ) return response()->json([ 'username' => ['Anda Bukan Anggota DPC dan PAC'] ], 401);

        $response = [
            'statusCode' => 200,
            'message'    => 'Login Berhasil',
            'token'     => $token,
            'Data'      => $user,
        ];
        return response()->json(['result' => $response]);
    }


 
    public function daftar(Request $request)
    {
        DB::beginTransaction();
        try {
            $count = DetailUsers::count();
            $no_member = str_pad($count+1,12,"0",STR_PAD_LEFT);

            $validator = Validator::make($request->all(), [
                'name'              => 'required',
                'nik'              => 'required',
                // 'emailaddress'      => 'required|email|unique:users,email',
                // 'password'          => 'required',
                'rt_rw'             => 'required',
                // 'pendidikan'        =>'required',
                // 'no_ktp'            => 'required|numeric',
                'gender'            => 'required',
                'tgl_lahir'         => 'required',
                'birth_place'       => 'required',
                'status_kawin'      => 'required',
                'pekerjaan'         => 'required',
                //'no_hp'             => 'required|numeric',
                'alamat'            => 'required',
                // 'provinsi'          => 'required',
                // 'kabupaten'         => 'required',
                'kecamatan'         => 'required',
                'kelurahan'         => 'required',
                'agama'         => 'required',
                'avatar'           =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
                'foto_ktp'          => 'required|max:10048',
            ],
            [
                'name.required'             => 'Masukkan nama !',
                'nik.required'             => 'Masukkan nik !',
                // 'emailaddress.required'     => 'Masukkan email yg Valid !',
                // 'password.required'         => 'Masukkan password !',
                // 'no_ktp.required'           => 'Masukkan no_ktp / harus nomor !',
                'rt_rw.required'            =>'Masukan Rt Rw !',
                // 'pendidikan.required'       => 'Masukan Pendidikan !',
                'gender.required'           => 'Masukkan Gender !',
                'agama.required'           => 'Masukkan Agama !',
                'tgl_lahir.required'        => 'Masukkan tanggal lahir !',
                'birth_place.required'      => 'Masukkan tempat lahir !',
                'pekerjaan.required'        => 'Masukkan Pekerjaan !',
               // 'no_hp.required'            => 'Masukkan nomor HP !',
                'foto_ktp.required'         => 'Masukkan Foto KTP !',
                'avatar.required'         => 'Masukkan Foto Profil !',
                'alamat.required'           => 'Masukkan Alamat !',
                // 'provinsi.required'         => 'Masukkan provinsi !',
                // 'kabupaten.required'        => 'Masukkan kabupaten !',
                'kecamatan.required'        => 'Masukkan kecamatan !',
                'kelurahan.required'        => 'Masukkan kelurahan !',
               
            ]);
            $nik = DetailUsers::where('nik', $request->nik)
                    ->where('status_kta' ,'!=', 5)
                    ->select('id')
                    ->first();
                   
             
                  
           
            if($nik != null) {
              return response()->json([
                    'success'   => false,
                    'message'   => 'Nik Sudah Ada',
                     'data'      => $validator->errors()
                 
                ], 400);
            }
            
            if($validator->fails()) {
                return response()->json([
                    'success'   => false,
                    'message'   => 'silahkan isi kolom yang kosong',
                    'data'      => $validator->errors()
                ], 400);
            } else {
                
             $files = ['avatar', 'foto_ktp'];
                
            foreach($files as $file){
                if($request->file($file)){
                    $uploadedFile = $request->file($file);
                    $filename = time() . '.' . $uploadedFile->getClientOriginalName();
                    
                    if ($file == 'avatar') {
                      
                        Image::make($uploadedFile)->resize(250, 300)->save('uploads/img/users/' . $filename);
                    }else{
                        Image::make($uploadedFile)->resize(500, 400)->save('uploads/img/foto_ktp/' . $filename);
                    }
                    
                    $files[$file] = $filename;
                }else{
                    $files[$file] = 'profile.png';
                }
            }
               
                $dob = date("Y-m-d", strtotime($request->tgl_lahir));
                $dpc =\Auth::user()->id;
                $provinsi = DetailUsers::where('userid', $dpc)->value('provinsi_domisili');
                $kabupaten = DetailUsers::where('userid', $dpc)->value('kabupaten_domisili');
               
                $kecamatan = Kecamatan::where('id_kec',$request->kecamatan)->value('id_kec');
         
                $kelurahan = Kelurahan::where('id_kel', $request->kelurahan)->value('id_kel');
                
                $alamat = Kepengurusan::where('id_daerah',$kabupaten)->value('alamat_kantor');
           
                
                // $provinsi = Provinsi::where('id_prov',$request->provinsi)->value('id_prov');
                
                // $kabupaten = Kabupaten::where('id_kab',$request->kabupaten)->value('id_kab');
                $kabup = substr($kabupaten,2);
              
                // $kecamatan = Kecamatan::where('id_kec',$request->kecamatan)->value('id_kec');
                $kec = substr($kecamatan,4);
             
                
                // $kelurahan = Kelurahan::where('id_kel',$request->kelurahan)->value('id_kel');
                $kel = substr($kelurahan,6);
                
                $noUrutAkhir =DetailUsers::where('kabupaten_domisili', $kabupaten)->count();
                // dd($noUrutAkhir);
                $no_anggota =   $provinsi . '.' .$kabup . '.' . $kec . '.' . $kel . '.' . sprintf("%06s", abs($noUrutAkhir + 1)) ;
            //   $username =   $provinsi .$kabup .$noUrutAkhir  ;
                $users = User::create([
                    'name'          => $request->name,
                    // 'email'         => $request->emailaddress,
                    // 'username'      => $username,
                    // 'password'      => $request->password,
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s'),
                    'is_active'     => 1,
                    'address'       =>$request->alamat,
                    // 'phone_number'       =>$request->no_hp,
                    'image'         => $files['avatar'],
                     'id_settings' => 1,
                ]);
           

                $roles = DB::table('model_has_roles')
                        ->insert([
                            'model_type' => 'App\User', 
                            'role_id' => 4,
                            'model_id' => $users->id
                ]);
              
      

                $data = array(
                    'userid'            => $users->id,
                    'no_member'         => $no_anggota,
                    'nickname'          => $request->name,
                    'nik'               => $request->nik,
                    'rt_rw'               => $request->rt_rw,
                    'gender'            => $request->gender,
                    'status_kta'         => 0,
                    'status_kpu'         => 1,
                    // 'pendidikan'         => $request->pendidikan,
                    'birth_place'       => $request->birth_place,
                    'agama'             => $request->agama,
                    'tgl_lahir'         => $dob,
                    'status_kawin'      => $request->status_kawin,
                    'pekerjaan'         => $request->pekerjaan,
                    'no_hp'             => $request->no_hp,
                    'alamat'            => $request->alamat,
                     'provinsi_domisili'          => $request->provinsi,
                    'kabupaten_domisili'         => $request->kabupaten,
                    'kecamatan_domisili'         => $request->kecamatan,
                    'kelurahan_domisili'         => $request->kelurahan,
                    'alamat_domisili'   => $request->alamat,
                    'activation_code'   => Str::random(40).$request->input('email'),
                    'avatar'            => $files['avatar'],
                    // 'pakta_intergritas'  => $pakta_name,
                    'foto_ktp'          => $files['foto_ktp'],
                   // 'created_at'        => date('Y-m-d')
                );
              
            
                $detail = DetailUsers::insert($data);
                // Mail::to($users->email)->send(new VerifyEmail($users));
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data Anggota Berhasil Disimpan!',
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Data Anggota Gagal Disimpan!',
            ], 400);
        }
    }
     public function update(Request $request, $id)
    {
        
        $member = DetailUsers::where('id',$id)->first();
   
        $detail = User::where('id',$member->userid)->first();
     
         DB::beginTransaction();
        try {
            $count = DetailUsers::count();
            $no_member = str_pad($count+1,12,"0",STR_PAD_LEFT);

            $validator = Validator::make($request->all(), [
                'name'              => 'required',
                'nik'              => 'required',
                // 'emailaddress'      => 'required|email|unique:users,email',
                // 'password'          => 'required',
                'rt_rw'             => 'required',
                // 'pendidikan'        =>'required',
                // 'no_ktp'            => 'required|numeric',
                'gender'            => 'required',
                'tgl_lahir'         => 'required',
                'birth_place'       => 'required',
                'status_kawin'      => 'required',
                'pekerjaan'         => 'required',
              //  'no_hp'             => 'required|numeric',
                'alamat'            => 'required',
                // 'provinsi'          => 'required',
                // 'kabupaten'         => 'required',
               // 'kecamatan'         => 'required',
               // 'kelurahan'         => 'required',
                'agama'         => 'required',
                'avatar'           => 'required|mimes:jpeg,jpg,png,gif|required|max:10048',
                'foto_ktp'          => 'required|mimes:jpeg,jpg,png,gif|required|max:10048',
            ],
            [
                'name.required'             => 'Masukkan nama !',
                'nik.required'             => 'Masukkan nik !',
                // 'emailaddress.required'     => 'Masukkan email yg Valid !',
                // 'password.required'         => 'Masukkan password !',
                // 'no_ktp.required'           => 'Masukkan no_ktp / harus nomor !',
                'rt_rw.required'            =>'Masukan Rt Rw !',
                // 'pendidikan.required'       => 'Masukan Pendidikan !',
                'gender.required'           => 'Masukkan Gender !',
                'agama.required'           => 'Masukkan Agama !',
                'tgl_lahir.required'        => 'Masukkan tanggal lahir !',
                'birth_place.required'      => 'Masukkan tempat lahir !',
                'pekerjaan.required'        => 'Masukkan Pekerjaan !',
               // 'no_hp.required'            => 'Masukkan nomor HP !',
                'foto_ktp.required'         => 'Masukkan Foto KTP !',
                'avatar.required'         => 'Masukkan Foto Profil !',
                'alamat.required'           => 'Masukkan Alamat !',
                // 'provinsi.required'         => 'Masukkan provinsi !',
                // 'kabupaten.required'        => 'Masukkan kabupaten !',
                //'kecamatan.required'        => 'Masukkan kecamatan !',
                //'kelurahan.required'        => 'Masukkan kelurahan !',
               
            ]);
             $dob = date("Y-m-d", strtotime($request->tgl_lahir));
            if($validator->fails()) {
                return response()->json([
                    'success'   => false,
                    'message'   => 'silahkan isi kolom yang kosong',
                    'data'      => $validator->errors()
                ], 400);
            } else {
           
            $files = ['avatar', 'foto_ktp'];
                
            foreach($files as $file){
                if($request->file($file)){
                    $uploadedFile = $request->file($file);
                    $filename = time() . '.' . $uploadedFile->getClientOriginalName();
                    
                    if ($file == 'avatar') {
                      
                        Image::make($uploadedFile)->resize(250, 300)->save('uploads/img/users/' . $filename);
                    }else{
                        Image::make($uploadedFile)->resize(500, 400)->save('uploads/img/foto_ktp/' . $filename);
                    }
                    
                    $files[$file] = $filename;
                }else{
                    $files[$file] = 'profile.png';
                }
            }
               
                $dpc =\Auth::user()->id;
                $provinsi = DetailUsers::where('userid', $dpc)->value('provinsi_domisili');
         
                $kabupaten = DetailUsers::where('userid', $dpc)->value('kabupaten_domisili');
               
                $kecamatan = Kecamatan::where('id_kec',$request->kecamatan)->value('id_kec');
                $kelurahan = Kelurahan::where('id_kel', $request->kelurahan)->value('id_kel');
                   $alamat = Kepengurusan::where('id_daerah',$kabupaten)->value('alamat_kantor');
           
                
                // $provinsi = Provinsi::where('id_prov',$request->provinsi)->value('id_prov');
                
                // $kabupaten = Kabupaten::where('id_kab',$request->kabupaten)->value('id_kab');
                $kabup = substr($kabupaten,2);
              
                // $kecamatan = Kecamatan::where('id_kec',$request->kecamatan)->value('id_kec');
                $kec = substr($kecamatan,4);
                
                // $kelurahan = Kelurahan::where('id_kel',$request->kelurahan)->value('id_kel');
                $kel = substr($kelurahan,6);
                
                $noUrutAkhir =DetailUsers::where('kabupaten_domisili', $kabupaten)->count();
                // dd($noUrutAkhir);
                $no_anggota =   $provinsi . '.' .$kabup . '.' . $kec . '.' . $kel . '.' . sprintf("%06s", abs($noUrutAkhir)) ;
                // $username =   $provinsi .$kabup .$noUrutAkhir  ;
                
                $detailUsers = DetailUsers::where('id',$id)->first();
      
                
                
                 $users = User::where('id', $detailUsers->userid)->update([
                        'name'          => $request->name,
                    // 'email'         => $request->emailaddress,
                    // 'username'      => $username,
                    // 'password'      => $request->password,
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s'),
                    'is_active'     => 1,
                    'address'       =>$request->alamat,
                    'phone_number'       =>$request->no_hp,
                     'image'         => $files['avatar'],
                     'id_settings' => 1,
                ]);
               

               $users = DetailUsers::where('id', $id)->update([
                    //'no_member'         => $no_anggota,
                    'nickname'          => $request->name,
                    'nik'               => $request->nik,
                    'rt_rw'               => $request->rt_rw,
                    'gender'            => $request->gender,
                    'status_kta'         => 1,
                    // 'pendidikan'         => $request->pendidikan,
                    'birth_place'       => $request->birth_place,
                    'agama'             => $request->agama,
                    'tgl_lahir'         => $dob,
                    'status_kawin'      => $request->status_kawin,
                    'pekerjaan'         => $request->pekerjaan,
                    'no_hp'             => $request->no_hp,
                    'alamat'            => $request->alamat,
                   // 'provinsi_domisili'          => $request->provinsi,
                   // 'kabupaten_domisili'         => $request->kabupaten,
                   // 'kecamatan_domisili'         => $request->kecamatan,
                   // 'kelurahan_domisili'         => $request->kelurahan,
                    'alamat_domisili'   => $request->alamat,
                    'activation_code'   => Str::random(40).$request->input('email'),
                   'avatar'            => $files['avatar'],
                    'foto_ktp'          => $files['foto_ktp'],
                    // 'pakta_intergritas'  => $files['pakta_intergritas'],
                    'updated_at'        => date('Y-m-d')
                ]);
            
        }
      DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data Anggota Berhasil DiUpdate!',
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Data Anggota Gagal DiUpdate!',
            ], 400);
        }

        
    }
     public function updatepending(Request $request, $id)
    {
        
        $member = DetailUsers::where('id',$id)->where('status_kta', 0)->first();
        
     
         DB::beginTransaction();
        try {
            $count = DetailUsers::count();
            $no_member = str_pad($count+1,12,"0",STR_PAD_LEFT);

            $validator = Validator::make($request->all(), [
                'name'              => 'required',
                'nik'              => 'required',
                // 'emailaddress'      => 'required|email|unique:users,email',
                // 'password'          => 'required',
                'rt_rw'             => 'required',
                // 'pendidikan'        =>'required',
                // 'no_ktp'            => 'required|numeric',
                'gender'            => 'required',
                'tgl_lahir'         => 'required',
                'birth_place'       => 'required',
                'status_kawin'      => 'required',
                'pekerjaan'         => 'required',
                // 'no_hp'             => 'required|numeric',
                'alamat'            => 'required',
                // 'provinsi'          => 'required',
                // 'kabupaten'         => 'required',
                //'kecamatan'         => 'required',
               // 'kelurahan'         => 'required',
                'agama'         => 'required',
                'avatar'           => 'required|mimes:jpeg,jpg,png,gif|required|max:10048',
                'foto_ktp'          => 'required|mimes:jpeg,jpg,png,gif|required|max:10048',
            ],
            [
                'name.required'             => 'Masukkan nama !',
                'nik.required'             => 'Masukkan nik !',
                // 'emailaddress.required'     => 'Masukkan email yg Valid !',
                // 'password.required'         => 'Masukkan password !',
                // 'no_ktp.required'           => 'Masukkan no_ktp / harus nomor !',
                'rt_rw.required'            =>'Masukan Rt Rw !',
                // 'pendidikan.required'       => 'Masukan Pendidikan !',
                'gender.required'           => 'Masukkan Gender !',
                'agama.required'           => 'Masukkan Agama !',
                'tgl_lahir.required'        => 'Masukkan tanggal lahir !',
                'birth_place.required'      => 'Masukkan tempat lahir !',
                'pekerjaan.required'        => 'Masukkan Pekerjaan !',
                //'no_hp.required'            => 'Masukkan nomor HP !',
                'foto_ktp.required'         => 'Masukkan Foto KTP !',
                'avatar.required'         => 'Masukkan Foto Profil !',
                'alamat.required'           => 'Masukkan Alamat !',
                // 'provinsi.required'         => 'Masukkan provinsi !',
                // 'kabupaten.required'        => 'Masukkan kabupaten !',
               // 'kecamatan.required'        => 'Masukkan kecamatan !',
                //'kelurahan.required'        => 'Masukkan kelurahan !',
               
            ]);
             $dob = date("Y-m-d", strtotime($request->tgl_lahir));
            if($validator->fails()) {
                return response()->json([
                    'success'   => false,
                    'message'   => 'silahkan isi kolom yang kosong',
                    'data'      => $validator->errors()
                ], 400);
            } else {
            $files = ['avatar', 'foto_ktp'];
                
            foreach($files as $file){
                if($request->file($file)){
                    $uploadedFile = $request->file($file);
                    $filename = time() . '.' . $uploadedFile->getClientOriginalName();
                    
                    if ($file == 'avatar') {
                      
                        Image::make($uploadedFile)->resize(250, 300)->save('uploads/img/users/' . $filename);
                    }else{
                        Image::make($uploadedFile)->resize(500, 400)->save('uploads/img/foto_ktp/' . $filename);
                    }
                    
                    $files[$file] = $filename;
                }else{
                    $files[$file] = 'profile.png';
                }
            }
               
                $dpc =\Auth::user()->id;
                 if($request->provinsi == $member->provinsi_domisili && $request->kabupaten == $member->kabupaten_domisili && $request->kecamatan == $member->kecamatan_domisili && $request->kelurahan == $member->kelurahan_domisili){
                    $no_anggota = $member->no_member;
                }else{
                         
                $provinsi = DetailUsers::where('userid', $dpc)->value('provinsi_domisili');
                $kabupaten = DetailUsers::where('userid', $dpc)->value('kabupaten_domisili');
               
                $kecamatan = Kecamatan::where('id_kec',$request->kecamatan)->value('id_kec');
                $kelurahan = Kelurahan::where('id_kel', $request->kelurahan)->value('id_kel');
                $kabup = substr($kabupaten,2);
                $kec = substr($kecamatan,4);
                $kel = substr($kelurahan,6);
                
                $noUrutAkhir =DetailUsers::where('kabupaten_domisili', $kabupaten)->count();
                // dd($noUrutAkhir);
                $no_anggota =   $provinsi . '.' .$kabup . '.' . $kec . '.' . $kel . '.' . sprintf("%06s", abs($noUrutAkhir)) ;
                // $username =   $provinsi .$kabup .$noUrutAkhir  ;
                }
                // dd($no_anggota);
                
    
                $detailUsers = DetailUsers::where('id',$id)->first();
      
                
                
                 $users = User::where('id', $detailUsers->userid)->update([
                    'name'          => $request->name,
                    // 'email'         => $request->emailaddress,
                    // 'username'      => $username,
                    // 'password'      => $request->password,
                    'updated_at'    => date('Y-m-d H:i:s'),
                    'is_active'     => 1,
                    'address'       =>$request->alamat,
                    // 'phone_number'       =>$request->no_hp,
                    'image'         => $files['avatar'],
                     'id_settings' => 1,
                ]);
               

               $users = DetailUsers::where('id', $id)->update([
                   // 'no_member'         => $no_anggota,
                    'nickname'          => $request->name,
                    'nik'               => $request->nik,
                    'rt_rw'               => $request->rt_rw,
                    'gender'            => $request->gender,
                    'status_kta'         => 0,
                    // 'pendidikan'         => $request->pendidikan,
                    'birth_place'       => $request->birth_place,
                    'agama'             => $request->agama,
                    'tgl_lahir'         => $dob,
                    'status_kawin'      => $request->status_kawin,
                    'pekerjaan'         => $request->pekerjaan,
                     'no_hp'             => $request->no_hp,
                    'alamat'            => $request->alamat,
                  //  'provinsi_domisili'          => $request->provinsi,
                   // 'kabupaten_domisili'         => $request->kabupaten,
                   // 'kecamatan_domisili'         => $request->kecamatan,
                   // 'kelurahan_domisili'         => $request->kelurahan,
                    'alamat_domisili'   => $request->alamat,
                    'activation_code'   => Str::random(40).$request->input('email'),
                    'avatar'            => $files['avatar'],
                    'foto_ktp'          => $files['foto_ktp'],
                    // 'pakta_intergritas'  => $files['pakta_intergritas'],
                    'updated_at'        => date('Y-m-d')
                ]);
              
            
        }
      DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data Anggota Berhasil DiUpdate!',
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Data Anggota Gagal DiUpdate!',
            ], 400);
        }

        
    }
    public function destroy($id)
    {
       $detail = DetailUsers::where('id',$id)->get();
  
        try{
            
    
          foreach ($detail as $det) {
             $update = DetailUsers::where('id', $det->id)->update(array(
            'status_kta' => 5
            ));
    
        }
         
        return response()->json([
                'success' => true,
                'message' => 'Data Anggota Berhasil Dihapus!',
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Data Anggota Gagal Disimpan!',
            ], 400);
        }
    }
   /////postman new
   
    // public function getPOB(Request $request)
    // {
    //     $data = Kabupaten::all();
        
    //     return response([
    //         'success'   => true,
    //         'message'   => 'List Semua Kota',
    //         'data'      => $data
    //     ], 200);
    // }

    public function prov()
    {
        
        $prov = Provinsi::all();

        return response([
            'success'   => true,
            'message'   => 'List Semua Provinsi',
            'data'      => $prov
        ], 200);
    }

    public function kel(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'id_kec'  => 'required'
        ],
        [
            'id_kec.required'         => 'Masukkan kecamatan !',
        ]);

        if($validator->fails()) {
            return response()->json([
                'success'   => false,
                'message'   => 'silahkan isi kolom yang kosong',
                'data'      => $validator->errors()
            ], 400);
        } else {
            $data = Kelurahan::where('id_kec', $request->input('id_kec'))
                ->get();
            
            if(is_null($data)){
                return Response([
                    'success'   => true,
                    'messages'  => 'Data Not Found',
                ], 404);
            }
            
            return response([
                'success'   => true,
                'message'   => 'List Semua Kelurahan',
                'data'      => $data
            ], 200);
        }
    }

    public function kec(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_kab'  => 'required'
        ],
        [
            'id_kab.required'         => 'Masukkan Kabupaten !',
        ]);

        if($validator->fails()) {
            return response()->json([
                'success'   => false,
                'message'   => 'silahkan isi kolom yang kosong',
                'data'      => $validator->errors()
            ], 400);
        } else {
            $data = Kecamatan::where('id_kab', $request->input('id_kab'))
                ->get();
            
            if(is_null($data)){
                return Response([
                    'success'   => true,
                    'messages'  => 'Data Not Found',
                ], 404);
            }

            return response([
                'success'   => true,
                'message'   => 'List Semua Kecamatan',
                'data'      => $data
            ], 200);
        }
        

        return \Response::json($data);
    }

    public function kab(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_prov'  => 'required'
        ],
        [
            'id_prov.required'         => 'Masukkan Provinsi !',
        ]);

        if($validator->fails()) {
            return response()->json([
                'success'   => false,
                'message'   => 'silahkan isi kolom yang kosong',
                'data'      => $validator->errors()
            ], 400);
        } else {
            $data = Kabupaten::where('id_prov', $request->input('id_prov'))
            ->get();

            if(is_null($data)){
                return Response([
                    'success'   => true,
                    'messages'  => 'Data Not Found',
                ], 404);
            }

            return response([
                'success'   => true,
                'message'   => 'List Semua Kabupaten',
                'data'      => $data
            ], 200);
        }
    }
}
