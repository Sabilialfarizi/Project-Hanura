<?php

namespace App\Http\Controllers\dpp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\{Kepengurusan, Kecamatan, Jabatan, Kabupaten};
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\{PengurusPAC};
   
class KepengurusanKecamatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_daerah)
    {
        $kepengurusan = Kepengurusan::where('id_daerah', $id_daerah)->get();
  
        $kecamatan = Kecamatan::where('id_kec', $id_daerah)->first();

        return view('dpp.kepengurusan.kecamatan.index', compact('kepengurusan','kecamatan'));
    }
    
     public function show($id)
    {
        $kepengurusan = Kecamatan::where('id_kec', $id)->first();
        $exporter = app()->makeWith(PengurusPAC::class, compact('id'));


        return $exporter->download('Laporan Pengurus ' . $kepengurusan->name . '.xlsx');
    }

    public function create($id_daerah)
    {
        $jabatan = Jabatan::whereBetween('kode', [4000, 4999])->get();
        $kecamatan = Kecamatan::where('id_kec', $id_daerah)->first();
        $kabupaten = Kabupaten::where('id_kab', $kecamatan->id_kab)->first();
        

        return view('dpp.kepengurusan.kecamatan.create', compact('jabatan', 'kecamatan','kabupaten'));
    }

    public function store(Request $request, $id_daerah)
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
            'id_daerah' => $id_daerah,
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
       
        return redirect("/dpp/kecamatan/$id_daerah/kepengurusan")->with('success','Data berhasil dibuat');
    }

    public function edit($id_daerah, $id)
    {
        $kepengurusan = Kepengurusan::find($id);
        $jabatan = Jabatan::whereBetween('kode', [4000, 4999])->get();
        $kecamatan = Kecamatan::where('id_kec', $id_daerah)->first();

        return view('dpp.kepengurusan.kecamatan.edit', compact('kepengurusan', 'jabatan', 'kecamatan'));
    }

    public function update(Request $request, $id_daerah, $id)
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
            'is_active' => 1,
        ]);

        return redirect("/dpp/kecamatan/$id_daerah/kepengurusan")->with('success','Data berhasil diupdate');
    }

    public function destroy($id_daerah, $id)
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

        return redirect("/dpp/kecamatan/$id_daerah/kepengurusan")->with('success','Data berhasil dihapus');
    }
}