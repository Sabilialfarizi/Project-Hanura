<?php

namespace App\Http\Controllers\Dpd;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyMemberRequest;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\{User,DetailUsers,MaritalStatus,Job,Provinsi,Kepengurusan,Kabupaten,Kecamatan,Kelurahan,Kantor};
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;
use Intervention\Image\Facades\Image;
use App\Exports\{DPCExport,DPCExport_hp, ProvinsiExport};
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::user()->id;
        $detail = DetailUsers::where('userid', $id)->value('provinsi_domisili');
        $provinsi = Provinsi::where('id_prov', $detail)->first();
        $status_belum = DB::table('status_kpu')->where('id_status', 1)->select('warna_status','nama_status')->first();
        $status_terkirim = DB::table('status_kpu')->where('id_status', 2)->select('warna_status','nama_status')->first();
        $status_verifikasi = DB::table('status_kpu')->where('id_status', 3)->select('warna_status','nama_status')->first();
        $status_tidak_lolos = DB::table('status_kpu')->where('id_status', 4)->select('warna_status','nama_status')->first();
        $hasil_perbaikan = DB::table('status_kpu')->where('id_status', 5)->select('warna_status','nama_status')->first();
     

  
        return view('dpd.member.index', compact('detail','status_belum','status_terkirim','status_verifikasi','status_tidak_lolos','hasil_perbaikan','provinsi'));
    }
    public function getKelurahan(Request $request)
    {
        $data = Kelurahan::groupBy('id_kel')->where('id_kec', $request->val)
            ->get();

        return \Response::json($data);
    }

    public function getKecamatan(Request $request)
    {
        $data = Kecamatan::groupBy('id_kec')->where('id_kab', $request->val)
            ->get();
          
        return \Response::json($data);
    }

    public function getKabupaten(Request $request)
    {
        $id = Auth::user()->id;
        $detail = DetailUsers::where('userid', $id)->first();
        $data = Kabupaten::groupBy('id_kab')->where('id_prov', $detail->provinsi_domisili)
            ->get();

        return \Response::json($data);
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // abort_unless(\Gate::allows('member_create'), 403);
        $id = Auth::user()->id;
        $detail = DetailUsers::where('userid',$id)->first();
     

        $marital = DB::table('status_pernikahans')->where('aktifya', 1)->pluck('nama', 'id');
        $provinsi = Provinsi::where('status', 1)->pluck('name', 'id_prov');
        $pendidikan = DB::table('pendidikans')->where('status', 1)->pluck('nama','id');
        $jenis_kelamin = DB::table('jenis_kelamin')->pluck('name','id');
        $anggota = DB::table('status_anggota')->where('status', 1)->pluck('name','id');
        $kabupaten =  Kabupaten::where('status', 1)->where('id_prov', $detail->provinsi_domisili)->pluck('name', 'id_kab');
        // dd($kabupaten);
        // $kecamatan =  Kecamatan::where('status', 1)->pluck('name', 'id_kec');
        $job = Job::where('status', 1)->pluck('name', 'id');
        $agama = DB::table('agamas')->where('status', 1)->pluck('nama','id');
        
        return view('dpd.member.create', compact('detail','agama','jenis_kelamin','marital', 'anggota','provinsi', 'kabupaten', 'job','pendidikan'));
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
                    ->where('status_kta' ,1)
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
                
            $files = ['avatar','pakta_intergritas', 'foto_ktp'];
                
            foreach($files as $file){
                if($request->file($file)){
                    $uploadedFile = $request->file($file);
                    $filename = time() . '.' . $uploadedFile->getClientOriginalName();
                    
                    if ($file == 'avatar') {
                      
                        Image::make($uploadedFile)->resize(250, 300)->save('uploads/img/users/' . $filename);
                    }elseif($file == 'foto_ktp'){
                        Image::make($uploadedFile)->resize(500, 400)->save('uploads/img/foto_ktp/' . $filename);
                    }else{
                        
                    $uploadedFile->move('uploads/file/pakta_integritas/', $filename);
                        
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
                 $username =   $provinsi .$kabup .$noUrutAkhir  ;
                $users = User::create([
                    'name'          => $request->name,
                    'email'         => $request->emailaddress,
                    // 'password'      => $request->password,
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s'),
                    'is_active'     => 1,
                    'address'       =>$request->address,
                    'phone_number'       =>$request->no_hp,
                    'image'         => $files['avatar'],
                    'id_settings' => 1,
                    
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
                    'pendidikan'         => $request->status_pendidikan,
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
                    'pakta_intergritas'  => $files['pakta_intergritas'],
                  
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
    public function show($id)
    {
        // abort_unless(\Gate::allows('member_edit'), 403);

        $member = User::leftJoin('detail_users','users.id','=','detail_users.userid')->where('detail_users.id',$id)->first();
        // dd($member);
        $detail = DetailUsers::join('model_has_roles','detail_users.userid','=','model_has_roles.model_id')
        ->join('roles','model_has_roles.role_id','=','roles.id')
        ->where('detail_users.id',$id)
        ->first();

        return view('dpd.member.show', compact('member', 'detail'));
    }
   public function cetak($id)
    {
        // abort_unless(\Gate::allows('member_edit'), 403);

   
        $details = DetailUsers::where('id', $id)->where('status_kta', 1)
                ->first();
                 $member = User::where('id', $details->userid)->first();
        
        $ketua = Kepengurusan::where('id_daerah', $details->kabupaten_domisili)->where('jabatan', 3001)->first();
        $sekre = Kepengurusan::where('id_daerah', $details->kabupaten_domisili)->where('jabatan', 3002)->first();
        $kantor = Kantor::where('id_daerah', $id)->first();
     

         
        $kabupaten = Kabupaten::where('id_kab',$details->kabupaten_domisili)->first();
        $customPaper = array(10,0,290,210);
        $pdf = PDF::loadview('dpc.member.cetak',['details'=>$details,'member'=>$member,'kantor'=>$kantor, 'ketua'=>$ketua,'sekre'=>$sekre,'kabupaten'=>$kabupaten])->setPaper($customPaper,'portrait') ;
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
        
        return view('dpd.member.edit', compact('kecamatan','kelurahan','member','detail','agama','jenis_kelamin','marital', 'anggota','provinsi', 'kabupaten', 'job','pendidikan'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function editKorlap($id)
    // {
    //     // abort_unless(\Gate::allows('member_edit'), 403);

    //     $member = User::find($id);
    //     $detail = DetailUsers::where('userid', $id)
    //             ->first();
        
    //     return view('dpc.member.verified.update', compact('member', 'detail'));
    // }

    // public function updateKorlap(Request $request, $id)
    // {
    //     $find = DetailUsers::where('userid', $id)->first();

    //     $detail = DetailUsers::find($find->id);
    //     $detail->status_korlap = 1;
    //     $detail->updated_at    = date('Y-m-d H:i:s');
    //     $detail->updated_by    = \Auth::user()->id;
    //     $detail->update();

    //     return \redirect()->route('dpc.member-verified')->with('success',\trans('notif.notification.update_data.success'));
    // }

    public function update(Request $request, $id)
    {
        $request->validate([
      
            'avatar'    => 'max:2048',
            'foto_ktp'  => 'max:2048',
            'pakta_intergritas'  => 'max:2048',
    
        ]);
        $member = DetailUsers::where('id',$id)->first();
        $detail = User::where('id',$member->userid)->first();
        $avatarlama = '/www/wwwroot/hanura.net/uploads/img/users/' . $member->avatar;
        $fotolama = '/www/wwwroot/hanura.net/uploads/img/foto_ktp/' . $member->foto_ktp;
        $paktalama = '/www/wwwroot/hanura.net/uploads/file/pakta_integritas/' . $member->pakta_intergritas;
     
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
                    
                   if ($file == 'avatar') {
                        File::delete($avatarlama);
                        Image::make($uploadedFile)->resize(250, 300)->save('uploads/img/users/' . $filename);
                    }elseif($file == 'foto_ktp'){
                        File::delete($fotolama);
                        Image::make($uploadedFile)->resize(500, 400)->save('uploads/img/foto_ktp/' . $filename);
                    }else{
                        File::delete($paktalama);
                        $uploadedFile->move('uploads/file/pakta_integritas/', $filename);
                        
                    }
                    
                        $files[$file] = $filename;
                    }else{
                    $oldFile = $file . '_lama';
                 
                    if($request->input($oldFile) !== 'noname' && $request->input($oldFile) !== ''){
                        $files[$file] = $request->input($oldFile);
                    }else{
                        $files[$file] = '';
                    }
                }
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
                    // 'password'      => $request->password,
                    'updated_at'    => date('Y-m-d H:i:s'),
                    'is_active'     => 1,
                    'address'       =>$request->address,
                    'phone_number'       =>$request->no_hp,
                    'image'         => $files['avatar'],
                    'id_settings' => 1,
                 
                );
           
               $users = array(
                    // 'no_member'         => $no_anggota,
                    'agama'             => $request->agama,
                    'nickname'          => $request->name,
                    'nik'               => $request->nik,
                    'rt_rw'               => $request->rt_rw,
                    'gender'            => $request->gender,
                    'status_kta'         => 1,
                    'pendidikan'         => $request->status_pendidikan,
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
                    'pakta_intergritas'  => $files['pakta_intergritas'],
                    'updated_at'        => date('Y-m-d H:i:s')
                );
                // dd($user);
                // dd($users);
                $use = User::where('id', $detailUsers->userid)->update($user);
                $detail = DetailUsers::where('id', $id)->update($users);
                 \DB::commit();
          return redirect()->route('dpd.member.index')->with('success','Data berhasil diupdate');

        
    }
    public function export($id) 
    {
        $exporter = app()->makeWith(DPCExport::class, compact('id'));   
        return $exporter->download('Pemilu.xlsx');
    }
    public function provinsi_export($id) 
    {
        $provinsi = Provinsi::where('id_prov', $id)->first();
        $exporter = app()->makeWith(ProvinsiExport::class, compact('id'));   
        return $exporter->download('Laporan Anggota DPD '.$provinsi->name.' .xlsx');
    }
     public function showMember($id)
    {
        // abort_unless(\Gate::allows('member_edit'), 403);

         $detail = DetailUsers::join('model_has_roles','detail_users.userid','=','model_has_roles.model_id')->where('detail_users.kabupaten_domisili', $id)
         ->where('detail_users.status_kta',1)
         ->where('model_has_roles.role_id',4)
         ->where('detail_users.status_kpu',2)
     
         ->groupBy('detail_users.id')
                ->get();
             
        $ketua = Kepengurusan::where('id_daerah', $id)->where('jabatan', 3001)->first();
     
        $sekre = Kepengurusan::where('id_daerah', $id)->where('jabatan', 3002)->first();
        
        $kantor = Kantor::where('id_daerah', $id)->first();

    
        $kabupaten = Kabupaten::where('id_kab',$id)->first();
         $pdf = PDF::loadview('dpp.kabupaten.show',['kantor'=>$kantor,'detail'=>$detail, 'ketua'=>$ketua,'sekre'=>$sekre,'kabupaten'=>$kabupaten])->setPaper('A4','portrait') ;

        return $pdf->stream();
  
   
        // return view('dpp.kabupaten.show', compact('kabupaten','detail','ketua','sekre'));
    }
     public function showkta($id)
    {
        // abort_unless(\Gate::allows('member_edit'), 403);
        define("DOMPDF_ENABLE_HTML5PARSER", true);
        define("DOMPDF_ENABLE_FONTSUBSETTING", true);
        define("DOMPDF_UNICODE_ENABLED", true);
        define("DOMPDF_DPI", 120);
        define("DOMPDF_ENABLE_REMOTE", true);


         $detail = DetailUsers::join('model_has_roles','detail_users.userid','=','model_has_roles.model_id')->where('detail_users.kabupaten_domisili', $id)->where('detail_users.status_kta',1)
         ->where('model_has_roles.role_id',4)
         ->where('detail_users.status_kpu',2)
         ->groupBy('detail_users.id')
                ->get();
        
        $kantor = Kantor::where('id_daerah', $id)->first();
             
        $ketua = Kepengurusan::where('id_daerah', $id)->where('jabatan', 3001)->first();
     
        $sekre = Kepengurusan::where('id_daerah', $id)->where('jabatan', 3002)->first();
        
        // $qrcode =  QrCode::size(60)->generate($details->no_member);
         
        $kabupaten = Kabupaten::where('id_kab',$id)->first();
        $customPaper = array(0,0,609.4488,935.433);
        $pdf = PDF::loadview('dpp.kabupaten.showkta',['detail'=>$detail, 'ketua'=>$ketua,'sekre'=>$sekre,'kabupaten'=>$kabupaten,'kantor'=>$kantor])->setPaper($customPaper,'portrait') ;


        return $pdf->stream();
   
        // return view('dpp.kabupaten.showkta', compact('kabupaten','detail','ketua','sekre'));
    }
     public function download($id)
    {
        $detail = DetailUsers::where('id',$id)->first();

        $file = '/www/wwwroot/hanura.net/uploads/file/pakta_integritas/'. $detail->pakta_intergritas;
        
        return response()->file($file);
    }
    
    public function export_hp($id) 
    {
        $exporter = app()->makeWith(DPCExport_hp::class, compact('id'));   
        return $exporter->download('Pemilu_hp.xlsx');
    }
     public function show_hp($id)
    {
        // abort_unless(\Gate::allows('member_edit'), 403);

         $detail = DetailUsers::join('model_has_roles','detail_users.userid','=','model_has_roles.model_id')
         ->where('detail_users.kabupaten_domisili', $id)
         ->where('detail_users.status_kta',1)
          ->where('detail_users.status_kpu',5)
         ->where('model_has_roles.role_id',11)
         ->groupBy('detail_users.id')
                ->get();
        
        $kantor = Kantor::where('id_daerah', $id)->first();
        $ketua = Kepengurusan::where('id_daerah', $id)->where('jabatan', 3001)->first();
     
        $sekre = Kepengurusan::where('id_daerah', $id)->where('jabatan', 3002)->first();
     

         
        $kabupaten = Kabupaten::where('id_kab',$id)->first();
         $pdf = PDF::loadview('dpp.kabupaten.show_hp',['detail'=>$detail, 'ketua'=>$ketua,'sekre'=>$sekre,'kabupaten'=>$kabupaten,'kantor'=>$kantor])->setPaper('A4','portrait') ;

        return $pdf->stream();
  
   
        // return view('dpp.kabupaten.show', compact('kabupaten','detail','ketua','sekre'));
    }
     public function showkta_hp($id)
    {
   

         $detail = DetailUsers::join('model_has_roles','detail_users.userid','=','model_has_roles.model_id')
         ->where('detail_users.kabupaten_domisili', $id)
         ->where('detail_users.status_kta',1)
          ->where('detail_users.status_kpu',5)
         ->where('model_has_roles.role_id',11)
         ->groupBy('detail_users.id')
                ->get();
        
                
          $kantor = Kantor::where('id_daerah', $id)->first();
        $ketua = Kepengurusan::where('id_daerah', $id)->where('jabatan', 3001)->first();
     
        $sekre = Kepengurusan::where('id_daerah', $id)->where('jabatan', 3002)->first();
        
        // $qrcode =  QrCode::size(60)->generate($details->no_member);
         
        $kabupaten = Kabupaten::where('id_kab',$id)->first();
        $customPaper = array(0,0,210,330);
        $customPaper = array(0,0,609.4488,935.433);
        $pdf = PDF::loadview('dpp.kabupaten.showkta',['detail'=>$detail, 'ketua'=>$ketua,'sekre'=>$sekre,'kabupaten'=>$kabupaten,'kantor'=>$kantor])->setPaper($customPaper,'portrait') ;


        return $pdf->stream();
   
        // return view('dpp.kabupaten.showkta', compact('kabupaten','detail','ketua','sekre'));
    }

     public function lampiran_parpol($id)
    {

        $get_provinsi = Provinsi::where('id_prov' , $id)->first();
       

        $get_user = DB::table('kabupatens')->where('id_prov', $id)->groupBy('id_kab')->get();
     

   
        
        $ketua = DB::table('kepengurusan')
          ->leftJoin('jabatans','kepengurusan.jabatan','=','jabatans.kode')
          ->select('kepengurusan.nama as name','kepengurusan.kta','jabatans.nama','jabatans.urutan','kepengurusan.nik','kepengurusan.foto','kepengurusan.ttd')
          ->where('kepengurusan.jabatan',1001)
          ->where('kepengurusan.deleted_at',null)
          ->orderBy('jabatans.urutan','asc')
          ->groupBy('kepengurusan.id_kepengurusan')
          ->first();
       
       
        $sekretaris = DB::table('kepengurusan')
          ->leftJoin('jabatans','kepengurusan.jabatan','=','jabatans.kode')
          ->select('kepengurusan.nama as name','kepengurusan.kta','jabatans.nama','jabatans.urutan','kepengurusan.nik','kepengurusan.foto','kepengurusan.ttd')
          ->where('kepengurusan.jabatan',1002)
          ->where('kepengurusan.deleted_at',null)
          ->orderBy('jabatans.urutan','asc')
          ->groupBy('kepengurusan.id_kepengurusan')
          ->first();
       
       
          $pdf = PDF::loadview('dpp.provinsi.lampiran_parpol',[ 'get_provinsi'=>$get_provinsi,'get_user'=>$get_user,'sekretaris'=>$sekretaris,'ketua'=>$ketua]);
         return $pdf->stream();



    }
     public function lampiran_hp_parpol($id)
    {

        $get_provinsi = Provinsi::where('id_prov' , $id)->first();
       

        $get_user = DB::table('kabupatens')->where('id_prov', $id)->groupBy('id_kab')->get();
     

   
        
        $ketua = DB::table('kepengurusan')
          ->leftJoin('jabatans','kepengurusan.jabatan','=','jabatans.kode')
          ->select('kepengurusan.nama as name','kepengurusan.kta','jabatans.nama','jabatans.urutan','kepengurusan.nik','kepengurusan.foto','kepengurusan.ttd')
          ->where('kepengurusan.jabatan',1001)
          ->where('kepengurusan.deleted_at',null)
          ->orderBy('jabatans.urutan','asc')
          ->groupBy('kepengurusan.id_kepengurusan')
          ->first();
       
       
        $sekretaris = DB::table('kepengurusan')
          ->leftJoin('jabatans','kepengurusan.jabatan','=','jabatans.kode')
          ->select('kepengurusan.nama as name','kepengurusan.kta','jabatans.nama','jabatans.urutan','kepengurusan.nik','kepengurusan.foto','kepengurusan.ttd')
          ->where('kepengurusan.jabatan',1002)
          ->where('kepengurusan.deleted_at',null)
          ->orderBy('jabatans.urutan','asc')
          ->groupBy('kepengurusan.id_kepengurusan')
          ->first();
       
       
          $pdf = PDF::loadview('dpp.provinsi.lampiran_hp_parpol',[ 'get_provinsi'=>$get_provinsi,'get_user'=>$get_user,'sekretaris'=>$sekretaris,'ketua'=>$ketua]);
         return $pdf->stream();



    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
            $detail = DetailUsers::where('id',$id)->update([
             'deleted_at' => date('Y-m-d H:i:s'),
             'status_kta' => 4]);
          
          

        return redirect()->route('dpd.member.index')->with('success', 'Pembatalan Anggota Sukses DiBuat');
    }
}
