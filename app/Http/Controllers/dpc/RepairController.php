<?php

namespace App\Http\Controllers\Dpc;

use Illuminate\Http\Request;
use App\{Pembatalan, DetailUsers, User, Provinsi, Kabupaten, Kecamatan, Kelurahan, Job};
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class RepairController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // abort_unless(\Gate::allows('category_access'), 403);
        

        $pembatalan = DetailUsers::orderBy('id', 'asc')->where('status_kta',2)->get();
  
        return view('dpc.repair.index', compact('pembatalan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
  

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // abort_unless(\Gate::allows('member_edit'), 403);
  $detail = DetailUsers::join('model_has_roles','detail_users.userid','=','model_has_roles.model_id')
        ->join('roles','model_has_roles.role_id','=','roles.id')
        ->where('detail_users.no_member',$id)
        ->first();
         
        $member = User::leftJoin('detail_users','users.id','=','detail_users.userid')->where('detail_users.no_member',$id)->first();
        // dd($member);



        return view('dpc.repair.show', compact('member', 'detail'));
    }
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
        $kabupaten =  Kabupaten::where('status', 1)->pluck('name', 'id_kab');
        $kecamatan =  Kecamatan::where('status', 1)->where('id_kab', $member->kabupaten_domisili)->pluck('name', 'id_kec');
        $kelurahan =  Kelurahan::where('status', 1)->where('id_kec' ,$member->kecamatan_domisili)->pluck('name', 'id_kel');
      
        $job = Job::where('status', 1)->pluck('name', 'id');
        $agama = DB::table('agamas')->where('status', 1)->pluck('nama','id');
        
        return view('dpc.repair.edit', compact('kecamatan','kelurahan','member','detail','agama','jenis_kelamin','marital', 'anggota','provinsi', 'kabupaten', 'job','pendidikan'));

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
     
         \DB::beginTransaction();
        
           
            $message['is_error'] = true;
            $message['error_msg'] = "";
            $dob = date("Y-m-d", strtotime($request->tgl_lahir));
            $count = DetailUsers::count();
            $no_member = str_pad($count+1,7,"0",STR_PAD_LEFT);
            
            $check = User::where('email', $request->emailaddress)
                    ->select('id')
                    ->first();
        
        $files = ['avatar','foto_ktp'];

        foreach($files as $file){
            if($request->file($file)){
                $uploadedFile = $request->file($file);
                $filename = time() . '.' . $uploadedFile->getClientOriginalName();
                
                // if ($file == 'avatar') {
                //     $uploadedFile->move('uploads/img/users/', $filename);
                // }elseif($file == 'pakta_intergritas'){
                //     $uploadedFile->move('uploads/file/pakta_integritas/', $filename);
                // }else{
                //     $uploadedFile->move('uploads/img/foto_ktp/', $filename);
                // }
                if ($file == 'avatar') {
                    $uploadedFile->move('uploads/img/users/', $filename);
                }else{
                    $uploadedFile->move('uploads/img/foto_ktp/', $filename);
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
     
      
                $dpc =\Auth::user()->id;
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
                
                $detailUsers = DetailUsers::where('id',$id)->first();
      
                
                
                 $user = array(
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
                 
                );
           
               $users = array(
                    // 'no_member'         => $no_anggota,
                    'agama'             => $request->agama,
                    'nickname'          => $request->name,
                    'nik'               => $request->nik,
                    'rt_rw'               => $request->rt_rw,
                    'gender'            => $request->gender,
                    'status_kta'         => 0,
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
                $pembatalan = Pembatalan::where('id_anggota', $id)->delete();
   
                $use = User::where('id', $detailUsers->userid)->update($user);
                $detail = DetailUsers::where('id', $id)->update($users);
                 \DB::commit();
          return redirect()->route('dpc.repair.index')->with('success','Data berhasil diupdate');
        
    }
    
  
    public function destroy($id)
    { 
        $detail = DetailUsers::where('id', $id)->get();
    
          foreach ($detail as $det) {
             $update = DetailUsers::where('id', $det->id)->update(array(
            'status_kta' => 5
            ));
    
        }
       
        
        return redirect()->route('dpc.repair.index')->with('success', 'Anggota Sudah di Delete');
    }
     
}
