<?php

namespace App\Http\Controllers\dpp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Kantor;
use App\Provinsi;
use App\Kabupaten;
use App\Kecamatan;
use App\Kelurahan;



class KantorProvinsiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $daerah = Provinsi::where('id_prov', $id)->first();
    
        $kantor = Kantor::where('id_daerah', $id)->first();
        
        return view('dpp.kantor.index', compact('kantor', 'daerah'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $provinsi = Provinsi::where('status', 1)->pluck('name', 'id_prov');
        $kabupaten =  Kabupaten::where('status', 1)->pluck('name', 'id_kab');
        $nama_bank = DB::table('bank')->where('status',1)->pluck('nama_bank','id_bank');
        $daerah = Provinsi::where('id_prov', $id)->first();

        return view('dpp.kantor.create', compact('provinsi', 'daerah', 'kabupaten','nama_bank'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id_daerah)
    {
       
  
        $request->validate([
            'alamat' => 'required',
            'id_daerah' => 'required',
            'provinsi' => 'required',
            'kab_kota' => 'required',
            'kec' => 'required',
            'nama_bank' => 'required',
            'kode_pos' => 'required',
            'status_kantor' => 'required',
            'kel' => 'required',
            'tanggal_pengesahan_sk' => 'required',
            'nomor_rekening_bank' => 'required',
            'rt_rw' => 'required',
            // 'koordinat' => 'required',
            'no_telp' => 'required',
            // 'fax' => 'required',
            'no_sk'=> 'max:10048',
            'surat_keterangan_kantor'=> 'max:10048',
            'rekening_bank'=> 'max:10048',
            'cap_kantor'=> 'max:10048',
            'domisili'=> 'max:10048',
            'email' => 'required|email',
            // 'is_active' => 'required',
        ],
        [
            'alamat.required' => 'Alamat harus diisi!',
            'kode_pos.required' => 'Kode Pos harus diisi!',
            // 'koordinat.required' => 'Koordinat harus diisi!',
            'provinsi.required' => 'Provinsi harus diisi!',
            'tanggal_pengesahan_sk.required' => 'Tanggal Pengesahan SK harus diisi!',
            'nomor_rekening_bank.required' => 'Nomor Rekening Bank harus diisi!',
            'nama_bank.required' => 'Nama Bank harus diisi!',
            'status_kantor.required' => 'Status Kantor harus diisi!',
            'kab_kota.required' => 'Kabupaten harus diisi!',
            'kec.required' => 'Kecamatan harus diisi!',
            'kel.required' => 'Kelurahan harus diisi!',
            'rt_rw.required' => 'RT/RW harus diisi!',
            'no_telp.required' => 'No. Telepon harus diisi!',
            // 'fax.required' => 'Fax harus diisi!',
            'email.required' => 'Email harus diisi!',
            'email.email' => 'Email tidak valid!',
            // 'is_active.required' => 'Status harus diisi!',
        ]);
        
        $files=['cap_kantor','domisili','no_sk','rekening_bank','surat_keterangan_kantor'];
       foreach($files as $file) {
            if($request->file($file)) {
                $uploadedFile=$request->file($file);
                $filename=time() . '.'. $uploadedFile->getClientOriginalName();

                if ($file=='cap_kantor') {

                    Image::make($uploadedFile)->resize(150, 150)->save('uploads/img/cap_kantor/'. $filename);
                }

                elseif($file=='domisili') {
                    $uploadedFile->move('uploads/file/domisili/', $filename);
                }

                elseif($file == 'surat_keterangan_kantor'){

                    $uploadedFile->move('uploads/file/surat_keterangan_kantor/', $filename);

                }
                elseif($file == 'no_sk'){

                    $uploadedFile->move('uploads/file/no_sk/', $filename);

                }else {
                      $uploadedFile->move('uploads/file/rekening_bank/', $filename);
                    
                }

                $files[$file]=$filename;
            }

            else {
                $files[$file]='';
            }
        }
       $kantor = array(
            'alamat' => $request->alamat,
            'kode_pos' => $request->kode_pos,
            'id_daerah' => $request->id_daerah,
            'id_tipe_daerah' => 2,
            'provinsi' => $request->provinsi,
            'kab_kota' => $request->kab_kota,
            'kec' => $request->kec,
            'kel' => $request->kel,
            'rt_rw' => $request->rt_rw,
             'nomor_rekening_bank' => $request->nomor_rekening_bank,
            'tanggal_pengesahan_sk' => $request->tanggal_pengesahan_sk,
              'status_kantor' => $request->status_kantor,
            'tgl_awal' => $request->tgl_awal,
            'nama_bank' => $request->nama_bank,
            'tgl_selesai' => $request->tgl_selesai,
            // 'koordinat' => $request->koordinat,
            'no_telp' => $request->no_telp,
            'fax' => $request->fax,
            'email' => $request->email,
            'cap_kantor'=> $files['cap_kantor'],
            'domisili'=> $files['domisili'],
            'no_sk'=> $files['no_sk'],
            'surat_keterangan_kantor'=> $files['surat_keterangan_kantor'],
            'rekening_bank'=> $files['rekening_bank'],
            'is_active' => $request->is_active,
        );
        
        $use = Kantor::insert($kantor);
    
    
        
          return redirect("/dpp/provinsi/$request->id_daerah/kantor")->with('success','Data berhasil dibuat');
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
    public function edit($id_daerah, $id_kantor)
    {

        $kantor = Kantor::where('id_kantor', $id_kantor)->first();
        
        $daerah = Provinsi::where('id_prov', $kantor->id_daerah)->first();
        $provinsi = Provinsi::where('status', 1)->where('id_prov', $kantor->provinsi)->pluck('name', 'id_prov');
        $kabupaten =  Kabupaten::where('status', 1)->where('id_prov', $kantor->provinsi)->pluck('name', 'id_kab');
        $kecamatan =  Kecamatan::where('status', 1)->where('id_kab', $kantor->kab_kota)->pluck('name', 'id_kec');
        $kelurahan =  Kelurahan::where('status', 1)->where('id_kec', $kantor->kec)->pluck('name', 'id_kel');
        $nama_bank = DB::table('bank')->where('status',1)->pluck('nama_bank','id_bank');

        return view('dpp.kantor.edit', compact('kantor', 'provinsi', 'daerah', 'kabupaten', 'kecamatan', 'kelurahan','nama_bank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_daerah, $id_kantor)
    {
      
    
         $request->validate([
            'alamat' => 'required',
            'id_daerah' => 'required',
            'kode_pos' => 'required',
            'provinsi' => 'required',
            'kab_kota' => 'required',
            'kec' => 'required',
            'nama_bank' => 'required',
            'status_kantor' => 'required',
            'kel' => 'required',
            'rt_rw' => 'required',
         'tanggal_pengesahan_sk' => 'required',
            'nomor_rekening_bank' => 'required',
            // 'koordinat' => 'required',
            'no_telp' => 'required',
            // 'fax' => 'required',
            'no_sk'=> 'max:10048',
            'surat_keterangan_kantor'=> 'max:10048',
            'rekening_bank'=> 'max:10048',
            'cap_kantor'=> 'max:10048',
            'domisili'=> 'max:10048',
            'email' => 'required|email',
            // 'is_active' => 'required',
        ],
        [
            'alamat.required' => 'Alamat harus diisi!',
            'kode_pos.required' => 'Kode Pos harus diisi!',
            // 'koordinat.required' => 'Koordinat harus diisi!',
            'tanggal_pengesahan_sk.required' => 'Tanggal Pengesahan SK harus diisi!',
            'nomor_rekening_bank.required' => 'Nomor Rekening Bank harus diisi!',
            'provinsi.required' => 'Provinsi harus diisi!',
            'nama_bank.required' => 'Nama Bank harus diisi!',
            'status_kantor.required' => 'Status Kantor harus diisi!',
            'kab_kota.required' => 'Kabupaten harus diisi!',
            'kec.required' => 'Kecamatan harus diisi!',
            'kel.required' => 'Kelurahan harus diisi!',
            'rt_rw.required' => 'RT/RW harus diisi!',
            'no_telp.required' => 'No. Telepon harus diisi!',
            // 'fax.required' => 'Fax harus diisi!',
            'email.required' => 'Email harus diisi!',
            'email.email' => 'Email tidak valid!',
            // 'is_active.required' => 'Status harus diisi!',
        ]);
         $files=['cap_kantor','no_sk','domisili','rekening_bank','surat_keterangan_kantor'];
      
        $cap = Kantor::where('id_kantor', $id_kantor)->first();
      
        $caplama='/www/wwwroot/hanura.net/uploads/img/cap_kantor/'. $cap->cap_kantor;
        $domisili='/www/wwwroot/hanura.net/uploads/file/domisili/'. $cap->domisili;
        $no_sk='/www/wwwroot/hanura.net/uploads/file/no_sk/'. $cap->no_sk;
        $surat ='/www/wwwroot/hanura.net/uploads/file/surat_keterangan_kantor/'. $cap->surat_keterangan_kantor;
        $rekening ='/www/wwwroot/hanura.net/uploads/file/rekening_bank/'. $cap->rekening_bank;

        foreach($files as $file) {
            if($request->file($file)) {
                $uploadedFile=$request->file($file);
                $filename=time() . '.'. $uploadedFile->getClientOriginalName();

                if ($file=='cap_kantor') {
                     File::delete($caplama);
                     Image::make($uploadedFile)->resize(150, 150)->save('uploads/img/cap_kantor/'. $filename);
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
                else{
                    File::delete($surat);
                    $uploadedFile->move('uploads/file/surat_keterangan_kantor/', $filename);

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

        $kantor = Kantor::where('id_kantor', $id_kantor)->update([
            'alamat' => $request->alamat,
            'kode_pos' => $request->kode_pos,
            'id_daerah' => $request->id_daerah,
            'id_tipe_daerah' => 2,
            'provinsi' => $request->provinsi,
            'kab_kota' => $request->kab_kota,
            'kec' => $request->kec,
            'kel' => $request->kel,
            'rt_rw' => $request->rt_rw,
              'status_kantor' => $request->status_kantor,
            'tgl_awal' => $request->tgl_awal,
             'nomor_rekening_bank' => $request->nomor_rekening_bank,
            'tanggal_pengesahan_sk' => $request->tanggal_pengesahan_sk,
            'nama_bank' => $request->nama_bank,
            'tgl_selesai' => $request->tgl_selesai,
            // 'koordinat' => $request->koordinat,
            'no_telp' => $request->no_telp,
            'fax' => $request->fax,
            'email' => $request->email,
            'cap_kantor'=> $files['cap_kantor'],
            'domisili'=> $files['domisili'],
            'no_sk'=> $files['no_sk'],
            'surat_keterangan_kantor'=> $files['surat_keterangan_kantor'],
            'rekening_bank'=> $files['rekening_bank'],
            'is_active' => $request->is_active,
        ]);
   
           return redirect("/dpp/provinsi/$request->id_daerah/kantor")->with('success','Data kantor berhasil diubah!');

    }
    public function domisili($id_kantor)
    {
        $detail = Kantor::where('id_daerah',$id_kantor)->first();
    

        $file = '/www/wwwroot/siap.partaihanura.or.id/uploads/file/domisili/'. $detail->domisili;
        
        return response()->file($file);
    }
    
    
          public function no_sk($id_kantor)
    {
        $detail = Kantor::where('id_daerah',$id_kantor)->first();
      

        $file = '/www/wwwroot/siap.partaihanura.or.id/uploads/file/no_sk/'. $detail->no_sk;
        
        return response()->file($file);
    }
    public function surat_keterangan($id_kantor)
    {
        $detail = Kantor::where('id_daerah',$id_kantor)->first();
    
    

        $file = '/www/wwwroot/siap.partaihanura.or.id/uploads/file/surat_keterangan_kantor/'. $detail->surat_keterangan_kantor;
        
        return response()->file($file);
    }
    
    
          public function rekening_bank($id_kantor)
    {
        $detail = Kantor::where('id_daerah',$id_kantor)->first();
      

        $file = '/www/wwwroot/siap.partaihanura.or.id/uploads/file/rekening_bank/'. $detail->rekening_bank;
        
        return response()->file($file);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}