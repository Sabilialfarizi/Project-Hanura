<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Auth;
use Illuminate\Support\Str;
use App\User;
use App\DetailUsers;


class MemberApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::join('detail_users', 'users.id', '=', 'detail_users.userid')
                ->join('role_user', 'users.id', '=', 'role_user.user_id')
                ->join('kecamatans', 'detail_users.kecamatan', '=', 'kecamatans.id_kec')
                ->join('provinsis', 'detail_users.provinsi', '=', 'provinsis.id_prov')
                ->selectRaw('detail_users.userid ,provinsis.zona_waktu as provid ,
                        kecamatans.id as kecid ,detail_users.no_member ,
                        users.name ,detail_users.nik ,detail_users.no_hp ,
                        users.email ,users.created_at ,
                        users.is_active ,detail_users.status_korlap')
                ->where('role_user.role_id', 3)
                ->get();

        if(is_null($data)){
            return Response([
                'success'   => true,
                'messages'  => 'Data Not Found',
            ], 404);
        }

        return response([
            'success'   => true,
            'message'   => 'List Semua Member',
            'data'      => $data
        ], 200);
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
            $count = DetailUsers::count();
            $no_member = str_pad($count+1,12,"0",STR_PAD_LEFT);

            $validator = Validator::make($request->all(), [
                'name'              => 'required',
                'emailaddress'      => 'required|email|unique:users,email',
                'password'          => 'required',
                'nickname'          => 'required',
                'no_ktp'            => 'required|numeric',
                'no_kk'             => 'required|numeric',
                'gender'            => 'required',
                'tgl_lahir'         => 'required',
                'birth_place'       => 'required',
                'status_kawin'      => 'required',
                'pekerjaan'         => 'required',
                'no_hp'             => 'required|numeric',
                'alamat'            => 'required',
                'provinsi'          => 'required',
                'kabupaten'         => 'required',
                'kecamatan'         => 'required',
                'kelurahan'         => 'required',
                'alamat_domisili'   => 'required',
                'provinsi_domisili' => 'required',
                'kabupaten_domisili'=> 'required',
                'kecamatan_domisili'=> 'required',
                'kelurahan_domisili'=> 'required',
                'foto_kk'           => 'required|mimes:jpeg,jpg,png,gif|required|max:20000',
                'foto_ktp'          => 'required|mimes:jpeg,jpg,png,gif|required|max:20000',
            ],
            [
                'name.required'             => 'Masukkan nama !',
                'emailaddress.required'     => 'Masukkan email yg Valid !',
                'password.required'         => 'Masukkan password !',
                'nickname.required'         => 'Masukkan nama panggilan !',
                'no_ktp.required'           => 'Masukkan no_ktp / harus nomor !',
                'no_kk.required'            => 'Masukkan no kk / harus nomor !',
                'gender.required'           => 'Masukkan Gender !',
                'tgl_lahir.required'        => 'Masukkan tanggal lahir !',
                'birth_place.required'      => 'Masukkan tempat lahir !',
                'pekerjaan.required'        => 'Masukkan Pekerjaan !',
                'no_hp.required'            => 'Masukkan nomor HP !',
                'foto_ktp.required'         => 'Masukkan nomor HP !',
                'foto_kk.required'          => 'Masukkan nomor HP !',
                'alamat.required'           => 'Masukkan Alamat !',
                'provinsi.required'         => 'Masukkan provinsi !',
                'kabupaten.required'        => 'Masukkan kabupaten !',
                'kecamatan.required'        => 'Masukkan kecamatan !',
                'kelurahan.required'        => 'Masukkan kelurahan !',
                'alamat_domisili.required'  => 'Masukkan alamat domisili !',
                'provinsi_domisili.required'=> 'Masukkan provinsi domisili !',
                'kabupaten_domisili.required'=> 'Masukkan kabupaten domisili !',
                'kecamatan_domisili.required'=> 'Masukkan kecamatan domisili !',
                'kelurahan_domisili.required'=> 'Masukkan kelurahan domisili !',
            ]);
            
            if($validator->fails()) {
                return response()->json([
                    'success'   => false,
                    'message'   => 'silahkan isi kolom yang kosong',
                    'data'      => $validator->errors()
                ], 400);
            } else {
                if ($request->file('avatar')) {
                    $avatar = $request->file('avatar');
                    $avatar_name = time() . $avatar->getClientOriginalName();
                    $avatar->move(public_path() . '/images/avatar/', $avatar_name);
                } else {
                    $kk_name = 'noimage.jpg';
                }
                if ($request->file('foto_kk')) {
                    $kk = $request->file('foto_kk');
                    $kk_name = time() . $kk->getClientOriginalName();
                    $kk->move(public_path() . '/images/kk/', $kk_name);
                } else {
                    $kk_name = 'noimage.jpg';
                }
                if ($request->file('foto_ktp')) {
                    $ktp = $request->file('foto_ktp');
                    $ktp_name = time() . $ktp->getClientOriginalName();
                    $ktp->move(public_path() . '/images/ktp/', $ktp_name);
                } else {
                    $ktp_name = 'noimage.jpg';
                }

                $users = User::create([
                    'name'          => $request->input('name'),
                    'email'         => $request->input('emailaddress'),
                    'password'      => $request->input('password'),
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s'),
                    'theme_color'   => 1,
                    'is_active'     => 1,
                ]);

                $roles = \DB::table('role_user')
                        ->insert([
                            'user_id' => $users->id, 
                            'role_id' => 3
                ]);

                $data = array(
                    'userid'            => $users->id,
                    'no_member'         => $no_member,
                    'nickname'          => $request->input('nickname'),
                    'no_ktp'            => $request->input('no_ktp'),
                    'no_kk'             => $request->input('no_kk'),
                    'gender'            => $request->input('gender'),
                    'tgl_lahir'         => $request->input('tgl_lahir'),
                    'birth_place'       => $request->input('birth_place'),
                    'status_kawin'      => $request->input('status_kawin'),
                    'pekerjaan'         => $request->input('pekerjaan'),
                    'no_hp'             => $request->input('no_hp'),
                    'alamat'            => $request->input('alamat'),
                    'provinsi'          => $request->input('provinsi'),
                    'kabupaten'         => $request->input('kabupaten'),
                    'kecamatan'         => $request->input('kecamatan'),
                    'kelurahan'         => $request->input('kelurahan'),
                    'alamat_domisili'   => $request->input('alamat_domisili'),
                    'provinsi_domisili' => $request->input('provinsi_domisili'),
                    'kabupaten_domisili'=> $request->input('kabupaten_domisili'),
                    'kecamatan_domisili'=> $request->input('kecamatan_domisili'),
                    'kelurahan_domisili'=> $request->input('kelurahan_domisili'),
                    'activation_code'   => Str::random(40).$request->input('email'),
                    'avatar'            => $avatar_name,
                    'foto_ktp'          => $ktp_name,
                    'foto_kk'           => $kk_name,
                    'status_korlap'     => 1,
                    'member'            => date('Y-m-d H:i:s')
                );
                $detail = DetailUsers::insert($data);
                Mail::to($users->email)->send(new VerifyEmail($users));
            }
            \DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data Anggota Berhasil Disimpan!',
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
            \DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Data Anggota Gagal Disimpan!',
            ], 400);
        }
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
