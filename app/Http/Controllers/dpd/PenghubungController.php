<?php

namespace App\Http\Controllers\Dpd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\{Kepengurusan, Provinsi, Jabatan, DetailUsers, User, Penghubung};

class PenghubungController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = auth()->user()->id;
    

        $DetailUsers = DetailUsers::where('userid',$id)->first();
  
        return view('dpd.penghubung.index', compact('DetailUsers'));
    }
    public function getindex()
    {
        $id = auth()->user()->id;
    

        $DetailUsers = DetailUsers::where('userid',$id)->first();
  
        return view('dpd.penghubung.index_2', compact('DetailUsers'));
    }
    
    public function loadData(Request $request, $id_daerah)
    {
     
        $data = [];
        $id = Auth::user()->id;
        $detail= DetailUsers::where('userid',$id)->select('provinsi_domisili')->first();
        $pembatalan =  User::join('model_has_roles','users.id','=','model_has_roles.model_id')
            ->join('detail_users','users.id','=','detail_users.userid')
            ->where('users.generated_dpp', 0)
            // ->where('detail_users.status_kta', 1)
            // ->where('model_has_roles.role_id', 11)
            // ->where('users.super_admin', 0)
            ->where('detail_users.provinsi_domisili', $id_daerah)
            ->where('detail_users.nik', 'like', '%' . $request->q . '%')
            // ->where('detail_users.no_member', 'like', '%' . $request->q . '%')
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
            ->select('roles.key','detail_users.id','detail_users.no_member','detail_users.nik','detail_users.alamat','detail_users.nickname','detail_users.avatar', 'detail_users.no_hp','users.email', 'model_has_roles.role_id', 'detail_users.nickname','detail_users.kabupaten_domisili', 'detail_users.provinsi_domisili')
            ->where('detail_users.id',$request->id)->get();
            // dd($roles);
            

            foreach ($roles as $value) {
                $data[] = [
                    'name' => $value->nickname,
                    'no_member' => $value->no_member,
                    'nik' => $value->nik,
                    'alamat' => $value->alamat,
                    'email' => $value->email,
                    'no_hp' => $value->no_hp,
                    'name' => $value->nickname,
                    'roles' => $value->role_id,
                    'kabupaten_domisili' => $value->kabupaten_domisili,
                    'provinsi_domisili' => $value->provinsi_domisili,
                ];
            }
          
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $id = auth()->user()->id;
         $detail = DB::table('detail_users')
            ->where('userid', $id)
            ->first();
        $jabatan = Jabatan::whereBetween('kode', [2000, 2999])->get();
        $provinsi = Provinsi::where('id_prov', $detail->provinsi_domisili)->first();

        return view('dpd.penghubung.create', compact('jabatan', 'provinsi', 'detail'));
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
            'koordinator' => 'required',
            'jabatan' => 'required',
            'email' => 'required',
            'no_telp' => 'required',
            'no_sk' => 'required',
            'tanggal_sk' => 'required',
            'alamat' => 'required',
            'attachment' => 'max:10048|required',
        ],
        [
            'koordinator.required' => 'Koordinator tidak boleh kosong',
            'jabatan.required' => 'Jabatan tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'no_telp.required' => 'No Telp tidak boleh kosong',
            'no_sk.required' => 'No SK tidak boleh kosong',
            'alamat.required' => 'Alamat tidak boleh kosong',
            'tanggal_sk.required' => 'Tanggal SK tidak boleh kosong',
            'attachment.required' => 'Attachment SK tidak boleh kosong',
            'attachment.max'=> ' Silakan Pilih Ukuran Attachment SK. Kepengurusan Kurang Dari 10 MB!',
        ]);
         $uploadedFile=$request->file('attachment');
         $filename= time().'_'.$request->provinsi_domisili.'_'.$uploadedFile->getClientOriginalName();
         $uploadedFile->move('uploads/file/petugas_penghubung/', $filename);
        // $penghubung = array(
        //     'jabatan' => $request->jabatan,  
        //     'tanggal_sk' => $request->tanggal_sk,
        //     'koordinator' => $request->koordinator,
        //     'no_telp' => $request->no_telp,
        //     'emai' => $request->email,
        //     'no_sk' => $request->no_sk,
        //     'alamat' => $request->alamat,
        //     );
        
       $penghubung =  array([
            'jabatan' => $request->jabatan,  
            'tanggal_sk' => $request->tanggal_sk,
            'koordinator' => $request->koordinator,
            'no_telp' => $request->no_telp,
            'email' => $request->email,
            'attachment' => $filename,
            'name' => $request->name,
            'created_at' => date('Y-m-d H:i:s'),
            'no_sk' => $request->no_sk,
            'alamat' => $request->alamat,  
            'roles_id' => 11,
            //  'kabupaten_domisili' => $request->kabupaten_domisili != "" ? $request->kabupaten_domisili : "",
            'provinsi_domisili' => $request->provinsi_domisili != "" ? $request->provinsi_domisili : "",
        ]);
        $peng = Penghubung::insert($penghubung);

        return redirect("/dpd/penghubung")->with('success','Data berhasil ditambah');
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
        $iduser = Auth::user()->id;
        $detail = DetailUsers::where('userid', $iduser)->select('provinsi_domisili')->first();
        $provinsi = Provinsi::where('id_prov', $detail->provinsi_domisili)->first();
        $penghubung = Penghubung::join('detail_users', 'petugas_penghubung.koordinator', '=', 'detail_users.id')
            ->select('detail_users.nickname', 'detail_users.nik', 'detail_users.id', 'petugas_penghubung.no_sk', 'petugas_penghubung.no_telp', 'petugas_penghubung.jabatan', 'petugas_penghubung.id','petugas_penghubung.provinsi_domisili', 'petugas_penghubung.email', 'petugas_penghubung.alamat', 'petugas_penghubung.koordinator', 'petugas_penghubung.tanggal_sk', 'petugas_penghubung.name', 'petugas_penghubung.attachment')
            ->where('petugas_penghubung.id', $id)->first();
        return view('dpd.penghubung.edit',[
            'penghubung' => $penghubung,
            'detail' => $detail,
            'provinsi' => $provinsi
        ]);
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
         $request->validate([
            'koordinator' => 'required',
            'jabatan' => 'required',
            'email' => 'required',
            'no_telp' => 'required',
            'no_sk' => 'required',
            'tanggal_sk' => 'required',
            'alamat' => 'required',
            'attachment' => 'max:10048',
        ],
        [
            'koordinator.required' => 'Koordinator tidak boleh kosong',
            'jabatan.required' => 'Jabatan tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'no_telp.required' => 'No Telp tidak boleh kosong',
            'no_sk.required' => 'No SK tidak boleh kosong',
            'alamat.required' => 'Alamat tidak boleh kosong',
            'tanggal_sk.required' => 'Tanggal SK tidak boleh kosong',
            // 'attachment.required' => 'Attachment SK tidak boleh kosong',
            'attachment.max'=> ' Silakan Pilih Ukuran Attachment SK. Kepengurusan Kurang Dari 10 MB!',
        ]);
        if ($request->file('attachment') == '') {
          $filename = "";
       }elseif ($request->file('attachment') !== '') {
         $uploadedFile=$request->file('attachment');
         File::delete($request->attachments);
         $filename=time(). '_'. $request->provinsi .'_' .$uploadedFile->getClientOriginalName();
         $uploadedFile->move('uploads/file/petugas_penghubung/', $filename);
       }
        $koordinator = Penghubung::where('id', $id)->first();
         Penghubung::where('id', $id)->update([
            'jabatan' => $request->jabatan,
            // 'koordinator' => $request->koordinator,
            'email' => $request->email,
            'attachment' => $filename != "" ? $filename : $request->attachments,
            'name' => $request->name,
            'no_telp' => $request->no_telp,
            'tanggal_sk' => $request->tanggal_sk,
            'no_sk' => $request->no_sk,
            'alamat' => $request->alamat,
        ]);
       
        

        return redirect("/dpd/penghubung/")->with('success','Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
         Penghubung::where('id', $id)->delete();

        return redirect("/dpd/penghubung/")->with('success','Data berhasil dihapus');
    }
}
