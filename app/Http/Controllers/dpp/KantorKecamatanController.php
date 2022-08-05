<?php namespace App\Http\Controllers\dpp;

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
use App\DetailUsers;



class KantorKecamatanController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id) {
        $daerah = Kecamatan::where('id_kec', $id)->first();

        $kantor= Kantor::where('id_daerah', $id)->first();


        return view('dpp.kantor.kecamatan.index', compact('kantor', 'daerah'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id) {
        $provinsi_code = substr($id,0,2);
        $kabupaten_code = substr($id,0,4);
        $kecamatan_code = $id;
        $provinsi = Provinsi::where('status', 1)->pluck('name', 'id_prov');
        $kabupaten = Kabupaten::where('status', 1)->pluck('name', 'id_kab');

        $daerah = Kecamatan::where('id_kec', $id)->first();

        return view('dpp.kantor.kecamatan.create', compact('provinsi', 'daerah', 'kabupaten','kabupaten_code','provinsi_code','kecamatan_code'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id_daerah) {

        $request->validate([ 
            // 'alamat'=> 'required',
            'id_daerah'=> 'required',
            'status_kantor'=> 'required',
            // 'kode_pos' => 'required',
            // 'provinsi'=> 'required',
            // 'kab_kota'=> 'required',
            // 'kec'=> 'required',
            // 'kel'=> 'required',
            // 'rt_rw'=> 'required',
            // 'no_telp'=> 'required',
            'tanggal_pengesahan_sk' => 'required',
          
            'no_sk'=> 'required|max:10048',
            'cap_kantor'=> 'max:10048',
            'domisili'=> 'max:10048',
            // 'koordinat' => 'required',
            // 'fax' => 'required',
            // 'wa_kantor'=> 'required',
            // 'email'=> 'required|email',
            // 'is_active'=> 'required',
            ],
            [ 
            // 'alamat.required'=> 'Alamat harus diisi!',
            // 'kode_pos.required'=> 'Kode Pos harus diisi!',
            // 'provinsi.required'=> 'Provinsi harus diisi!',
            // 'koordinat.required' => 'Koordinat harus diisi!',
            'tanggal_pengesahan_sk.required' => 'Tanggal Pengesahan SK harus diisi!',
            'status_kantor.required' => 'Status Kantor harus diisi!',
            // 'kab_kota.required'=> 'Kabupaten harus diisi!',
            // 'kec.required'=> 'Kecamatan harus diisi!',
            // 'kel.required'=> 'Kelurahan harus diisi!',
            // 'rt_rw.required'=> 'RT/RW harus diisi!',
            // 'no_telp.required'=> 'No. Telepon harus diisi!',
            'no_sk.required'=> 'SK. Kepengurusan harus diisi!',
            'no_sk.max'=> ' Silakan Pilih Ukuran SK. Kepengurusan Kurang Dari 10 MB!',
            // 'cap_kantor.required'=> 'Cap Kantor harus diisi!',
            // 'domisili.required'=> 'Domisili harus diisi!',
            // 'wa_kantor.required'=> 'WhatsApp Kantor harus diisi!',
            // 'email.required'=> 'Email harus diisi!',
            // 'email.email'=> 'Email tidak valid!',
            // 'is_active.required' => 'Status harus diisi!',
            ]);
        $files=['cap_kantor','domisili','no_sk'];

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

                else {

                    $uploadedFile->move('uploads/file/no_sk/', $filename);

                }

                $files[$file]=$filename;
            }

            else {
                $files[$file]='';
            }
        }



        $kantor = array('alamat'=> $request->alamat,
            'id_daerah'=> $request->id_daerah,
            'id_tipe_daerah'=> 4,
            'kode_pos' => $request->kode_pos,
            'provinsi'=> $request->provinsi,
            'kab_kota'=> $request->kab_kota,
            'kec'=> $request->kec,
            'kel'=> $request->kel,
            'rt_rw'=> $request->rt_rw,
            'no_telp'=> $request->no_telp,
            'tanggal_pengesahan_sk' => $request->tanggal_pengesahan_sk,
            'status_kantor' => $request->status_kantor,
            'tgl_awal' => $request->tgl_awal,
            'tgl_selesai' => $request->tgl_selesai,
            //  'koordinat' => $request->koordinat,
            'fax'=> $request->fax,
            'email'=> $request->email,
            'wa_kantor'=> $request->wa_kantor,
            'cap_kantor'=> $files['cap_kantor'],
            'domisili'=> $files['domisili'],
            'no_sk'=> $files['no_sk'],
            'is_active'=> 1,
        );
     
        $insert=Kantor::insert($kantor);

        return redirect("/dpp/kecamatan/$request->id_daerah/kantor")->with('success', 'Data berhasil dibuat');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_daerah, $id_kantor) {
    
        $kantor = Kantor::where('id_kantor', $id_kantor)->first();
        $id = auth()->user()->id;
        $detail = DetailUsers::where('userid', $id)->first();
        
    // $provinsis = Provinsi::where('status', 1)->where('id_prov', $detail->provinsi_domisili)->pluck('name', 'id_prov');
        $idkec =  Kecamatan::where('status', 1)->where('id_kec', $id_daerah)->select('id_kab')->first();
        $idkab = Kabupaten::where('id_kab', $idkec->id_kab)->select('id_prov')->first();
        $daerah = Kecamatan::where('id_kec', $kantor->id_daerah)->first();
        $provinsi = Provinsi::where('status', 1)->where('id_prov', $idkab->id_prov)->pluck('name', 'id_prov');
      
        $kabupaten =  Kabupaten::where('status', 1)->where('id_prov', $idkab->id_prov)->pluck('name', 'id_kab');
     
        $kecamatan =  Kecamatan::where('status', 1)->where('id_kab', $idkec->id_kab)->pluck('name', 'id_kec');
        
        $kelurahan =  Kelurahan::where('status', 1)->where('id_kec', $id_daerah)->pluck('name', 'id_kel');
       
        $nama_bank = DB::table('bank')->where('status',1)->pluck('nama_bank','id_bank');



        return view('dpp.kantor.kecamatan.edit', compact('kantor', 'provinsi', 'daerah', 'kabupaten', 'kecamatan', 'kelurahan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_daerah, $id_kantor) {
        // dd($request->all());
     
        $request->validate([ 
            // 'alamat'=> 'required',
            'id_daerah'=> 'required',
            // 'kode_pos' => 'required',
            // 'provinsi'=> 'required',
            // 'kab_kota'=> 'required',
            // 'kec'=> 'required',
            // 'kel'=> 'required',
            // 'rt_rw'=> 'required',
            // 'no_telp'=> 'required',
             'status_kantor' => 'required',
            'tanggal_pengesahan_sk' => 'required',
          
            'no_sk'=> 'max:20048',
            'cap_kantor'=> 'max:10048',
            'domisili'=> 'max:10048',
            // 'koordinat' => 'required',
            // 'fax' => 'required',
            // 'wa_kantor'=> 'required',
            // 'email'=> 'required|email',
            // 'is_active'=> 'required',
            ],
            [ 
            // 'alamat.required'=> 'Alamat harus diisi!',
            // 'kode_pos.required'=> 'Kode Pos harus diisi!',
            // 'provinsi.required'=> 'Provinsi harus diisi!',
            // 'koordinat.required' => 'Koordinat harus diisi!',
            'status_kantor.required' => 'Status Kantor harus diisi!',
            'tanggal_pengesahan_sk.required' => 'Tanggal Pengesahan SK harus diisi!',
            // 'kab_kota.required'=> 'Kabupaten harus diisi!',
            // 'kec.required'=> 'Kecamatan harus diisi!',
            // 'kel.required'=> 'Kelurahan harus diisi!',
            // 'rt_rw.required'=> 'RT/RW harus diisi!',
            // 'no_telp.required'=> 'No. Telepon harus diisi!',
            // 'no_sk.required'=> 'SK. Kepengurusan harus diisi!',
            // 'no_sk.max'=> ' Silakan Pilih Ukuran SK. Kepengurusan Kurang Dari 10 MB!',
            // 'cap_kantor.required'=> 'Cap Kantor harus diisi!',
            // 'domisili.required'=> 'Domisili harus diisi!',
            // 'wa_kantor.required'=> 'WhatsApp Kantor harus diisi!',
            // 'email.required'=> 'Email harus diisi!',
            // 'email.email'=> 'Email tidak valid!',
            // 'is_active.required' => 'Status harus diisi!',
            ]);
        $files=['cap_kantor','no_sk','domisili'];
      
        $cap = Kantor::where('id_kantor', $id_kantor)->first();
    
      
        $caplama='/www/wwwroot/siap.partaihanura.or.id/uploads/img/cap_kantor/'. $cap->cap_kantor;
        $domisili='/www/wwwroot/siap.partaihanura.or.id/uploads/file/domisili/'. $cap->domisili;
        $no_sk='/www/wwwroot/siap.partaihanura.or.id/uploads/file/no_sk/'. $cap->no_sk;

        foreach($files as $file) {
            if($request->file($file)) {
                $uploadedFile=$request->file($file);
                $filename=time() . '.' .$uploadedFile->getClientOriginalName();

                if ($file=='cap_kantor') {
                     File::delete($caplama);
                     Image::make($uploadedFile)->resize(250, 300)->save('uploads/img/cap_kantor/'. $filename);
                }

                elseif($file=='domisili') {
                    File::delete($domisili);
                    $uploadedFile->move('uploads/file/domisili/', $filename);
                }

                else {
                    File::delete($no_sk);
                    $uploadedFile->move('uploads/file/no_sk/', $filename);

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
            'alamat'=> $request->alamat,
            'kode_pos' => $request->kode_pos,
            'id_daerah'=> $request->id_daerah,
            'id_tipe_daerah'=> 4,
            'provinsi'=> $request->provinsi,
            'kab_kota'=> $request->kab_kota,
            'kec'=> $request->kec,
            'status_kantor' => $request->status_kantor,
            'tgl_awal' => $request->tgl_awal,
            'tgl_selesai' => $request->tgl_selesai,
            'tanggal_pengesahan_sk' => $request->tanggal_pengesahan_sk,
            //  'koordinat' => $request->koordinat,
            'kel'=> $request->kel,
            'rt_rw'=> $request->rt_rw,
            'no_telp'=> $request->no_telp,
            'fax'=> $request->fax,
            'email'=> $request->email,
            'wa_kantor'=> $request->wa_kantor,
            'cap_kantor'=>$files['cap_kantor'],
            'no_sk'=>$files['no_sk'],
            'domisili'=>$files['domisili'],
            'is_active'=> 1,
            ]);
 
            
      

        return redirect("/dpp/kecamatan/$request->id_daerah/kantor")->with('success', 'Data berhasil diupdate');
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }
}