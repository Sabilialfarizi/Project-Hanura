<?php

namespace App\Http\Controllers\Dpc;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyMemberRequest;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\{User, DetailUsers, MaritalStatus, Job, Provinsi, Kepengurusan, Kabupaten, Kecamatan, Kelurahan, Kantor, AnggotaBU};
use Alert;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;
use Carbon\carbon;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\{DPCExport, DPCExport_hp, KabupatenAllExport};
use Illuminate\Support\Facades\File;
use DataTables;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // abort_unless(\Gate::allows('category_access'), 403);
        $id = Auth::user()->id;
        $detail = DetailUsers::where('userid', $id)->value('kabupaten_domisili');
        $kabupaten = Kabupaten::where('id_kab', $detail)->first();
        $status_belum = DB::table('status_kpu')->where('id_status', 1)->select('warna_status', 'nama_status')->first();
        $status_terkirim = DB::table('status_kpu')->where('id_status', 2)->select('warna_status', 'nama_status')->first();
        $status_verifikasi = DB::table('status_kpu')->where('id_status', 3)->select('warna_status', 'nama_status')->first();
        $status_tidak_lolos = DB::table('status_kpu')->where('id_status', 4)->select('warna_status', 'nama_status')->first();
        $hasil_perbaikan = DB::table('status_kpu')->where('id_status', 5)->select('warna_status', 'nama_status')->first();



        return view('dpc.member.index', compact('detail', 'status_belum', 'status_terkirim', 'status_verifikasi', 'status_tidak_lolos', 'hasil_perbaikan', 'kabupaten'));
    }
    public function coba()
    {
        // abort_unless(\Gate::allows('category_access'), 403);
        $id = Auth::user()->id;

        $detail = DetailUsers::where('userid', $id)->value('kabupaten_domisili');
        $kabupaten = Kabupaten::where('id_kab', $detail)->first();
        $status_belum = DB::table('status_kpu')->where('id_status', 1)->select('warna_status', 'nama_status')->first();
        $status_terkirim = DB::table('status_kpu')->where('id_status', 2)->select('warna_status', 'nama_status')->first();
        $status_verifikasi = DB::table('status_kpu')->where('id_status', 3)->select('warna_status', 'nama_status')->first();
        $status_tidak_lolos = DB::table('status_kpu')->where('id_status', 4)->select('warna_status', 'nama_status')->first();
        $hasil_perbaikan = DB::table('status_kpu')->where('id_status', 5)->select('warna_status', 'nama_status')->first();

        return view('dpc.member.coba', compact('detail', 'status_belum', 'status_terkirim', 'status_verifikasi', 'status_tidak_lolos', 'hasil_perbaikan', 'kabupaten'));
    }
    public function sdh_transfer()
    {
        // abort_unless(\Gate::allows('category_access'), 403);
        $id = Auth::user()->id;
        $detail = DetailUsers::where('userid', $id)->value('kabupaten_domisili');
        $kabupaten = Kabupaten::where('id_kab', $detail)->first();
        $status_belum = DB::table('status_kpu')->where('id_status', 1)->select('warna_status', 'nama_status')->first();
        $status_terkirim = DB::table('status_kpu')->where('id_status', 2)->select('warna_status', 'nama_status')->first();
        $status_verifikasi = DB::table('status_kpu')->where('id_status', 3)->select('warna_status', 'nama_status')->first();
        $status_tidak_lolos = DB::table('status_kpu')->where('id_status', 4)->select('warna_status', 'nama_status')->first();
        $hasil_perbaikan = DB::table('status_kpu')->where('id_status', 5)->select('warna_status', 'nama_status')->first();

        return view('dpc.member.sdh_transfer', compact('detail', 'status_belum', 'status_terkirim', 'status_verifikasi', 'status_tidak_lolos', 'hasil_perbaikan', 'kabupaten'));
    }
    public function tdk_memenuhi()
    {
        // abort_unless(\Gate::allows('category_access'), 403);
        $id = Auth::user()->id;
        $detail = DetailUsers::where('userid', $id)->value('kabupaten_domisili');
        $kabupaten = Kabupaten::where('id_kab', $detail)->first();
        $status_belum = DB::table('status_kpu')->where('id_status', 1)->select('warna_status', 'nama_status')->first();
        $status_terkirim = DB::table('status_kpu')->where('id_status', 2)->select('warna_status', 'nama_status')->first();
        $status_verifikasi = DB::table('status_kpu')->where('id_status', 3)->select('warna_status', 'nama_status')->first();
        $status_tidak_lolos = DB::table('status_kpu')->where('id_status', 4)->select('warna_status', 'nama_status')->first();
        $hasil_perbaikan = DB::table('status_kpu')->where('id_status', 5)->select('warna_status', 'nama_status')->first();



        return view('dpc.member.tdk_memenuhi', compact('detail', 'status_belum', 'status_terkirim', 'status_verifikasi', 'status_tidak_lolos', 'hasil_perbaikan', 'kabupaten'));
    }
    public function hasil_perbaikan()
    {
        // abort_unless(\Gate::allows('category_access'), 403);
        $id = Auth::user()->id;
        $detail = DetailUsers::where('userid', $id)->value('kabupaten_domisili');
        $kabupaten = Kabupaten::where('id_kab', $detail)->first();
        $status_belum = DB::table('status_kpu')->where('id_status', 1)->select('warna_status', 'nama_status')->first();
        $status_terkirim = DB::table('status_kpu')->where('id_status', 2)->select('warna_status', 'nama_status')->first();
        $status_verifikasi = DB::table('status_kpu')->where('id_status', 3)->select('warna_status', 'nama_status')->first();
        $status_tidak_lolos = DB::table('status_kpu')->where('id_status', 4)->select('warna_status', 'nama_status')->first();
        $hasil_perbaikan = DB::table('status_kpu')->where('id_status', 5)->select('warna_status', 'nama_status')->first();



        return view('dpc.member.hasil_perbaikan', compact('detail', 'status_belum', 'status_terkirim', 'status_verifikasi', 'status_tidak_lolos', 'hasil_perbaikan', 'kabupaten'));
    }
    public function getKelurahan(Request $request)
    {
        $data = Kelurahan::groupBy('id_kel')->where('id_kec', $request->val)
            ->get();

        return \Response::json($data);
    }

    public function getKecamatan(Request $request)
    {
        $id = Auth::user()->id;
        $detail = DetailUsers::where('userid', $id)->first();
        $data = Kecamatan::groupBy('id_kec')->where('id_kab', $detail->kabupaten_domisili)
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

    // public function indexVerified()
    // {
    //     // abort_unless(\Gate::allows('member_access'), 403);

    //     $member = User::join('detail_users', 'users.id', '=', 'detail_users.userid')
    //             ->join('role_user', 'users.id', '=', 'role_user.user_id')
    //             ->join('kecamatans', 'detail_users.kecamatan', '=', 'kecamatans.id_kec')
    //             ->join('provinsis', 'detail_users.provinsi', '=', 'provinsis.id_prov')
    //             ->selectRaw('detail_users.userid ,provinsis.zona_waktu as provid ,
    //                     kecamatans.id as kecid ,detail_users.no_member ,
    //                     users.name ,detail_users.nik ,detail_users.no_hp ,
    //                     users.email ,users.created_at ,
    //                     users.is_active ,detail_users.status_korlap')
    //             ->where('role_user.role_id', 3)
    //             ->where('is_verified', 'verified')
    //             ->get();

    //     return view('dpc.member.verified.index', compact('member'));
    // }

    // public function indexPending()
    // {
    //     // abort_unless(\Gate::allows('member_access'), 403);

    //     $member = User::join('detail_users', 'users.id', '=', 'detail_users.userid')
    //             ->join('role_user', 'users.id', '=', 'role_user.user_id')
    //             ->join('kecamatans', 'detail_users.kecamatan', '=', 'kecamatans.id_kec')
    //             ->join('provinsis', 'detail_users.provinsi', '=', 'provinsis.id_prov')
    //             ->selectRaw('detail_users.userid ,provinsis.zona_waktu as provid ,
    //                     kecamatans.id as kecid ,detail_users.no_member ,
    //                     users.name ,detail_users.nik ,detail_users.no_hp ,
    //                     users.email ,users.created_at ,
    //                     users.is_active ,detail_users.status_korlap')
    //             ->where('role_user.role_id', 3)
    //             ->where('is_verified', 'pending')
    //             ->get();

    //     return view('dpc.pending.index', compact('member'));
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {
        $detail = DetailUsers::where('id', $id)->first();

        $file = '/www/wwwroot/siap.partaihanura.or.id/uploads/file/pakta_integritas/' . $detail->pakta_intergritas;

        return response()->file($file);
    }


    public function create()
    {
        // abort_unless(\Gate::allows('member_create'), 403);
        $id = Auth::user()->id;
        $detail = DetailUsers::where('userid', $id)->first();


        $marital = DB::table('status_pernikahans')->where('aktifya', 1)->pluck('nama', 'id');
        $provinsi = Provinsi::where('status', 1)->pluck('name', 'id_prov');
        $pendidikan = DB::table('pendidikans')->where('status', 1)->pluck('nama', 'id');
        $jenis_kelamin = DB::table('jenis_kelamin')->pluck('name', 'id');
        $anggota = DB::table('status_anggota')->where('status', 1)->pluck('name', 'id');
        $kabupaten =  Kabupaten::where('status', 1)->pluck('name', 'id_kab');
        $kecamatan =  Kecamatan::where('status', 1)->where('id_kab', $detail->kabupaten_domisili)->pluck('name', 'id_kec');
        $job = Job::where('status', 1)->orderBy('name', 'asc')->pluck('name', 'id');

        $agama = DB::table('agamas')->where('status', 1)->pluck('nama', 'id');

        return view('dpc.member.create', compact('detail', 'agama', 'jenis_kelamin', 'marital', 'anggota', 'provinsi', 'kabupaten', 'job', 'pendidikan', 'kecamatan'));
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
            $no_member = str_pad($count + 1, 7, "0", STR_PAD_LEFT);

            $check = User::where('email', $request->emailaddress)
                ->select('id')
                ->first();
            $nik = DetailUsers::where('nik', $request->nik)
                ->where('status_kta', 1)
                ->select('id')
                ->first();
            $dpc = \Auth::user()->id;
            $provinsi = DetailUsers::where('userid', $dpc)->value('provinsi_domisili');
            $kabupaten = DetailUsers::where('userid', $dpc)->value('kabupaten_domisili');


            $nik_kabupaten = substr($request->nik,0,4);
            $kabupaten_nik = Kabupaten::where('id_kab', $nik_kabupaten)->first();
         
                  
            if(isset($check->id)) {
                $message['is_error'] = true;
                $message['error_msg'] = "Email Sudah Ada";
            } 
          
           
            if(isset($nik->id)) {
                $message['is_error'] = true;
                $message['error_msg'] = "Nik Sudah Ada";
            }
            // if (isset($kabupaten) != $nik_kabupaten) {
            //     $message['is_error'] = true;
            //     $message['error_msg'] = "Nik Anda Berada di Silahkan Menghubungi DPC  Untuk Melakukan Pendaftaran ";
            // }
            else {

                $files = ['avatar', 'foto_ktp'];

                foreach ($files as $file) {
                    if ($request->file($file)) {
                        $uploadedFile = $request->file($file);
                        $filename = time() . '.' . $uploadedFile->getClientOriginalName();

                        // if ($file == 'avatar') {

                        //     Image::make($uploadedFile)->resize(250, 300)->save('uploads/img/users/' . $filename);
                        // }elseif($file == 'foto_ktp'){
                        //     Image::make($uploadedFile)->resize(500, 400)->save('uploads/img/foto_ktp/' . $filename);
                        // }else{

                        //      $uploadedFile->move('uploads/file/pakta_integritas/', $filename);

                        // }
                        if ($file == 'avatar') {

                            Image::make($uploadedFile)->resize(250, 300)->save('uploads/img/users/' . $filename);
                        } else {

                            Image::make($uploadedFile)->resize(500, 400)->save('uploads/img/foto_ktp/' . $filename);
                        }

                        $files[$file] = $filename;
                    } else {
                        $files[$file] = 'profile.png';
                    }
                }

                // if ($request->file('avatar')) {

                //         $avatar = $request->file('avatar');
                //         $avatar_name = time() . $avatar->getClientOriginalName();
                //         Image::make($uploadedFile)->resize(250, 300)->save('uploads/img/users/' . $filename);
                //     } else {
                //         $avatar_name = 'noimage.jpg';
                //     }
                //     if ($request->file('pakta_intergritas')) {
                //         $pakta = $request->file('pakta_intergritas');
                //         $pakta_name = time() . $pakta->getClientOriginalName();
                //         $pakta->move('uploads/file/pakta_integritas/', $pakta_name);
                //     } else {
                //         $pakta_name = 'pakta_intergritas.pdf';
                //     }
                //     if ($request->file('foto_ktp')) {
                //         $ktp = $request->file('foto_ktp');
                //         $ktp_name = time() . $ktp->getClientOriginalName();
                //       Image::make($uploadedFile)->resize(250, 300)->save('uploads/img/users/' . $filename);
                //     } else {
                //         $ktp_name = 'noimage.jpg';
                //     }

             
                $kecamatan = Kecamatan::where('id_kec', $request->kecamatan)->value('id_kec');
                $kelurahan = Kelurahan::where('id_kel', $request->kelurahan)->value('id_kel');

                $alamat = Kepengurusan::where('id_daerah', $kabupaten)->value('alamat_kantor');


                // $provinsi = Provinsi::where('id_prov',$request->provinsi)->value('id_prov');

                // $kabupaten = Kabupaten::where('id_kab',$request->kabupaten)->value('id_kab');
                $kabup = substr($kabupaten, 2);

                // $kecamatan = Kecamatan::where('id_kec',$request->kecamatan)->value('id_kec');
                $kec = substr($kecamatan, 4);


                // $kelurahan = Kelurahan::where('id_kel',$request->kelurahan)->value('id_kel');
                $kel = substr($kelurahan, 6);


                $noUrutAkhir = DetailUsers::where('kabupaten_domisili', $kabupaten)->count();
                // dd($noUrutAkhir);
                $no_anggota =   $provinsi . '.' . $kabup . '.' . $kec . '.' . $kel . '.' . sprintf("%06s", abs($noUrutAkhir + 1));
                $username =   $provinsi . $kabup . $noUrutAkhir;

                $users = User::create([
                    'name'          => $request->name,
                    'email'         => $request->emailaddress,
                    // 'password'      => $request->password,
                    'created_at'    => date('Y-m-d H:i:s'),
                    // 'updated_at'    => date('Y-m-d H:i:s'),
                    'is_active'     => 1,
                    'address'       => $request->address,
                    'phone_number'       => $request->no_hp,
                    'image'         => $files['avatar'],
                    'id_settings' => 1,

                ]);


                $roles = \DB::table('model_has_roles')
                    ->insert([
                        'model_type' => 'App\User',
                        'role_id' => 4,
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
                    'activation_code'   => Str::random(40) . $request->input('email'),
                    'avatar'            => $files['avatar'],
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
    public function show($id)
    {
        // abort_unless(\Gate::allows('member_edit'), 403);

        $member = User::leftJoin('detail_users', 'users.id', '=', 'detail_users.userid')
        ->select('detail_users.*','users.image','users.created_at as pengesahan')
        ->where('detail_users.id', $id)->first();
        // dd($member);
        $created_by = DetailUsers::where('userid', $member->created_by)->value('nickname');
    
  
        $detail = DetailUsers::join('model_has_roles', 'detail_users.userid', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('detail_users.id', $id)
    
            ->first();
           



        return view('dpc.member.show', compact('member', 'detail','created_by'));
    }

    public function cetak($id)
    {



        $details = DetailUsers::where('id', $id)->first();
        $member = User::where('id', $details->userid)->first();


        $ketua = Kepengurusan::where('id_daerah', $details->kabupaten_domisili)->where('jabatan', 3001)->first();
        $sekre = Kepengurusan::where('id_daerah', $details->kabupaten_domisili)->where('jabatan', 3002)->first();
        $kantor = Kantor::where('id_daerah', $details->kabupaten_domisili)->first();

        $kabupaten = Kabupaten::where('id_kab', $details->kabupaten_domisili)->first();

       $customPaper = array(10, 0, 295, 210);
        $pdf = PDF::loadview('dpc.member.cetak', ['details' => $details, 'kantor' => $kantor, 'member' => $member, 'ketua' => $ketua, 'member' => $member, 'sekre' => $sekre, 'kabupaten' => $kabupaten])->setPaper($customPaper, 'portrait');
        $filename = 'Kta_';
        return $pdf->stream($filename .  ucwords(strtolower($details->nickname)) . ".pdf");
    }
    
    public function cetak_background($id)
    {



        $details = DetailUsers::where('id', $id)->first();
        $member = User::where('id', $details->userid)->first();


        $ketua = Kepengurusan::where('id_daerah', $details->kabupaten_domisili)->where('jabatan', 3001)->first();
        $sekre = Kepengurusan::where('id_daerah', $details->kabupaten_domisili)->where('jabatan', 3002)->first();
        $kantor = Kantor::where('id_daerah', $details->kabupaten_domisili)->first();

        $kabupaten = Kabupaten::where('id_kab', $details->kabupaten_domisili)->first();

        $customPaper = array(1, 0, 242, 152);
        $pdf = PDF::loadview('dpc.member.cetak_background', ['details' => $details, 'kantor' => $kantor, 'member' => $member, 'ketua' => $ketua, 'member' => $member, 'sekre' => $sekre, 'kabupaten' => $kabupaten])->setPaper($customPaper, 'portrait');
        $filename = 'Kta_';
        return $pdf->stream($filename .  ucwords(strtolower($details->nickname)) . ".pdf");
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
        $pendidikan = DB::table('pendidikans')->where('status', 1)->pluck('nama', 'id');
        $jenis_kelamin = DB::table('jenis_kelamin')->pluck('name', 'id');
        $anggota = DB::table('status_anggota')->where('status', 1)->pluck('name', 'id');
        $kabupaten =  Kabupaten::where('status', 1)->pluck('name', 'id_kab');
        $kecamatan =  Kecamatan::where('status', 1)->where('id_kab', $member->kabupaten_domisili)->pluck('name', 'id_kec');
        $kelurahan =  Kelurahan::where('status', 1)->where('id_kec', $member->kecamatan_domisili)->pluck('name', 'id_kel');

        $job = Job::where('status', 1)->orderBy('name', 'asc')->pluck('name', 'id');
        $agama = DB::table('agamas')->where('status', 1)->pluck('nama', 'id');

        return view('dpc.member.edit', compact('kecamatan', 'kelurahan', 'member', 'detail', 'agama', 'jenis_kelamin', 'marital', 'anggota', 'provinsi', 'kabupaten', 'job', 'pendidikan'));
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

            'avatar'    => 'max:10048',
            'foto_ktp'  => 'max:10048',
            // 'pakta_intergritas'  => 'max:2048',

        ]);

        $member = DetailUsers::where('id', $id)->first();
        $detail = User::where('id', $member->userid)->first();
        // $avatarlama = '/www/wwwroot/siap.partaihanura.or.id/uploads/img/users/' . $member->avatar;
        $fotolama = '/www/wwwroot/siap.partaihanura.or.id/uploads/img/foto_ktp/' . $member->foto_ktp;
        // $paktalama = '/www/wwwroot/hanura.net/uploads/file/pakta_integritas/' . $member->pakta_intergritas;

        \DB::beginTransaction();


        $message['is_error'] = true;
        $message['error_msg'] = "";
        $waktu = $request->tgl_lahir;
        $dob = Carbon::parse($waktu)->format('Y-m-d');
        $count = DetailUsers::count();
        $no_member = str_pad($count + 1, 7, "0", STR_PAD_LEFT);

        $check = User::where('email', $request->emailaddress)
            ->select('id')
            ->first();

        $files = ['avatar', 'foto_ktp'];

        foreach ($files as $file) {
            if ($request->file($file)) {
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
                } else {
                     File::delete($fotolama);
                    Image::make($uploadedFile)->resize(500, 400)->save('uploads/img/foto_ktp/' . $filename);
                }

                $files[$file] = $filename;
            } else {
                $oldFile = $file . '_lama';

                if ($request->input($oldFile) !== 'profile.png' && $request->input($oldFile) !== '') {
                    $files[$file] = $request->input($oldFile);
                } else {
                    $files[$file] = 'profile.png';
                }
            }
        }


        $dpc = \Auth::user()->id;



        if ($request->provinsi == $member->provinsi_domisili && $request->kabupaten == $member->kabupaten_domisili && $request->kecamatan == $member->kecamatan_domisili && $request->kelurahan == $member->kelurahan_domisili) {
            $no_anggota = $member->no_member;
        } else {

            $provinsi = DetailUsers::where('userid', $dpc)->value('provinsi_domisili');
            $kabupaten = DetailUsers::where('userid', $dpc)->value('kabupaten_domisili');

            $kecamatan = Kecamatan::where('id_kec', $request->kecamatan)->value('id_kec');
            $kelurahan = Kelurahan::where('id_kel', $request->kelurahan)->value('id_kel');
            $kabup = substr($kabupaten, 2);
            $kec = substr($kecamatan, 4);
            $kel = substr($kelurahan, 6);

            $noUrutAkhir = DetailUsers::where('kabupaten_domisili', $kabupaten)->count();
            // dd($noUrutAkhir);
            $no_anggota =   $provinsi . '.' . $kabup . '.' . $kec . '.' . $kel . '.' . sprintf("%06s", abs($noUrutAkhir));
            // $username =   $provinsi .$kabup .$noUrutAkhir  ;
        }




        $user = array(
            'name'          => $request->name,
            'email'         => $request->emailaddress,
            // 'password'      => $request->password,
            'updated_at'    => date('Y-m-d H:i:s'),
            'is_active'     => 1,
            'address'       => $request->address,
            'phone_number'       => $request->no_hp,
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
            'activation_code'   => Str::random(40) . $request->input('email'),
            'avatar'            => $files['avatar'],
            'foto_ktp'          => $files['foto_ktp'],
            'kta_generated_at'  =>  null,
            // 'pakta_intergritas'  => $files['pakta_intergritas'],
            'created_at' =>$request->created_at,
            'updated_at'        => date('Y-m-d H:i:s')
        );
        
        // dd($user);
        // dd($users);
        User::where('id', $member->userid)->update($user);
        DetailUsers::where('id', $id)->update($users);
        \DB::commit();
        return redirect()->route('dpc.kabupaten.index')->with('success', 'Data berhasil diupdate');
    }
    public function export($id)
    {
          $kabupaten = Kabupaten::where('id_kab', $id)->first();
        $exporter = app()->makeWith(DPCExport::class, compact('id'));


        return $exporter->download($kabupaten->name .'.xlsx');
    }
    public function kabupatenall_export($id)
    {
        $kabupaten = Kabupaten::where('id_kab', $id)->first();
        $exporter = app()->makeWith(KabupatenAllExport::class, compact('id'));


        return $exporter->download('Laporan Anggota ' . $kabupaten->name . '.xlsx');
    }
    public function showMember(Request $request)
    {
        $data = [];
        $ids = null;
        if ($request->id) {
            if (is_array($request->id)) {
                $ids = $request->id;
            } else {
                $ids = explode(',', $request->id);
            }
        }
        
        $detail = DetailUsers::join('users', 'detail_users.userid', '=', 'users.id')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->whereIn('detail_users.id', ($request->ids) ? $request->ids : $ids)
            //   ->where('users.username','=','')
            // ->where('detail_users.status_kta', 1)
            // ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
            // ->where('detail_users.status_kpu', 2)
            ->select('detail_users.*', 'users.image')
            ->groupBy('detail_users.nik')
            ->orderBy('detail_users.kelurahan_domisili','asc')
            ->limit(10)
            ->get();

      


         
        $data['det'] = DetailUsers::join('model_has_roles', 'detail_users.userid', '=', 'model_has_roles.model_id')
            ->whereIn('detail_users.id', ($request->ids) ? $request->ids : $ids)
            //  ->where('detail_users.kabupaten_domisili', $id)
            //  ->where('detail_users.status_kta',1)
            //   ->whereBetween('model_has_roles.role_id',array(4,5))
            //  ->where('detail_users.status_kpu',2)
            ->orderBy('detail_users.kelurahan_domisili', 'asc')
            ->groupBy('detail_users.id')
            ->first();

        $ketua = Kepengurusan::where('id_daerah', $data['det']->kabupaten_domisili)->where('jabatan', 3001)->first();
        $sekre = Kepengurusan::where('id_daerah', $data['det']->kabupaten_domisili)->where('jabatan', 3002)->first();
        $kantor = Kantor::where('id_daerah', $data['det']->kabupaten_domisili)->first();
        $kabupaten = Kabupaten::where('id_kab', $data['det']->kabupaten_domisili)->first();
        $customPaper = array(0, 0, 566.929 , 999.800);
        // $customPaper = array(0, 0, 609.4488, 935.433);
        $pdf = PDF::loadview('dpp.kabupaten.show', ['detail' => $detail, 'ketua' => $ketua, 'sekre' => $sekre, 'kabupaten' => $kabupaten, 'kantor' => $kantor])->setPaper($customPaper, 'portrait');


        $filename = 'Kta_ktp';
        return $pdf->stream($filename .  ucwords(strtolower($kabupaten->name)) . ".pdf");



        // return view('dpp.kabupaten.show', compact('kabupaten','detail','ketua','sekre'));
    }
    public function surat_pernyataan($id)
    {

        $details = DetailUsers::join('users','detail_users.userid','=','users.id')
            ->join('model_has_roles', 'detail_users.userid', '=', 'model_has_roles.model_id')
            ->where('detail_users.id', $id)
            ->where('detail_users.status_kta', 1)
            //  ->where('model_has_roles.role_id',4)
            //  ->where('detail_users.status_kpu',2)
            ->select('detail_users.*','users.image')
            ->orderBy('detail_users.kelurahan_domisili', 'asc')
            ->groupBy(['detail_users.no_member', 'detail_users.nik'])
            ->first();

        $ketua = Kepengurusan::where('id_daerah', $details->kabupaten_domisili)->where('jabatan', 3001)->first();
        $sekre = Kepengurusan::where('id_daerah',  $details->kabupaten_domisili)->where('jabatan', 3002)->first();
        $kantor = Kantor::where('id_daerah',  $details->kabupaten_domisili)->first();

        $kabupaten = Kabupaten::where('id_kab', $details->kabupaten_domisili)->first();
        $pdf = PDF::loadview('dpc.kabupaten.show', ['kantor' => $kantor, 'details' => $details, 'ketua' => $ketua, 'sekre' => $sekre, 'kabupaten' => $kabupaten])->setPaper('A4', 'portrait');
        $filename = 'surat_pernyataan';
        return $pdf->stream($filename .  ucwords(strtolower($kabupaten->name)) . ".pdf");


        // return view('dpp.kabupaten.show', compact('kabupaten','detail','ketua','sekre'));
    }
    public function showkta($id)
    {
        
        ini_set("memory_limit","850M");
        set_time_limit('120');
        $detail = DetailUsers::join('users', 'detail_users.userid', '=', 'users.id')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->where('detail_users.kabupaten_domisili', $id)
            //   ->where('users.username','=','')
            ->where('detail_users.status_kta', 1)
            ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
            ->where('detail_users.status_kpu', 2)
            ->groupBy(['detail_users.no_member', 'detail_users.nik'])
            ->limit(20)
            ->get();
        

        $kantor = Kantor::where('id_daerah', $id)->first();

        $ketua = Kepengurusan::where('id_daerah', $id)->where('jabatan', 3001)->first();

        $sekre = Kepengurusan::where('id_daerah', $id)->where('jabatan', 3002)->first();

        // $qrcode =  QrCode::size(60)->generate($details->no_member);

        $kabupaten = Kabupaten::where('id_kab', $id)->first();
        $customPaper = array(0, 0, 595.4488, 925.433);
        $pdf = PDF::loadview('dpp.kabupaten.showkta', ['detail' => $detail, 'ketua' => $ketua, 'sekre' => $sekre, 'kabupaten' => $kabupaten, 'kantor' => $kantor])
         ->setOptions(['enable_php' => true, 'enable_font_subsetting' => true])->setPaper($customPaper, 'portrait');


        $filename = 'Kta_';
        return $pdf->download($filename .  ucwords(strtolower($kabupaten->name)) . ".pdf");

        // return view('dpp.kabupaten.showkta', compact('kabupaten','detail','ketua','sekre'));
    }


    public function export_hp($id)
    {
        $kabupaten = Kabupaten::where('id_kab', $id)->first();
        $exporter = app()->makeWith(DPCExport_hp::class, compact('id'));
        return $exporter->download($kabupaten->name . '_hp.xlsx');
    }
    public function show_hp($id)
    {
        // abort_unless(\Gate::allows('member_edit'), 403);


        $kelurahan = DetailUsers::join('users', 'detail_users.userid', '=', 'users.id')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->where('detail_users.kabupaten_domisili', $id)
            ->where('detail_users.status_kta', 1)
            //  ->where('users.username','=','')
            ->whereIn('detail_users.status_kpu', array(2, 5))
            ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
            ->groupBy(['detail_users.no_member', 'detail_users.nik'])
            ->orderBy('detail_users.kelurahan_domisili', 'asc')
            ->get();




        $kantor = Kantor::where('id_daerah', $id)->first();
        $ketua = Kepengurusan::where('id_daerah', $id)->where('jabatan', 3001)->first();

        $sekre = Kepengurusan::where('id_daerah', $id)->where('jabatan', 3002)->first();



        $kabupaten = Kabupaten::where('id_kab', $id)->first();

        $detail = DetailUsers::join('users', 'detail_users.userid', '=', 'users.id')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->where('detail_users.kabupaten_domisili', $id)
            ->where('detail_users.status_kta', 1)
            //  ->where('users.username','=','')
            ->whereIn('detail_users.status_kpu', array(2, 5))
            ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
            ->groupBy(['detail_users.no_member', 'detail_users.nik'])
            ->orderBy('detail_users.kelurahan_domisili', 'asc')
            ->get();





        $pdf = PDF::loadview('dpp.kabupaten.show_hp', ['detail' => $detail, 'kelurahan' => $kelurahan, 'ketua' => $ketua, 'sekre' => $sekre, 'kabupaten' => $kabupaten, 'kantor' => $kantor])->setPaper('A4', 'portrait');

        $filename = 'Kta_Ktp_Hp_';
        return $pdf->download($filename .  ucwords(strtolower($kabupaten->name)) . ".pdf");


        // return view('dpp.kabupaten.show', compact('kabupaten','detail','ketua','sekre'));
    }
    public function showkta_hp($id)
    {
        $detail = DetailUsers::join('users', 'detail_users.userid', '=', 'users.id')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('kelurahans', 'kelurahans.id_kel', 'detail_users.kelurahan_domisili')
            ->join('kecamatans', 'kecamatans.id_kec', 'detail_users.kecamatan_domisili')
            ->where('detail_users.kabupaten_domisili', $id)
            ->where('detail_users.status_kta', 1)
            ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
            //  ->where('users.username','=','')
            ->whereIn('detail_users.status_kpu', array(5, 2))
            ->select('detail_users.*', 'kelurahans.name AS nama_kelurahan', 'kecamatans.name AS nama_kecamatan', 'users.*')
             ->orderBy('detail_users.kelurahan_domisili', 'asc')
            ->groupBy(['detail_users.no_member', 'detail_users.nik'])
            ->get();




        $kantor = Kantor::where('id_daerah', $id)->first();
        $ketua = Kepengurusan::where('id_daerah', $id)->where('jabatan', 3001)->first();

        $sekre = Kepengurusan::where('id_daerah', $id)->where('jabatan', 3002)->first();

        // $qrcode =  QrCode::size(60)->generate($details->no_member);

        $kabupaten = Kabupaten::where('id_kab', $id)->first();

        $customPaper = array(0, 0, 609.4488, 935.433);
        $pdf = PDF::loadview('dpp.kabupaten.showkta', ['detail' => $detail, 'ketua' => $ketua, 'sekre' => $sekre, 'kabupaten' => $kabupaten, 'kantor' => $kantor])->setPaper($customPaper, 'portrait');


        $filename = 'Kta_Hp';
        return $pdf->download($filename .  ucwords(strtolower($kabupaten->name)) . ".pdf");

        // return view('dpp.kabupaten.showkta', compact('kabupaten','detail','ketua','sekre'));
    }
    public function export_hp_parpol($id)
    {
        $get_kabupaten = Kabupaten::where('id_kab', $id)->first();

        $get_provinsi = Provinsi::where('id_prov', $get_kabupaten->id_prov)->first();
        $kantor = Kantor::where('id_daerah', $id)->first();


        // get detail user from kab

        /*SELECT detail_users.* , kelurahans.name AS nama_kelurahan , kecamatans.name AS nama_kecamatan FROM detail_users
        INNER JOIN kelurahans ON kelurahans.id_kel = detail_users.kelurahan_domisili
        INNER JOIN kecamatans ON kecamatans.id_kec = detail_users.kecamatan_domisili
        WHERE detail_users.kabupaten_domisili LIKE '3175' AND detail_users.status_kta = 1*/


        $get_user = DetailUsers::join('users', 'detail_users.userid', '=', 'users.id')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('kelurahans', 'kelurahans.id_kel', 'detail_users.kelurahan_domisili')
            ->join('kecamatans', 'kecamatans.id_kec', 'detail_users.kecamatan_domisili')
            ->where('detail_users.kabupaten_domisili', $id)
            ->where('detail_users.status_kta', 1)
            ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
            //  ->where('users.username','=','')
            ->whereIn('detail_users.status_kpu', array(5, 2))
            ->select('detail_users.*', 'kelurahans.name AS nama_kelurahan', 'kecamatans.name AS nama_kecamatan')
            ->orderBy('detail_users.kelurahan_domisili', 'asc')
            ->groupBy('detail_users.nik')
            ->get();





        $ketua = DB::table('kepengurusan')
            ->leftJoin('jabatans', 'kepengurusan.jabatan', '=', 'jabatans.kode')
            ->select('kepengurusan.nama as name', 'kepengurusan.kta', 'jabatans.nama', 'jabatans.urutan', 'kepengurusan.nik', 'kepengurusan.foto', 'kepengurusan.ttd')
            ->where('kepengurusan.id_daerah', $id)
            ->where('kepengurusan.jabatan', 3001)
            ->where('kepengurusan.deleted_at', null)
            ->orderBy('jabatans.urutan', 'asc')
            ->groupBy('kepengurusan.id_kepengurusan')
            ->first();
        $sekretaris = DB::table('kepengurusan')
            ->leftJoin('jabatans', 'kepengurusan.jabatan', '=', 'jabatans.kode')
            ->select('kepengurusan.nama as name', 'kepengurusan.kta', 'jabatans.nama', 'jabatans.urutan', 'kepengurusan.nik', 'kepengurusan.foto', 'kepengurusan.ttd')
            ->where('kepengurusan.id_daerah', $id)
            ->where('kepengurusan.jabatan', 3002)
            ->where('kepengurusan.deleted_at', null)
            ->orderBy('jabatans.urutan', 'asc')
            ->groupBy('kepengurusan.id_kepengurusan')
            ->first();

        $pdf = PDF::loadview('dpp.provinsi.export_hp_parpol', ['get_kabupaten' => $get_kabupaten, 'get_provinsi' => $get_provinsi, 'get_user' => $get_user, 'kantor' => $kantor, 'sekretaris' => $sekretaris, 'ketua' => $ketua])->setPaper('A4', 'landscape');
        $filename = 'LAMPIRAN 2 MODEL F2.HP-PARPOL_';
        return $pdf->download($filename .  ucwords(strtolower($get_kabupaten->name)) . ".pdf");


        // return view('dpp.provinsi.export_hp_parpol' , compact('get_kabupaten' , 'get_provinsi' , 'get_user'));

    }
    public function export_parpol($id)
    {
        $get_kabupaten = Kabupaten::where('id_kab', $id)->first();

        $get_provinsi = Provinsi::where('id_prov', $get_kabupaten->id_prov)->first();
        $kantor = Kantor::where('id_daerah', $id)->first();


        $get_user = DetailUsers::join('users', 'detail_users.userid', '=', 'users.id')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('kelurahans', 'kelurahans.id_kel', 'detail_users.kelurahan_domisili')
            ->join('kecamatans', 'kecamatans.id_kec', 'detail_users.kecamatan_domisili')
            ->where('detail_users.kabupaten_domisili', $id)
            ->where('detail_users.status_kta', 1)
            ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
            ->where('detail_users.status_kpu', 2)
            //  ->where('users.username','=','')
            ->select('detail_users.*', 'kelurahans.name AS nama_kelurahan', 'kecamatans.name AS nama_kecamatan')
            ->orderBy('detail_users.kelurahan_domisili', 'asc')
            ->groupBy('detail_users.nik')
            ->get();
     



        $ketua = DB::table('kepengurusan')
            ->leftJoin('jabatans', 'kepengurusan.jabatan', '=', 'jabatans.kode')
            ->select('kepengurusan.nama as name', 'kepengurusan.kta', 'jabatans.nama', 'jabatans.urutan', 'kepengurusan.nik', 'kepengurusan.foto', 'kepengurusan.ttd')
            ->where('kepengurusan.id_daerah', $id)
            ->where('kepengurusan.jabatan', 3001)
            ->where('kepengurusan.deleted_at', null)
            ->orderBy('jabatans.urutan', 'asc')
            ->groupBy('kepengurusan.id_kepengurusan')
            ->first();
        $sekretaris = DB::table('kepengurusan')
            ->leftJoin('jabatans', 'kepengurusan.jabatan', '=', 'jabatans.kode')
            ->select('kepengurusan.nama as name', 'kepengurusan.kta', 'jabatans.nama', 'jabatans.urutan', 'kepengurusan.nik', 'kepengurusan.foto', 'kepengurusan.ttd')
            ->where('kepengurusan.id_daerah', $id)
            ->where('kepengurusan.jabatan', 3002)
            ->where('kepengurusan.deleted_at', null)
            ->orderBy('jabatans.urutan', 'asc')
            ->groupBy('kepengurusan.id_kepengurusan')
            ->first();
        // dd($sekretaris);
        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ])
        ->loadview('dpp.provinsi.export_parpol',['get_kabupaten' => $get_kabupaten, 'get_provinsi' => $get_provinsi, 'kantor' => $kantor, 'get_user' => $get_user, 'sekretaris' => $sekretaris, 'ketua' => $ketua])->setPaper('A4', 'landscape');
        $pdf->getDomPDF()->setHttpContext(
            stream_context_create([
                'ssl' => [
                    'allow_self_signed' => TRUE,
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                ]
            ])
        );

        // // $pdf = PDF::loadview('dpp.provinsi.export_parpol', ['get_kabupaten' => $get_kabupaten, 'get_provinsi' => $get_provinsi, 'kantor' => $kantor, 'get_user' => $get_user, 'sekretaris' => $sekretaris, 'ketua' => $ketua])->setPaper('A4', 'landscape');
        $filename = 'LAMPIRAN 2 MODEL F2 PARPOL_';
        return $pdf->stream($filename .  ucwords(strtolower($get_kabupaten->name)) . ".pdf");

        // return view('dpp.provinsi.export_hp_parpol' , ['get_kabupaten' => $get_kabupaten, 'get_provinsi' => $get_provinsi, 'kantor' => $kantor, 'get_user' => $get_user, 'sekretaris' => $sekretaris, 'ketua' => $ketua]);

    }
    public function lampiran_parpol($id)
    {

        $get_provinsi = Provinsi::where('id_prov', $id)->first();


        $get_user = DB::table('kabupatens')->where('id_prov', $id)->groupBy('id_kab')->get();


        $kantor = Kantor::where('id_daerah', 0)->first();

        $ketua = DB::table('kepengurusan')
            ->leftJoin('jabatans', 'kepengurusan.jabatan', '=', 'jabatans.kode')
            ->select('kepengurusan.nama as name', 'kepengurusan.kta', 'jabatans.nama', 'jabatans.urutan', 'kepengurusan.nik', 'kepengurusan.foto', 'kepengurusan.ttd')
            ->where('kepengurusan.jabatan', 1001)
            ->where('kepengurusan.deleted_at', null)
            ->orderBy('jabatans.urutan', 'asc')
            ->groupBy('kepengurusan.id_kepengurusan')
            ->first();



        $sekretaris = DB::table('kepengurusan')
            ->leftJoin('jabatans', 'kepengurusan.jabatan', '=', 'jabatans.kode')
            ->select('kepengurusan.nama as name', 'kepengurusan.kta', 'jabatans.nama', 'jabatans.urutan', 'kepengurusan.nik', 'kepengurusan.foto', 'kepengurusan.ttd')
            ->where('kepengurusan.jabatan', 1101)
            ->where('kepengurusan.deleted_at', null)
            ->orderBy('jabatans.urutan', 'asc')
            ->groupBy('kepengurusan.id_kepengurusan')
            ->first();


        $pdf = PDF::loadview('dpp.provinsi.lampiran_parpol', ['kantor' => $kantor, 'get_provinsi' => $get_provinsi, 'get_user' => $get_user, 'sekretaris' => $sekretaris, 'ketua' => $ketua]);
        $filename = 'LAMPIRAN 1 MODEL F2 PARPOL_';
        return $pdf->stream($filename .  ucwords(strtolower($get_provinsi->name)) . ".pdf");
    }
    public function lampiran_hp_parpol($id)
    {

        $get_provinsi = Provinsi::where('id_prov', $id)->first();


        $get_user = DB::table('kabupatens')->where('id_prov', $id)->groupBy('id_kab')->get();

        $kantor = Kantor::where('id_daerah', 0)->first();


        $ketua = DB::table('kepengurusan')
            ->leftJoin('jabatans', 'kepengurusan.jabatan', '=', 'jabatans.kode')
            ->select('kepengurusan.nama as name', 'kepengurusan.kta', 'jabatans.nama', 'jabatans.urutan', 'kepengurusan.nik', 'kepengurusan.foto', 'kepengurusan.ttd')
            ->where('kepengurusan.jabatan', 1001)
            ->where('kepengurusan.deleted_at', null)
            ->orderBy('jabatans.urutan', 'asc')
            ->groupBy('kepengurusan.id_kepengurusan')
            ->first();


        $sekretaris = DB::table('kepengurusan')
            ->leftJoin('jabatans', 'kepengurusan.jabatan', '=', 'jabatans.kode')
            ->select('kepengurusan.nama as name', 'kepengurusan.kta', 'jabatans.nama', 'jabatans.urutan', 'kepengurusan.nik', 'kepengurusan.foto', 'kepengurusan.ttd')
            > where('kepengurusan.jabatan', 1101)
            ->where('kepengurusan.deleted_at', null)
            ->orderBy('jabatans.urutan', 'asc')
            ->groupBy('kepengurusan.id_kepengurusan')
            ->first();


        $pdf = PDF::loadview('dpp.provinsi.lampiran_hp_parpol', ['kantor' => $kantor, 'get_provinsi' => $get_provinsi, 'get_user' => $get_user, 'sekretaris' => $sekretaris, 'ketua' => $ketua]);

        $filename = 'LAMPIRAN 1 MODEL F2.HP-PARPOL_';
        return $pdf->download($filename .  ucwords(strtolower($get_provinsi->name)) . ".pdf");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function transfer(Request $request)
    {
        $detail = DetailUsers::whereIn('id', $request->ids)->update(array(
            'status_transfer' => 1
        ));


        return redirect()->route('dpc.member.index')->with('success', 'Kategori Informasi Sudah di Update');
    }
    public function destroy($id)
    {

        $detail = DetailUsers::where('id', $id)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'status_kta' => 4
        ]);



        return redirect()->route('dpc.kabupaten.index')->with('success', 'Pembatalan Anggota Sukses DiBuat');
    }
      public function cetak_kartu()
    {
        return view('dpc.member.cetak_kartu');
    }

    public function ajax_cetak_kartu(Request $request)
    {
        $user = DetailUsers::selectRaw("kabupaten_domisili")->where('userid', '=', auth()->user()->id)->first();
        $users = DetailUsers::selectRaw("
                detail_users.id,
                detail_users.no_member,
                users.name,
                detail_users.nik,
                detail_users.gender,
                detail_users.birth_place,
                detail_users.tgl_lahir,
                status_pernikahans.nama,
                jobs.name as nm_pekerjaan,
                detail_users.alamat
            ")
            ->leftJoin('users', 'users.id', '=', 'detail_users.userid')
            ->leftJoin('jobs', 'jobs.id', '=', 'detail_users.pekerjaan')
            ->leftJoin('status_pernikahans', 'status_pernikahans.id', '=', 'detail_users.status_kawin')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('status_kpu', 'detail_users.status_kpu', '=', 'status_kpu.id_status')
            ->where('model_has_roles.role_id', '!=', 8)
            ->where('detail_users.kabupaten_domisili', '=', $user->kabupaten_domisili)
            ->where('detail_users.status_kta', '=', 1)
            ->whereRaw('LENGTH(detail_users.no_member) > 19')
            ->groupBy('detail_users.id');

        return Datatables::of($users)
            ->filterColumn('nm_pekerjaan', function ($query, $keyword) {
                $query->where('jobs.name', '=', $keyword);
            })
            ->filterColumn('nama', function ($query, $keyword) {
                $query->where('status_pernikahans.nama', '=', $keyword);
            })
            ->filterColumn('name', function ($query, $keyword) {
                $query->where('users.name', '=', $keyword);
            })
            ->make(true);
    }
     public function down_docx(Request $request)
    {
        $data = [];
        $ids = null;
        if ($request->id) {
            if (is_array($request->id)) {
                $ids = $request->id;
            } else {
                $ids = explode(',', $request->id);
            }
        }
        
        $detail = DetailUsers::join('users', 'detail_users.userid', '=', 'users.id')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->whereIn('detail_users.id', ($request->ids) ? $request->ids : $ids)
            //   ->where('users.username','=','')
            // ->where('detail_users.status_kta', 1)
            // ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
            // ->where('detail_users.status_kpu', 2)
            ->select('detail_users.*','users.image')
            ->groupBy('detail_users.nik')
            ->limit(10)
            ->orderBy('detail_users.kelurahan_domisili','asc')
            ->get();
            
      


         
        $data['det'] = DetailUsers::join('model_has_roles', 'detail_users.userid', '=', 'model_has_roles.model_id')
            ->whereIn('detail_users.id', ($request->ids) ? $request->ids : $ids)
            //  ->where('detail_users.kabupaten_domisili', $id)
            //  ->where('detail_users.status_kta',1)
            //   ->whereBetween('model_has_roles.role_id',array(4,5))
            //  ->where('detail_users.status_kpu',2)
            ->orderBy('detail_users.kelurahan_domisili', 'asc')
            ->groupBy('detail_users.id')
            ->first();

        $ketua = Kepengurusan::where('id_daerah', $data['det']->kabupaten_domisili)->where('jabatan', 3001)->first();
        $sekre = Kepengurusan::where('id_daerah', $data['det']->kabupaten_domisili)->where('jabatan', 3002)->first();
        $kantor = Kantor::where('id_daerah', $data['det']->kabupaten_domisili)->first();
        $kabupaten = Kabupaten::where('id_kab', $data['det']->kabupaten_domisili)->first();
      $customPaper = array(0, 0, 609.4488 , 935.433);
        // $customPaper = array(0, 0, 609.4488, 935.433);
        $pdf = PDF::loadview('dpp.kabupaten.showkta', ['detail' => $detail, 'ketua' => $ketua, 'sekre' => $sekre, 'kabupaten' => $kabupaten, 'kantor' => $kantor])->setPaper($customPaper, 'portrait');


        $filename = 'Kta_';
        return $pdf->stream($filename .  ucwords(strtolower($kabupaten->name)) . ".pdf");
   
   
      

    }
     public function getKtaDepan(Request $request, $id)
    {
        $settings = DB::table('settings')->where('id',$id)->select('pic_kta_depan')->first();
    //   $customPaper = array(10,0,320,210);
       $customPaper = array(2, 0, 242, 152);
        $pdf = PDF::loadview('dpc.member.kta_depan',['settings'=>$settings])->setPaper($customPaper,'portrait') ;
        
        $filename = 'Kta Depan Partai Hanura';
          return $pdf->stream($filename.".pdf");
   
 
    }
     public function down_coba(Request $request)
    {
        $data = [];
        $ids = null;
        if ($request->id) {
            if (is_array($request->id)) {
                $ids = $request->id;
            } else {
                $ids = explode(',', $request->id);
            }
        }
        
        $detail = DetailUsers::join('users', 'detail_users.userid', '=', 'users.id')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->whereIn('detail_users.id', ($request->ids) ? $request->ids : $ids)
            //   ->where('users.username','=','')
            // ->where('detail_users.status_kta', 1)
            // ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
            // ->where('detail_users.status_kpu', 2)
            ->groupBy('detail_users.nik')
            ->limit(10)
            ->orderBy('detail_users.kelurahan_domisili','asc')
            ->get();
            
      


         
        $data['det'] = DetailUsers::join('model_has_roles', 'detail_users.userid', '=', 'model_has_roles.model_id')
            ->whereIn('detail_users.id', ($request->ids) ? $request->ids : $ids)
            //  ->where('detail_users.kabupaten_domisili', $id)
            //  ->where('detail_users.status_kta',1)
            //   ->whereBetween('model_has_roles.role_id',array(4,5))
            //  ->where('detail_users.status_kpu',2)
            ->orderBy('detail_users.kelurahan_domisili', 'asc')
            ->groupBy('detail_users.id')
            ->first();

        $ketua = Kepengurusan::where('id_daerah', $data['det']->kabupaten_domisili)->where('jabatan', 3001)->first();
        $sekre = Kepengurusan::where('id_daerah', $data['det']->kabupaten_domisili)->where('jabatan', 3002)->first();
        $kantor = Kantor::where('id_daerah', $data['det']->kabupaten_domisili)->first();
        $kabupaten = Kabupaten::where('id_kab', $data['det']->kabupaten_domisili)->first();
        $customPaper = array(0, 0, 609.4488 , 935.433);
        // $customPaper = array(0, 0, 609.4488, 935.433);
        $pdf = PDF::loadview('dpp.kabupaten.coba_kta', ['detail' => $detail, 'ketua' => $ketua, 'sekre' => $sekre, 'kabupaten' => $kabupaten, 'kantor' => $kantor])->setPaper($customPaper, 'portrait');


        $filename = 'Kta_';
        return $pdf->stream($filename .  ucwords(strtolower($kabupaten->name)) . ".pdf");
   
   
      

    }
      public function cetak_kta()
    {
        $id = Auth::user()->id;
        $detail = DetailUsers::where('userid', $id)->value('kabupaten_domisili');
        $kabupaten = Kabupaten::where('id_kab', $detail)->first();
        return view('dpc.member.cetak_kta',compact('kabupaten'));
    }

    public function import_anggota()
    {
        return view('dpc.member.import');
    }
  

    public function edit_import($id)
    {
        $data['anggota'] = AnggotaBU::find($id);
        $data['provinsi'] = Provinsi::where('id_prov', '=', $data['anggota']->provinsi)->first();
        $data['kabupaten'] = Kabupaten::where('id_kab', '=', $data['anggota']->kabupaten)->first();
        $data['kecamatan'] = Kecamatan::where('id_kab', '=', $data['anggota']->kabupaten)->get();
        $data['kelurahan'] = Kelurahan::where('id_kec', '=', $data['anggota']->kecamatan)->get();

        $data['marital'] = MaritalStatus::where('aktifya', '=', 1)->get();
        $data['job'] = Job::where('status', '=', 1)->get();
        $data['agama'] = DB::table('agamas')->where('status', 1)->get();

        return view('dpc.member.import_edit', $data);
    }

    public function save_import(Request $request)
    {
        $anggota = AnggotaBU::find($request->id);
        $files = ['kta', 'ktp'];
        if ($request->hasFile('kta') || $request->hasFile('ktp')) {
            foreach ($files as $file) {
                if ($request->file($file)) {
                    $uploadedFile = $request->file($file);
                    $filename = time() . '.' . $uploadedFile->getClientOriginalName();
                    if ($file == 'kta') {
                        if ($request->kta_custom) {
                            $ext = explode('.', $request->kta_custom);
                            $filename = time() . $ext[count($ext) - 1];
                            copy('/www/wwwroot/siap.partaihanura.or.id/' . $request->kta_custom,  '/www/wwwroot/siap.partaihanura.or.id/uploads/img/users/' . $filename);
                            $files['kta'] = $filename;
                        } else {
                            $uploadedFile->move('uploads/img/users/', $filename);
                        }
                    } else {
                        $uploadedFile->move('uploads/img/foto_ktp/', $filename);
                    }

                    $files[$file] = $filename;
                } else if ($request->kta_custom) {
                    $ext = explode('.', $request->kta_custom);
                    $filename = time() . '.' . $ext[count($ext) - 1];
                    copy('/www/wwwroot/siap.partaihanura.or.id/' . $request->kta_custom,  '/www/wwwroot/siap.partaihanura.or.id/uploads/img/users/' . $filename);
                    $files['kta'] = $filename;
                }
                //  else {
                //     $oldFile = $file . '_lama';

                //     if ($request->input($oldFile) !== 'profile.png' && $request->input($oldFile) !== '') {
                //         $files[$file] = $request->input($oldFile);
                //     } else {
                //         $files[$file] = 'profile.png';
                //     }
                // }
            }
        }


        $anggota->pekerjaan = $request->pekerjaan;
        $anggota->pernikahan = $request->pernikahan;
        $anggota->kecamatan = $request->kecamatan;
        $anggota->kelurahan = $request->kelurahan;
        $anggota->agama = $request->agama;
        $anggota->jk = $request->jk;
        $anggota->foto = array_key_exists('kta', $files) ? $files['kta'] : ((is_null($anggota->foto)) ? null : $anggota->foto);
        $anggota->foto_ktp = array_key_exists('ktp', $files) ? $files['ktp'] : ((is_null($anggota->foto_ktp)) ? null : $anggota->foto_ktp);
        $anggota->save();

        return back();
    }

    public function ajax_import_anggota(Request $request)
    {
        $prov = DetailUsers::select('kabupaten_domisili as kabupaten')->where('userid', '=', auth()->user()->id)->first();

        $data = AnggotaBU::selectRaw("
            ktp,
            anggota.id,
            kode_anggota,
            anggota.nama,
            jk,
            tmp_lhr,
            tgl_lhr,
            status_pernikahans.nama as pernikahan,
            agama,
            handphone,
            jobs.name as pekerjaan,
            alamat,
            kecamatans.name as kec_name,
            kelurahans.name as kel_name,
            foto,
            foto_ktp
        ")
            ->leftJoin('kecamatans', 'kecamatans.id_kec', '=', 'anggota.kecamatan')
            ->leftJoin('kelurahans', 'kelurahans.id_kel', '=', 'anggota.kelurahan')
            ->leftJoin('jobs', 'jobs.id', '=', 'anggota.pekerjaan')
            ->leftJoin('status_pernikahans', 'status_pernikahans.id', '=', 'anggota.pernikahan')
            ->whereNotIn('ktp', function ($query) use ($prov) {
                $query->select('nik')
                    ->from('detail_users')
                    ->where(function ($query) {
                        $query->where('status_kta', '!=', '5');
                        $query->orWhere('status_kta', '=', '1');
                    })
                    ->where('kabupaten_domisili', '=', $prov->kabupaten)
                    ->groupBy('nik');
            })
            ->where('kabupaten', '=', $prov->kabupaten)
            ->where('tahun', '>=', 2021);

        return Datatables::of($data)
            ->addColumn('action', function (AnggotaBU $anggota) {
                $html = '<a href="' . route('dpc.edit.import.anggota', $anggota->id) . '" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i></a>';

                return $html;
            })
            ->filterColumn('kec_name', function ($query, $keyword) {
                $query->where('kecamatans.name', 'LIKE', '%' . $keyword . '%');
            })
            ->filterColumn('kel_name', function ($query, $keyword) {
                $query->where('kelurahans.name', 'LIKE', '%' . $keyword . '%');
            })
            ->make(true);
    }

    public function ajax_add_import_anggota(Request $request)
    {
        try {
            foreach ($request->id as $key => $value) {
                $anggota = AnggotaBU::where('id', $value)->first();
                $count = DetailUsers::selectRaw('COUNT(id) as count')->where('kabupaten_domisili')->first();
                $uname = $anggota->provinsi .
                    $anggota->kabupaten .
                    $anggota->kecamatan .
                    $anggota->kelurahan .
                    ((int) $count->count + 1);
                $kabup = substr($anggota->kabupaten, 2);
                $kec = substr($anggota->kecamatan, 4);
                $kel = substr($anggota->kelurahan, 6);
                $no_anggota =   $anggota->provinsi . '.' . $kabup . '.' . $kec . '.' . $kel . '.' . sprintf("%06s", abs($count->count + 1));
                $username =   $anggota->provinsi . $kabup . ($count->count + 1);


                if (User::where('username', '=', $username)->get()->count() == 0) {

                    \DB::beginTransaction();

                    $user = User::create([
                        'id_settings' => 1,
                        // 'username' => $username,
                        // 'password' => Hash::make('admin'),
                        'super_admin' => 0,
                        'is_active' => 1,
                        'name' => $anggota->nama,
                        'email' => $username . '@partaihanura.or.id',
                        'phone_number' => $anggota->handphone,
                        'address' => $anggota->alamat
                    ]);

                    DetailUsers::create([
                        'status_tms' => 0,
                        'userid' => $user->id,
                        'no_member' => $no_anggota,
                        'nickname' => $anggota->nama,
                        'nik' => $anggota->ktp,
                        'gender' => ($anggota->jk == 'Pria') ? 1 : 2,
                        'birth_place' => $anggota->tmp_lhr,
                        'tgl_lahir' => $anggota->tgl_lhr,
                        'pendidikan' => is_null($anggota->pendidikan) ? 0 : $anggota->pendidikan,
                        'status_kawin' => $anggota->pernikahan,
                        'agama' => $anggota->agama,
                        'pekerjaan' => $anggota->pekerjaan,
                        'alamat' => $anggota->alamat,
                        'alamat_domisili' => $anggota->alamat,
                        'provinsi_domisili' => $anggota->provinsi,
                        'kabupaten_domisili' => $anggota->kabupaten,
                        'kecamatan_domisili' => $anggota->kecamatan,
                        'kelurahan_domisili' => $anggota->kelurahan,
                        'rt_rw' => $anggota->rt . '/' . $anggota->rw,
                        'kode_pos' => $anggota->kode_pos,
                        'activation_code'   => Str::random(40) . $username . '@partaihanura.or.id',
                        'status_kta' => 0,
                        'status_kpu' => 1,
                        'avatar' => $anggota->foto,
                        'foto_ktp' => $anggota->foto_ktp,
                        // 'pakta_integritas' => ''
                    ]);

                    $roles = \DB::table('model_has_roles')
                        ->insert([
                            'model_type' => 'App\User',
                            'role_id' => 4,
                            'model_id' => $user->id
                        ]);
                }
                \DB::commit();
            }

            return response()->json(['status' => true]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
