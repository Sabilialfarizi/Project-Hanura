<?php

namespace App\Http\Controllers\dpp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\{Kepengurusan, Provinsi, User, DetailUsers,Jabatan};

class KepengurusanProvinsiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_daerah)
    {
        $kepengurusan = Kepengurusan::where('id_daerah', $id_daerah)->get();
        $provinsi = Provinsi::where('id_prov', $id_daerah)->first();

        return view('dpp.kepengurusan.provinsi.index', compact('kepengurusan', 'provinsi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id_daerah)
    {
        $jabatan = Jabatan::whereBetween('kode', [2000, 2999])->get();
        $provinsi = Provinsi::where('id_prov', $id_daerah)->first();

        return view('dpp.kepengurusan.provinsi.create', compact('jabatan', 'provinsi'));
    }
      public function loaddata(Request $request, $id_daerah)
    {
     
        $data = [];
        $id = Auth::user()->id;
        $detail= DetailUsers::where('userid',$id)->select('provinsi_domisili')->first();
        $pembatalan =  User::join('model_has_roles','users.id','=','model_has_roles.model_id')
            ->join('detail_users','users.id','=','detail_users.userid')
            ->where('detail_users.status_kta', 1)
            ->where('users.generated_dpp',0)
            // ->where('users.super_admin', 0)
            // ->where('detail_users.provinsi_domisili', $id_daerah)
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

        return redirect("/dpp/provinsi/$id_daerah/kepengurusan")->with('success','Data berhasil diupdate');
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
    public function edit($id_daerah, $id)
    {
        $kepengurusan = Kepengurusan::find($id);
        $jabatan = Jabatan::whereBetween('kode', [2000, 2999])->get();
        $provinsi = Provinsi::where('id_prov', $id_daerah)->first();

        return view('dpp.kepengurusan.provinsi.edit', compact('kepengurusan', 'jabatan', 'provinsi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

        return redirect("/dpp/provinsi/$id_daerah/kepengurusan/")->with('success','Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_daerah, $id)
    {
        $pengurus = Kepengurusan::where('id_kepengurusan', $id)->first();
        $penguruslama = '/www/wwwroot/hanura.net/uploads/img/foto_kepengurusan/' . $pengurus->foto;
        $ttdlama = '/www/wwwroot/hanura.net/uploads/img/ttd_kta/' . $pengurus->ttd;
          File::delete($penguruslama); 
         File::delete($ttdlama);
        Kepengurusan::where('id_kepengurusan', $id)->delete();

        return redirect("/dpp/provinsi/$id_daerah/kepengurusan/")->with('success','Data berhasil dihapus');
    }
}