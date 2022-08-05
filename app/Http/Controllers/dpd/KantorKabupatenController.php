<?php

namespace App\Http\Controllers\dpd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Kabupaten;
use App\Kantor;
use App\Provinsi;
use App\Kecamatan;
use App\Kelurahan;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class KantorKabupatenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $daerah = Kabupaten::where('id_kab', $id)->first();
        $kantor = Kantor::where('id_daerah', $id)->first();
        
        return view('dpd.kantor.index', compact('kantor', 'daerah'));
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
        $daerah = Kabupaten::where('id_kab', $id)->first();

        return view('dpd.kantor.create', compact('provinsi', 'daerah', 'kabupaten','nama_bank'));
    }
    public function getKelurahan(Request $request)
    {
        $data = Kelurahan::where('id_kec', $request->val)
            ->get();

        return \Response::json($data);
    }

    public function getKecamatan(Request $request)
    {
        $data = Kecamatan::where('id_kab', $request->val)
            ->get();

        return \Response::json($data);
    }

    public function getKabupaten(Request $request)
    {
        $data = Kabupaten::where('id_prov', $request->val)
            ->get();

        return \Response::json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
   
       $request->validate([
            'alamat' => 'required',
            'id_daerah' => 'required',
            'provinsi' => 'required',
            'kab_kota' => 'required',
            'kec' => 'required',
            'kel' => 'required',
            'rt_rw' => 'required',
            'kode_pos' => 'required',
            'no_telp' => 'required',
            'tanggal_pengesahan_sk' => 'required',
            'nomor_rekening_bank' => 'required',
            // 'koordinat'=>'required',
          //  'fax' => 'required',
             'no_sk'=> 'max:10048',
            'surat_keterangan_kantor'=> 'max:10048',
            'rekening_bank'=> 'max:10048',
            'cap_kantor'=> 'max:10048',
            'domisili'=> 'max:10048',
            'target_dpc' => 'required',
            'wa_kantor' => 'required',
            'nama_bank' => 'required',
            'status_kantor' => 'required',
            'email' => 'required|email',
            //'is_active' => 'required',
        ],
        [
            'alamat.required' => 'Alamat harus diisi!',
            'nama_bank.required' => 'Nama Bank harus diisi!',
            // 'koordinat.required' => 'Koordinat harus diisi!',
            'kode_pos.required' => 'Kode Pos harus diisi!',
            'provinsi.required' => 'Provinsi harus diisi!',
            'tanggal_pengesahan_sk.required' => 'Tanggal Pengesahan SK harus diisi!',
            'nomor_rekening_bank.required' => 'Nomor Rekening Bank harus diisi!',
            'kab_kota.required' => 'Kabupaten harus diisi!',
            'kec.required' => 'Kecamatan harus diisi!',
            'kel.required' => 'Kelurahan harus diisi!',
            'rt_rw.required' => 'RT/RW harus diisi!',
            'no_telp.required' => 'No. Telepon harus diisi!',
            'status_kantor.required' => 'Status Kantor harus diisi!',
            //'fax.required' => 'Fax harus diisi!',
            'wa_kantor.required'=> 'WhatsApp Kantor harus diisi!',
            'target_dpc.required' => 'Target Anggota DPC harus diisi!',
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

       $data = array(
            'alamat' => $request->alamat,
            'kode_pos' => $request->kode_pos,
            'id_daerah' => $request->id_daerah,
            'id_tipe_daerah' => 3,
            'provinsi' => $request->provinsi,
            'kab_kota' => $request->kab_kota,
            'kec' => $request->kec,
            'kel' => $request->kel,
            'rt_rw' => $request->rt_rw,
            'tanggal_pengesahan_sk' => $request->tanggal_pengesahan_sk,
            'nomor_rekening_bank' => $request->nomor_rekening_bank,
            //  'koordinat' => $request->koordinat,
            'no_telp' => $request->no_telp,
            'fax' => $request->fax,
            'wa_kantor' => $request->wa_kantor,
            'status_kantor' => $request->status_kantor,
            'tgl_awal' => $request->tgl_awal,
            'nama_bank' => $request->nama_bank,
            'tgl_selesai' => $request->tgl_selesai,
            'email' => $request->email,
            'target_dpc' => $request->target_dpc,
            'cap_kantor'=> $files['cap_kantor'],
            'domisili'=> $files['domisili'],
            'no_sk'=> $files['no_sk'],
            'surat_keterangan_kantor'=> $files['surat_keterangan_kantor'],
            'rekening_bank'=> $files['rekening_bank'],
            'is_active' => $request->is_active,
        );
        
        $kantor = Kantor::insert($data);
   
        
        return redirect()->route('dpd.kantor.index', $request->id_daerah)->with('success', 'Data kantor berhasil ditambahkan!');
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
        
        $daerah = Kabupaten::where('id_kab', $kantor->id_daerah)->first();
        $provinsi = Provinsi::where('status', 1)->where('id_prov', $kantor->provinsi)->pluck('name', 'id_prov');
       
        $kabupaten =  Kabupaten::where('status', 1)->where('id_prov', $kantor->provinsi)->pluck('name', 'id_kab');
        $kecamatan =  Kecamatan::where('status', 1)->where('id_kab', $kantor->kab_kota)->pluck('name', 'id_kec');
        $kelurahan =  Kelurahan::where('status', 1)->where('id_kec', $kantor->kec)->pluck('name', 'id_kel');
        $nama_bank = DB::table('bank')->where('status',1)->pluck('nama_bank','id_bank');


        return view('dpd.kantor.edit', compact('kantor', 'provinsi', 'daerah', 'kabupaten', 'kecamatan', 'kelurahan','nama_bank'));
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
            'provinsi' => 'required',
            'kab_kota' => 'required',
            'kec' => 'required',
            'kode_pos' => 'required',
            'kel' => 'required',
            'rt_rw' => 'required',
            'no_telp' => 'required',
              'tanggal_pengesahan_sk' => 'required',
            'nomor_rekening_bank' => 'required',
            // 'koordinat'=>'required',
          //  'fax' => 'required',
             'no_sk'=> 'max:10048',
            'surat_keterangan_kantor'=> 'max:10048',
            'rekening_bank'=> 'max:10048',
            'cap_kantor'=> 'max:10048',
            'domisili'=> 'max:10048',
            'target_dpc' => 'required',
            'wa_kantor' => 'required',
            'nama_bank' => 'required',
            'status_kantor' => 'required',
            'email' => 'required|email',
            //'is_active' => 'required',
        ],
        [
            'alamat.required' => 'Alamat harus diisi!',
            'nama_bank.required' => 'Nama Bank harus diisi!',
            'kode_pos.required' => 'Kode Pos harus diisi!',
            // 'koordinat.required' => 'Koordinat harus diisi!',
              'tanggal_pengesahan_sk.required' => 'Tanggal Pengesahan SK harus diisi!',
            'nomor_rekening_bank.required' => 'Nomor Rekening Bank harus diisi!',
            'provinsi.required' => 'Provinsi harus diisi!',
            'kab_kota.required' => 'Kabupaten harus diisi!',
            'kec.required' => 'Kecamatan harus diisi!',
            'kel.required' => 'Kelurahan harus diisi!',
            'rt_rw.required' => 'RT/RW harus diisi!',
            'no_telp.required' => 'No. Telepon harus diisi!',
            'status_kantor.required' => 'Status Kantor harus diisi!',
            //'fax.required' => 'Fax harus diisi!',
            'wa_kantor.required'=> 'WhatsApp Kantor harus diisi!',
            'target_dpc.required' => 'Target Anggota DPC harus diisi!',
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
            //  'koordinat' => $request->koordinat,
            'id_daerah' => $id_daerah,
            'id_tipe_daerah' => 3,
            'status_kantor' => $request->status_kantor,
            'tgl_awal' => $request->tgl_awal,
            'nama_bank' => $request->nama_bank,
            'tgl_selesai' => $request->tgl_selesai,
            'provinsi' => $request->provinsi,
            'kab_kota' => $request->kab_kota,
            'kec' => $request->kec,
            'kel' => $request->kel,
            'rt_rw' => $request->rt_rw,
            'nomor_rekening_bank' => $request->nomor_rekening_bank,
            'tanggal_pengesahan_sk' => $request->tanggal_pengesahan_sk,
            'no_telp' => $request->no_telp,
            'fax' => $request->fax,
            'target_dpc' => $request->target_dpc,
            'email' => $request->email,
            'wa_kantor' => $request->wa_kantor,
            'cap_kantor'=>$files['cap_kantor'],
            'no_sk'=>$files['no_sk'],
            'rekening_bank'=>$files['rekening_bank'],
            'domisili'=>$files['domisili'],
            'surat_keterangan_kantor'=>$files['surat_keterangan_kantor'],
            'is_active' => $request->is_active,
        ]);
 
     

        return redirect()->route('dpd.kantor.index', $id_daerah)->with('success', 'Data kantor berhasil diubah!');
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