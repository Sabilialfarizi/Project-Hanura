<?php

namespace App\Http\Controllers\Dpp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{DetailUsers, Kepengurusan, Kantor, Provinsi, Kabupaten,User, Kecamatan, Kelurahan, Jabatan, Bank};
use App\ArticleCategory as Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // abort_unless(\Gate::allows('information_access'), 403);

        // $settings = DB::table('settings')->get();
        // dd($program);
        // return view('dpp.settings.index', compact('settings'));

        // Kantor & Kepengurusan
        $kepengurusan = Kepengurusan::where('id_daerah', 0)->get();
        $kantor = Kantor::where('id_daerah', 0)->first();

        return view('dpp.settings.index', compact('kepengurusan', 'kantor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // abort_unless(\Gate::allows('information_create'), 403);
        $anggota = DetailUsers::where('status_kta', 1)->pluck('nickname', 'id');
        
        return view('dpp.settings.create', compact('anggota'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $anggota = DetailUsers::create([
            'id_ketum'   => $request->id_ketum,
            'id_sekjen'          => $request->id_sekjen,
            'id_bendum'       => $request->id_bendum,
            'telp'      => $request->telp,
            'alamat'    => $request->alamat,
            'about_as'    => $request->about_as,
        ]);

        return redirect()->route('dpp.settings.index')->with('success', 'Settings Sudah di Create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $settings = DB::table('settings')->find($id);

        $anggota = DetailUsers::where('status_kta', 1)->pluck('nickname', 'id');
        
        return view('dpp.settings.edit', compact('anggota','settings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $settings = DB::table('settings')->where('id',$id)->update([
        'id_ketum' => $request->id_ketum,
        'id_sekjen' => $request->id_sekjen,
        'id_bendum' => $request->id_bendum,
        'telp' => $request->telp,
        'alamat' => $request->alamat,
        'about_as' => $request->about_as
            
            ]);


        return redirect()->route('dpp.settings.index')->with('success', 'Settings Sudah di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       DB::table('settings')->where('id',$id)->delete();
       return redirect()->route('dpp.settings.index')->with('success', 'Settings Sudah di Delete');
    }
    
        public function kantor()
    {
        $kantor = Kantor::where('id_daerah', 0)->first();
        $provinsi = Provinsi::where('status', 1)->pluck('name', 'id_prov');
        $kabupaten =  Kabupaten::where('status', 1)->pluck('name', 'id_kab');
        $kecamatan =  Kecamatan::where('status', 1)->pluck('name', 'id_kec');
        $kelurahan =  Kelurahan::where('status', 1)->pluck('name', 'id_kel');
        $nama_bank = Bank::where('status',1)->pluck('nama_bank','id_bank');

        return view('dpp.settings.kantor.index', compact('kantor', 'provinsi', 'kabupaten', 'kecamatan', 'kelurahan','nama_bank'));
    }

    public function kantor_create()
    {
        $provinsi = Provinsi::where('status', 1)->pluck('name', 'id_prov');
        $kabupaten =  Kabupaten::where('status', 1)->pluck('name', 'id_kab');
        
        return view('dpp.settings.kantor.create', compact('provinsi', 'kabupaten'));
    }

    public function kantor_store(Request $request)
    {
     
        $request->validate([
            'alamat' => 'required',
            'provinsi' => 'required',
            'kode_pos' => 'required',
            'kab_kota' => 'required',
            'kec' => 'required',
            'kel' => 'required',
            'rt_rw' => 'required',
            'no_telp' => 'required',
            'wa_kantor' => 'required',
            'koordinat' => 'required',
            'no_sk'=> 'max:10048',
            'surat_keterangan_kantor'=> 'max:10048',
            'rekening_bank'=> 'max:10048',
            'cap_kantor'=> 'max:10048',
            'domisili'=> 'max:10048',
            'akta_pendirian'=> 'max:10048',
            
            // 'fax' => 'required',
            'email' => 'required|email',
            'is_active' => 'required',
        ],
        [
            'koordinat.required' => 'Koordinat harus diisi!',
            'kode_pos.required' => 'Kode Pos harus diisi!',
            'alamat.required' => 'Alamat harus diisi!',
            'provinsi.required' => 'Provinsi harus diisi!',
            'kab_kota.required' => 'Kabupaten harus diisi!',
            'kec.required' => 'Kecamatan harus diisi!',
            'kel.required' => 'Kelurahan harus diisi!',
            'rt_rw.required' => 'RT/RW harus diisi!',
            'no_telp.required' => 'No. Telepon harus diisi!',
            'wa_kantor.required' => 'WhatsApp Kantor harus diisi!',
            // 'fax.required' => 'Fax harus diisi!',
            'email.required' => 'Email harus diisi!',
            'email.email' => 'Email tidak valid!',
            'is_active.required' => 'Status harus diisi!',
        ]);
         $files = ['cap_kantor','domisili','no_sk','rekening_bank','surat_keterangan_kantor','akta_pendirian'];
       foreach($files as $file) {
            if($request->file($file)) {
                $uploadedFile=$request->file($file);
                $filename=time() . '.'. $uploadedFile->getClientOriginalName();

                if ($file=='cap_kantor') {

                    Image::make($uploadedFile)->resize(250, 300)->save('uploads/img/cap_kantor/'. $filename);
                }

                elseif($file=='domisili') {
                    $uploadedFile->move('uploads/file/domisili/', $filename);
                }

                elseif($file == 'surat_keterangan_kantor'){

                    $uploadedFile->move('uploads/file/surat_keterangan_kantor/', $filename);

                }
                elseif($file == 'no_sk'){

                    $uploadedFile->move('uploads/file/no_sk/', $filename);

                }elseif($file == 'rekening_bank'){
                      $uploadedFile->move('uploads/file/rekening_bank/', $filename);
                    
                }else{
                      $uploadedFile->move('uploads/file/akta_pendirian/', $filename);
                }

                $files[$file]=$filename;
            }

            else {
                $files[$file]='';
            }
        }
        
        Kantor::create([
            'alamat' => $request->alamat,
            'kode_pos' => $request->kode_pos,
            'koordinat' => $request->koordinat,
            'id_tipe_daerah' => 1,
            'id_daerah' => 0,
            'provinsi' => $request->provinsi,
            'kab_kota' => $request->kab_kota,
            'kec' => $request->kec,
            'kel' => $request->kel,
            'rt_rw' => $request->rt_rw,
            'no_telp' => $request->no_telp,
            'fax' => $request->fax,
            'wa_kantor' => $request->wa_kantor,
            'cap_kantor'=> $files['cap_kantor'],
            'akta_pendirian' =>$files['akta_pendirian'],
            'domisili'=> $files['domisili'],
            'no_sk'=> $files['no_sk'],
            'surat_keterangan_kantor'=> $files['surat_keterangan_kantor'],
            'rekening_bank'=> $files['rekening_bank'],
            'email' => $request->email,
            'is_active' => $request->is_active,
        ]);
        
        return redirect()->route('dpp.settings.kantor.index')->with('success', 'Data kantor berhasil ditambahkan!');
    }

    public function kantor_edit()
    {
        $kantor = Kantor::where('id_daerah', 0)->first();
        $provinsi = Provinsi::where('status', 1)->pluck('name', 'id_prov');
        $kabupaten =  Kabupaten::where('status', 1)->pluck('name', 'id_kab');
        $kecamatan =  Kecamatan::where('status', 1)->pluck('name', 'id_kec');
        $kelurahan =  Kelurahan::where('status', 1)->pluck('name', 'id_kel');

        $daerah = Kabupaten::where('id_kab', $kantor->id_daerah)->first();

        return view('dpp.settings.kantor.edit', compact('kantor', 'provinsi', 'daerah', 'kabupaten', 'kecamatan', 'kelurahan'));
    }

    public function kantor_update(Request $request)
    {
        
        $request->validate([
            'alamat' => 'required',
            'kode_pos' => 'required',
            'koordinat' => 'required',
            'provinsi' => 'required',
            'kab_kota' => 'required',
            'kec' => 'required',
            'kel' => 'required',
            'rt_rw' => 'required',
            'no_telp' => 'required',
            'fax' => 'required',
             'no_sk'=> 'max:10048',
            'surat_keterangan_kantor'=> 'max:10048',
            'rekening_bank'=> 'max:10048',
            'cap_kantor'=> 'max:10048',
            'domisili'=> 'max:10048',
            'akta_pendirian'=> 'max:10048',
            'wa_kantor' => 'required',
            'email' => 'required|email',
            'is_active' => 'required',
        ],
        [
            'alamat.required' => 'Alamat harus diisi!',
            'kode_pos.required' => 'Kode Pos harus diisi!',
            'provinsi.required' => 'Provinsi harus diisi!',
            'koordinat.required' => 'Koordinat harus diisi!',
            'kab_kota.required' => 'Kabupaten harus diisi!',
            'kec.required' => 'Kecamatan harus diisi!',
            'kel.required' => 'Kelurahan harus diisi!',
            'rt_rw.required' => 'RT/RW harus diisi!',
            'no_telp.required' => 'No. Telepon harus diisi!',
            'wa_kantor.required' => 'WhatsApp Kantor harus diisi!',
            'fax.required' => 'Fax harus diisi!',
            'email.required' => 'Email harus diisi!',
            'email.email' => 'Email tidak valid!',
            'is_active.required' => 'Status harus diisi!',
        ]);
     
        $files=['cap_kantor','no_sk','domisili','rekening_bank','surat_keterangan_kantor','akta_pendirian'];
      
        $cap = Kantor::where('id_daerah', 0)->first();
      
      
        $caplama='/www/wwwroot/hanura.net/uploads/img/cap_kantor/'. $cap->cap_kantor;
        $domisili='/www/wwwroot/hanura.net/uploads/file/domisili/'. $cap->domisili;
        $no_sk='/www/wwwroot/hanura.net/uploads/file/no_sk/'. $cap->no_sk;
        $akta='/www/wwwroot/hanura.net/uploads/file/akta_pendirian/'. $cap->akta_pendirian;
        $surat ='/www/wwwroot/hanura.net/uploads/file/surat_keterangan_kantor/'. $cap->surat_keterangan_kantor;
        $rekening ='/www/wwwroot/hanura.net/uploads/file/rekening_bank/'. $cap->rekening_bank;

        foreach($files as $file) {
            if($request->file($file)) {
                $uploadedFile=$request->file($file);
                $filename=time() . '.'. $uploadedFile->getClientOriginalName();

                if ($file=='cap_kantor') {
                     File::delete($caplama);
                     Image::make($uploadedFile)->resize(250, 300)->save('uploads/img/cap_kantor/'. $filename);
                }

                elseif($file=='domisili') {
                    File::delete($domisili);
                    $uploadedFile->move('uploads/file/domisili/', $filename);
                }

                elseif($file == 'no_sk'){
                    File::delete($no_sk);
                    $uploadedFile->move('uploads/file/no_sk/', $filename);

                }
                elseif($file == 'rekening_bank'){
                    File::delete($rekening);
                    $uploadedFile->move('uploads/file/rekening_bank/', $filename);

                }
                elseif($file == 'surat_keterangan_kantor'){
                    File::delete($surat);
                    $uploadedFile->move('uploads/file/surat_keterangan_kantor/', $filename);

                }else{
                   File::delete($akta);
                    $uploadedFile->move('uploads/file/akta_pendirian/', $filename);
                }

                $files[$file]=$filename;
          
            }

            else {
                $oldFile=$file . '_lama';
              

                if($request->input($oldFile) !=='noname'&& $request->input($oldFile) !=='') {
                    $files[$file]=$request->input($oldFile);
                }

                else {
                    $files[$file]='';
                }
            }
        }


        Kantor::where('id_daerah',  0)->update([
            'alamat' => $request->alamat,
            'kode_pos' => $request->kode_pos,
             'koordinat' => $request->koordinat,
            'provinsi' => $request->provinsi,
            'kab_kota' => $request->kab_kota,
            'kec' => $request->kec,
            'kel' => $request->kel,
            'rt_rw' => $request->rt_rw,
            'no_telp' => $request->no_telp,
            'fax' => $request->fax,
             'wa_kantor' => $request->wa_kantor,
            'email' => $request->email,
            'cap_kantor'=> $files['cap_kantor'],
            'akta_pendirian' =>$files['akta_pendirian'],
            'domisili'=> $files['domisili'],
            'no_sk'=> $files['no_sk'],
            'surat_keterangan_kantor'=> $files['surat_keterangan_kantor'],
            'rekening_bank'=> $files['rekening_bank'],
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('dpp.settings.kantor.index')->with('success', 'Data kantor berhasil diubah!');
    }
    
     public function domisili()
    {
        $detail = Kantor::where('id_daerah',0)->first();
    

        $file = '/www/wwwroot/hanura.net/uploads/file/domisili/'. $detail->domisili;
        
        return response()->file($file);
    }
    
    
          public function no_sk()
    {
        $detail = Kantor::where('id_daerah',0)->first();
      

        $file = '/www/wwwroot/hanura.net/uploads/file/no_sk/'. $detail->no_sk;
        
        return response()->file($file);
    }
    public function surat_keterangan()
    {
        $detail = Kantor::where('id_daerah',0)->first();
    
    

        $file = '/www/wwwroot/hanura.net/uploads/file/surat_keterangan_kantor/'. $detail->surat_keterangan_kantor;
        
        return response()->file($file);
    }
    
    
          public function rekening_bank()
    {
        $detail = Kantor::where('id_daerah',0)->first();
      

        $file = '/www/wwwroot/hanura.net/uploads/file/rekening_bank/'. $detail->rekening_bank;
        
        return response()->file($file);
    }
          public function akta_pendirian()
    {
        $detail = Kantor::where('id_daerah',0)->first();
      

        $file = '/www/wwwroot/hanura.net/uploads/file/akta_pendirian/'. $detail->akta_pendirian;
        
        return response()->file($file);
    }


    public function kepengurusan_index()
    {  
        $kepengurusan = Kepengurusan::where('id_daerah', 0)->get();

        return view('dpp.settings.kepengurusan.index', compact('kepengurusan'));
    }

    public function kepengurusan_create()
    {
        $jabatan = Jabatan::whereBetween('kode', [1000, 1999])->get();

        return view('dpp.settings.kepengurusan.create', compact('jabatan'));
    }
      public function loaddata(Request $request)
    {
       
        $data = [];
        // $id = Auth::user()->id;
        // $detail= DetailUsers::where('userid',$id)->select('provinsi_domisili')->first();
        $pembatalan =  User::join('model_has_roles','users.id','=','model_has_roles.model_id')
            ->join('detail_users','users.id','=','detail_users.userid')
            ->where('detail_users.status_kta', 1)
            // ->where('users.super_admin', 0)
            // ->whereIn('detail_users.provinsi_domisili', $detail)
            ->where('detail_users.nik', 'like', '%' . $request->q . '%')
          
            ->groupBy('detail_users.nik')
            ->get();
        foreach ($pembatalan as $row) {
            $data[] = ['id' => $row->id,  'text' => $row->nik];
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
            // dd($roles);
            

            foreach ($roles as $value) {
                $data[] = [
                    'name' => $value->nickname,
                    'no_member' => $value->no_member,
                    'nik' => $value->nik,
                    'alamat' => $value->alamat,
                    // 'avatar' => $value->avatar,
                    'roles' => $value->key,
                    'provinsi' => $value->provinsi,
                    'kabupaten' => $value->kabupaten,
                    'kecamatan' => $value->kecamatan,
                    'kelurahan' => $value->kelurahan,
                ];
            }
          
        return response()->json($data);
    }

    public function kepengurusan_store(Request $request){
        $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'kta' => 'required',
            'nik' => 'required',
            'no_sk' => 'required',
            'alamat_kantor' => 'required',
        ],
        [
              'jabatan.required' => 'Jabatan tidak boleh kosong',
            'nama.required' => 'Nama tidak boleh kosong',
            'kta.required' => 'KTA tidak boleh kosong',
            'nik.required' => 'NIK tidak boleh kosong',
            'no_sk.required' => 'No SK tidak boleh kosong',
            'alamat_kantor.required' => 'Alamat Kantor tidak boleh kosong',
        ]);

        $files = ['foto', 'ttd'];

        foreach($files as $file){
            if($request->file($file)){
                $uploadedFile = $request->file($file);
                $filename = time() . '.' . $uploadedFile->getClientOriginalName();
                
                if ($file == 'foto') {
                  
                      Image::make($uploadedFile)->resize(250, 300)->save('uploads/img/foto_kepengurusan/' . $filename);
                }else{
                      Image::make($uploadedFile)->resize(250, 300)->save('uploads/img/ttd_kta/' . $filename);
                }
                
                $files[$file] = $filename;
            }else{
                $files[$file] = 'noimage.jpg';
            }
        }

        $kepengurusan = array(
            'id_daerah' => 0,
            'jabatan' => $request->jabatan,  
            'nama' => $request->nama,
            'other_jabatan' => $request->other_jabatan,
            'kta' => $request->kta,
            'nik' => $request->nik,
            'no_sk' => $request->no_sk,
            'alamat_kantor' => $request->alamat_kantor,
            'foto' => $files['foto'],
            'ttd' => $files['ttd'],
            'is_active' => 1,
            
            );

       $peng = Kepengurusan::insert($kepengurusan);

        return redirect()->route('dpp.settings.kepengurusan.index')->with('success','Data berhasil diupdate');
    }

    public function kepengurusan_edit($id)
    {
        $kepengurusan = Kepengurusan::find($id);
        $jabatan = Jabatan::whereBetween('kode', [1000, 1999])->get();

        return view('dpp.settings.kepengurusan.edit', compact('kepengurusan', 'jabatan'));
    }

    public function kepengurusan_update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'kta' => 'required',
            'nik' => 'required',
            'no_sk' => 'required',
            'alamat_kantor' => 'required',
        ],
        [
            'nama.required' => 'Nama tidak boleh kosong',
            'kta.required' => 'KTA tidak boleh kosong',
            'nik.required' => 'NIK tidak boleh kosong',
            'no_sk.required' => 'No SK tidak boleh kosong',
            'alamat_kantor.required' => 'Alamat Kantor tidak boleh kosong',
        ]);

        $files = ['foto', 'ttd'];

        $pengurus = Kepengurusan::where('id_kepengurusan', $id)->first();
        $penguruslama = '/www/wwwroot/hanura.net/uploads/img/foto_kepengurusan/' . $pengurus->foto;
        $ttdlama = '/www/wwwroot/hanura.net/uploads/img/ttd_kta/' . $pengurus->ttd;
        $files = ['foto', 'ttd'];

        foreach($files as $file){
            if($request->file($file)){
                $uploadedFile = $request->file($file);
                $filename = time() . '.' . $uploadedFile->getClientOriginalName();
                
                if ($file == 'foto') {
                    File::delete($penguruslama);
                       Image::make($uploadedFile)->resize(250, 300)->save('uploads/img/foto_kepengurusan/' . $filename);
                }else{
                    File::delete($ttdlama);
                       Image::make($uploadedFile)->resize(250, 300)->save('uploads/img/ttd_kta/' . $filename);
                }
                
                $files[$file] = $filename;
            }else{
                $oldFile = $file . '_lama';
                if($request->input($oldFile) !== 'noimage.jpg' && $request->input($oldFile) !== ''){
                    $files[$file] = $request->input($oldFile);
                }else{
                    $files[$file] = 'noimage.jpg';
                }
            }
        }

        Kepengurusan::where('id_kepengurusan', $id)->update([
            'jabatan' => $request->jabatan,
            'nama' => $request->nama,
            'kta' => $request->kta,
            'other_jabatan' => $request->other_jabatan,
            'nik' => $request->nik,
            'no_sk' => $request->no_sk,
            'alamat_kantor' => $request->alamat_kantor,
            'foto' => $files['foto'],
            'ttd' => $files['ttd'],
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('dpp.settings.kepengurusan.index')->with('success','Data berhasil diupdate');
        
    }

    public function kepengurusan_destroy($id)
    {
        $pengurus = Kepengurusan::where('id_kepengurusan', $id)->first();
        $penguruslama = '/www/wwwroot/hanura.net/uploads/img/foto_kepengurusan/' . $pengurus->foto;
        $ttdlama = '/www/wwwroot/hanura.net/uploads/img/ttd_kta/' . $pengurus->ttd;
        File::delete($penguruslama);
        File::delete($ttdlama);
        Kepengurusan::where('id_kepengurusan', $id)->update([
            'is_active' => 0
        ]);
        Kepengurusan::where('id_kepengurusan', $id)->delete();

        return redirect()->route('dpp.settings.kepengurusan.index')->with('success','Data berhasil dihapus');
    }
}
