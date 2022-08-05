<?php

namespace App\Http\Controllers\Dpd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{User,DetailUsers,MaritalStatus,Job,Provinsi,Kepengurusan,Kabupaten,Kecamatan,Kelurahan,Kantor};
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


class ListUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::user()->id;
        $detail = DetailUsers::join('provinsis','detail_users.provinsi_domisili','=','provinsis.id_prov')
        ->where('detail_users.userid', $id)
        ->select('provinsis.name')
        ->first();
       
        
        return view('dpd.listuser.index',compact('detail'));
    }
      public function create()
    {
        // abort_unless(\Gate::allows('member_create'), 403);
        $id = Auth::user()->id;
        $detail = DetailUsers::where('userid',$id)->first();
        $user = User::where('id', $id)->first();
       
    
 
 
        $marital = DB::table('status_pernikahans')->where('aktifya', 1)->pluck('nama', 'id');
        $provinsi = Provinsi::where('status', 1)->pluck('name', 'id_prov');
        $pendidikan = DB::table('pendidikans')->where('status', 1)->pluck('nama','id');
        $jenis_kelamin = DB::table('jenis_kelamin')->pluck('name','id');
        $anggota = DB::table('status_anggota')->where('status', 1)->pluck('name','id');
        $kabupaten =  Kabupaten::where('status', 1)->where('id_prov', $detail->provinsi_domisili)->pluck('name', 'id_kab');
        // $kecamatan =  Kecamatan::where('status', 1)->where('id_kab', $detail->kabupaten_domisili)->pluck('name', 'id_kec');
        $job = Job::where('status', 1)->pluck('name', 'id');
        $agama = DB::table('agamas')->where('status', 1)->pluck('nama','id');
         $noUrutAkhir =DetailUsers::join('users','detail_users.userid','=','userid')
        ->where('detail_users.provinsi_domisili', $detail->provinsi_domisili)
        ->where('users.username','!=', '')
        ->count();
        
        $no_anggota =   $user->username . sprintf("%01s", abs($noUrutAkhir + 1)) ;
        return view('dpd.listuser.create', compact('detail','agama','jenis_kelamin','marital', 'anggota','provinsi', 'kabupaten', 'job','pendidikan','no_anggota'));
    }

      public function loaddata(Request $request)
    {
        $data = [];
        $id = Auth::user()->id;
        $detail= DetailUsers::where('userid',$id)->select('provinsi_domisili')->first();
        $pembatalan =  User::join('model_has_roles','users.id','=','model_has_roles.model_id')
            ->join('detail_users','users.id','=','detail_users.userid')
            ->where('detail_users.status_kta', 1)
            ->where('users.username','')
            ->where('model_has_roles.role_id',4)
            ->whereIn('detail_users.provinsi_domisili', $detail)
            ->where('detail_users.nickname', 'like', '%' . $request->q . '%')
            ->groupBy('detail_users.id')
            ->get();
        foreach ($pembatalan as $row) {
            $data[] = ['id' => $row->id,  'text' => $row->nickname];
        }
       
    		return response()->json($data);
    }
     public function searchAnggota(Request $request)
    {
        $data = [];
        $roles= DB::table('model_has_roles')
            ->leftJoin('users','model_has_roles.model_id','=','users.id')
            ->leftJoin('roles','model_has_roles.role_id','=','roles.id')
            ->leftJoin('detail_users','detail_users.userid','=','users.id')
            ->leftJoin('provinsis','detail_users.provinsi_domisili','=','provinsis.id_prov')
            ->leftJoin('kabupatens','detail_users.kabupaten_domisili','=','kabupatens.id_kab')
            ->leftJoin('kecamatans','detail_users.kecamatan_domisili','=','kecamatans.id_kec')
            ->leftJoin('kelurahans','detail_users.kelurahan_domisili','=','kelurahans.id_kel')
            ->select('provinsis.name as provinsi','kabupatens.name as kabupaten','kecamatans.name as kecamatan','kelurahans.name as kelurahan','roles.key','detail_users.id','detail_users.no_member','detail_users.nik','detail_users.alamat','detail_users.nickname','detail_users.avatar')
            ->where('detail_users.id',$request->id)->get();
       
            

            foreach ($roles as $value) {
                $data[] = [
                    'id' => $value->id,
                    'no_member' => $value->no_member,
                    'nik_1' => $value->nik,
                    'alamat_1' => $value->alamat,
                    'roles' => $value->key,
                    'provinsi_1' => $value->provinsi,
                    'kabupaten_1' => $value->kabupaten,
                    'kecamatan_1' => $value->kecamatan,
                    'kelurahan_!' => $value->kelurahan,
                ];
            }
          
        return response()->json($data);
    }
    
    public function having(Request $request){
         \DB::beginTransaction();
        try {
        $update = DetailUsers::where('id', $request->id_anggota)->first();

    
        $data = (array(
            'username' => $request->username,
            'password' =>  Hash::make(request('password_1'))
            ));
        
     
        $user = User::where('id', $update->userid)->update($data); 
        $roles = \DB::table('model_has_roles')->where('model_id', $update->userid)->update([
                'role_id' => 11
            ]);
           \DB::commit();
                $message['is_error'] = false;
                $message['error_msg'] = "Pendaftaran Berhasil";
        } catch (\Throwable $th) {
            throw $th;
            \DB::rollback();
            $message['is_error'] = true;
            $message['error_msg'] = "Pendaftaran Gagal";
        }
        
     return response()->json($message);
    }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
   
         \DB::beginTransaction();
        try {
          
           
            $message['is_error'] = true;
            $message['error_msg'] = "";
            $dob = date("Y-m-d", strtotime($request->tgl_lahir));
            $count = DetailUsers::count();
            $no_member = str_pad($count+1,7,"0",STR_PAD_LEFT);
            
            $check = User::where('email', $request->emailaddress)
                    ->select('id')
                    ->first();
            $nik = DetailUsers::where('nik', $request->nik)
                    ->select('id')
                    ->first();
                  
            if(isset($check->id)) {
                $message['is_error'] = true;
                $message['error_msg'] = "Email Sudah Ada";
            } 
            if(isset($nik->id)) {
                $message['is_error'] = true;
                $message['error_msg'] = "Nik Sudah Ada";
            } else {
                
           $files = ['avatar', 'foto_ktp'];
                
            foreach($files as $file){
                if($request->file($file)){
                    $uploadedFile = $request->file($file);
                    $filename = time() . '.' . $uploadedFile->getClientOriginalName();
                    
                    // if ($file == 'avatar') {
                      
                    //     Image::make($uploadedFile)->resize(250, 300)->save('uploads/img/users/' . $filename);
                    // }elseif($file == 'foto_ktp'){
                    //     Image::make($uploadedFile)->resize(500, 400)->save('uploads/img/foto_ktp/' . $filename);
                    // }else{
                        
                    // $uploadedFile->move('uploads/file/pakta_integritas/', $filename);
                        
                    // }
                    if ($file == 'avatar') {
                      
                        Image::make($uploadedFile)->resize(250, 300)->save('uploads/img/users/' . $filename);
                    }else{
                        Image::make($uploadedFile)->resize(500, 400)->save('uploads/img/foto_ktp/' . $filename);
                    }
                    
                    $files[$file] = $filename;
                }else{
                    $files[$file] = '';
                }
            }
               
                $dpc =\Auth::user()->id;
                $provinsi = DetailUsers::where('userid', $dpc)->value('provinsi_domisili');
                $kabupaten = Kabupaten::where('id_kab', $request->kabupaten)->value('id_kab');
              
               
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
               /*  $username =   $provinsi .$kabup .$noUrutAkhir  ;*/
                $users = User::create([
                    'name'          => $request->name,
                    'email'         => $request->emailaddress,
                    'password'      => $request->password,
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s'),
                    'is_active'     => 1,
                    'address'       =>$request->address,
                    'phone_number'       =>$request->no_hp,
                    'image'         => $files['avatar'],
                    'id_settings' => 1,
                    // 'username' => $username
                    
                ]);
           

                $roles = \DB::table('model_has_roles')
                        ->insert([
                            'model_type' => 'App\User', 
                            'role_id' => 11,
                            'model_id' => $users->id
                ]);
            
             
                $data = array(
                    'userid'            => $users->id,
                    'no_member'         => $no_anggota,
                    'agama'             => $request->agama,
                    'nickname'          => $request->name,
                    'nik'               => $request->nik,
                    'rt_rw'               => $request->rt_rw,
                    'gender'            => $request->gender,
                    'status_kta'         => 0,
                    'status_kpu'         => 1,
                    // 'pendidikan'         => $request->status_pendidikan,
                    'birth_place'       => $request->tempat_lahir,
                    'tgl_lahir'         => $dob,
                    'status_kawin'      => $request->marital,
                    'pekerjaan'         => $request->job,
                    'no_hp'             => $request->no_hp,
                    'alamat'            => $request->address,
                    // 'kode_pos'            => $request->kode_pos,
                    'provinsi_domisili'          => $request->provinsi,
                    'kabupaten_domisili'         => $request->kabupaten,
                    'kecamatan_domisili'         => $request->kecamatan,
                    'kelurahan_domisili'         => $request->kelurahan,
                    'alamat_domisili'   => $request->address,
                    'activation_code'   => Str::random(40).$request->input('email'),
                    'avatar'            => $avatar['avatar'],
                    'foto_ktp'          => $files['foto_ktp'],
                    // 'pakta_intergritas'  => $files['pakta_intergritas'],
                  
                    'created_at'        => date('Y-m-d H:i:s')
                );
   
            
                $detail = DetailUsers::insert($data);
                
                \DB::commit();
                $message['is_error'] = false;
                $message['error_msg'] = "Pendaftaran Berhasil";
            }
        } catch (\Throwable $th) {
            throw $th;
            \DB::rollback();
            $message['is_error'] = true;
            $message['error_msg'] = "Pendaftaran Gagal";
        }
        
     return response()->json($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

   
    public function cetak($id)
    {
        // abort_unless(\Gate::allows('member_edit'), 403);

        $member = User::find($id);
        $details = DetailUsers::where('id', $id)->where('status_kta', 1)
                ->first();
        
        $ketua = Kepengurusan::where('id_daerah', $details->kabupaten_domisili)->where('jabatan', 3001)->first();
        $sekre = Kepengurusan::where('id_daerah', $details->kabupaten_domisili)->where('jabatan', 3002)->first();
        $kantor = Kantor::where('id_daerah', $id)->first();
     

         
        $kabupaten = Kabupaten::where('id_kab',$details->kabupaten_domisili)->first();
        $customPaper = array(10,0,290,210);
        $pdf = PDF::loadview('dpc.listuser.cetak',['details'=>$details,'kantor'=>$kantor, 'ketua'=>$ketua,'sekre'=>$sekre,'kabupaten'=>$kabupaten])->setPaper($customPaper,'portrait') ;
          return $pdf->stream();
  


        // return view('dpc.member.cetak', compact('member', 'detail', 'kabupaten','qrcode','ketua','sekre'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // abort_unless(\Gate::allows('member_edit'), 403);
    
        $member = DetailUsers::find($id);
   
        $detail = User::where('id', $member->userid)->first();
       

         $marital = DB::table('status_pernikahans')->where('aktifya', 1)->pluck('nama', 'id');
        $provinsi = Provinsi::where('status', 1)->pluck('name', 'id_prov');
        $pendidikan = DB::table('pendidikans')->where('status', 1)->pluck('nama','id');
        $jenis_kelamin = DB::table('jenis_kelamin')->pluck('name','id');
        $anggota = DB::table('status_anggota')->where('status', 1)->pluck('name','id');
        $kabupaten =  Kabupaten::where('status', 1)->where('id_prov', $member->provinsi_domisili)->pluck('name', 'id_kab');
        $kecamatan =  Kecamatan::where('status', 1)->where('id_kab', $member->kabupaten_domisili)->pluck('name', 'id_kec');
        $kelurahan =  Kelurahan::where('status', 1)->where('id_kec' ,$member->kecamatan_domisili)->pluck('name', 'id_kel');
      
        $job = Job::where('status', 1)->pluck('name', 'id');
        $agama = DB::table('agamas')->where('status', 1)->pluck('nama','id');
        
        return view('dpd.listuser.edit', compact('kecamatan','kelurahan','member','detail','agama','jenis_kelamin','marital', 'anggota','provinsi', 'kabupaten', 'job','pendidikan'));

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
        $avatarlama = '/www/wwwroot/siap.partaihanura.or.id/uploads/img/users/' . $member->avatar;
        $fotolama = '/www/wwwroot/siap.partaihanura.or.id//uploads/img/foto_ktp/' . $member->foto_ktp;
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
        
        
         $files = ['avatar','pakta_intergritas', 'foto_ktp'];
                
            foreach($files as $file){
                if($request->file($file)){
                    $uploadedFile = $request->file($file);
                    $filename = time() . '.' . $uploadedFile->getClientOriginalName();
                    
                    
                //   if ($file == 'avatar') {
                //         File::delete($avatarlama);
                //         Image::make($uploadedFile)->resize(250, 300)->save('uploads/img/users/' . $filename);
                //     }elseif($file == 'foto_ktp'){
                //         File::delete($fotolama);
                //         Image::make($uploadedFile)->resize(500, 400)->save('uploads/img/foto_ktp/' . $filename);
                //     }else{
                //         File::delete($paktalama);
                //         $uploadedFile->move('uploads/file/pakta_integritas/', $filename);
                        
                //     }
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
        
        if ($request->password == null) {
            $attr['password'] = $detail->password;
           
        } else {
            $attr['password'] =  Hash::make(request('password'));
        }
        
            $dpc =\Auth::user()->id;
          
          if($request->provinsi == $member->provinsi_domisili && $request->kabupaten == $member->kabupaten_domisili && $request->kecamatan == $member->kecamatan_domisili && $request->kelurahan == $member->kelurahan_domisili){
                   
                    $no_anggota = $member->no_member;
                }else{
                         
                $provinsi = DetailUsers::where('userid', $dpc)->value('provinsi_domisili');
                $kabupaten = Kabupaten::where('id_kab', $request->kabupaten)->value('id_kab');
                $kecamatan = Kecamatan::where('id_kec',$request->kecamatan)->value('id_kec');
                $kelurahan = Kelurahan::where('id_kel', $request->kelurahan)->value('id_kel');
              
                $kabup = substr($kabupaten,2);
                $kec = substr($kecamatan,4);
                $kel = substr($kelurahan,6);
                $noUrutAkhir =DetailUsers::where('kabupaten_domisili', $kabupaten)->count();
                $no_anggota =   $provinsi . '.' .$kabup . '.' . $kec . '.' . $kel . '.' . sprintf("%06s", abs($noUrutAkhir + 1)) ;
                }
                
                $detailUsers = DetailUsers::where('id',$id)->first();
      
                
                
                 $user = array(
                    'name'          => $request->name,
                    'email'         => $request->emailaddress,
                    'password'      => $attr['password'],
                    'updated_at'    => date('Y-m-d H:i:s'),
                    'is_active'     => 1,
                    'address'       =>$request->address,
                    'phone_number'       =>$request->no_hp,
                    'image'         => $files['avatar'],
                    'id_settings' => 1,
                    // 'username' => $username
                 
                );
           
               $users = array(
                    // 'no_member'         => $no_anggota,
                    'agama'             => $request->agama,
                    'nickname'          => $request->name,
                    'nik'               => $request->nik,
                    'rt_rw'               => $request->rt_rw,
                    'gender'            => $request->gender,
                    'status_kta'         => 1,
                    // 'pendidikan'         => $request->status_pendidikan,
                    'birth_place'       => $request->tempat_lahir,
                    'tgl_lahir'         => $dob,
                    'status_kawin'      => $request->marital,
                    'pekerjaan'         => $request->job,
                    'no_hp'             => $request->no_hp,
                    'alamat'            => $request->address,
                    // 'kode_pos'            => $request->kode_pos,
                    'provinsi_domisili'          => $request->provinsi,
                    'kabupaten_domisili'         => $request->kabupaten,
                    'kecamatan_domisili'         => $request->kecamatan,
                    'kelurahan_domisili'         => $request->kelurahan,
                    'alamat_domisili'   => $request->address,
                    'activation_code'   => Str::random(40).$request->input('email'),
                    'avatar'            => $files['avatar'],
                    'foto_ktp'          => $files['foto_ktp'],
                    // 'pakta_intergritas'  => $files['pakta_intergritas'],
                    'updated_at'        => date('Y-m-d H:i:s')
                );
                // dd($user);
                // dd($users);
                $use = User::where('id', $detailUsers->userid)->update($user);
                $detail = DetailUsers::where('id', $id)->update($users);
                 \DB::commit();
          return redirect()->route('dpd.listuser.index')->with('success','Data berhasil diupdate');
        
    }
     public function download($id)
    {
        $detail = DetailUsers::where('id',$id)->first();

        $file = '/www/wwwroot/siap.partaihanura.or.id/uploads/file/pakta_integritas/'. $detail->pakta_intergritas;
        
        return response()->file($file);
    }
    public function destroy($id)
    {
            $detail = DetailUsers::where('id',$id)->first();
             $user = array(
                    'username'      => '',
                    'password'      => '',
                 
                );
             $use = User::where('id', $detail->userid)->update($user);
            // $detail = DetailUsers::where('id',$id)->update([
            //  'deleted_at' => date('Y-m-d H:i:s'),
            //  'status_kta' => 4]);
    

        return redirect()->route('dpd.listuser.index')->with('success', 'Pembatalan Anggota Sukses DiBuat');
    }


   
}
