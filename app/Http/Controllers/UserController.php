<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\DB;
use Auth;
class UserController extends Controller
{
     //
     protected $uploadPath;
     //
     public function __construct()
     {
         // parent::__construct();
         $this->uploadPath = public_path('img/profile');
     }
 
     public function getAuthenticatedUser()
     {
         try {
 
             if ( !$user = JWTAuth::parseToken()->authenticate()) {
                 return response()->json(['user_not_found'], 404);
             }
 
         } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
 
             return response()->json(['token_expired'], $e->getStatusCode());
 
         } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
 
             return response()->json(['token_invalid'], $e->getStatusCode());
 
         } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
 
             return response()->json(['token_absent'], $e->getStatusCode());
 
         }
         $email = Auth::user()->email;
         $user  = DB::table('karyawan')
         ->leftJoin('roles','karyawan.jabatan_id','=','roles.id')
         ->leftJoin('users','karyawan.users_id','=','users.id')
         ->select('karyawan.id','karyawan.nama','karyawan.nik',
         'karyawan.jenis_kelamin as jenis_kelamin',
         'karyawan.tgl_lahir as tgl_lahir',
         'users.email as email',
         'karyawan.telp','roles.key as roles')
         ->where('users.email','=',$email)
         ->first();
         $response = [
             'StatusCode' => 200,
             'message'    => 'Berhasil menampilkan Data',
             'Data'       => $user,
         ];   
         return response()->json(['result' =>$response ]);
     }
 
 
     public function update(Request $req){
         $data     = $this->handleRequest($req);
         $karyawan = mst_karyawan::find($req->karyawanId);
         $oldImage = $karyawan->foto;
         $karyawan->update($data);
 
         if ($oldImage !== $karyawan->foto) {
             $this->removeImage($oldImage);
         } 
 
         $response = [
             'StatusCode' => 200,
             'message'    => 'Berhasil update Data',
             // 'Data'       => $user,
         ]; 
         return response()->json(['result' =>$response ]);
 
     }
 
 
         // Function handle request
         private function handleRequest($req)
         {
             $data = $req->all();
     
             // jika field foto ada
             if ($req->hasFile('foto'))
             {
                 $image       = $req->file('foto');
                 $fileName    = date('YmdHis_').$image->getClientOriginalName();
                 $destination = $this->uploadPath;
                 // simpan foto pada direktori img
                 Image:: make($image)->save($destination . '/' . $fileName);
                 $data['foto'] = $fileName;
             }
             return $data;
         }
 
     // Fungsi untuk mengapus foto yang tersimpan di applikasi
     private function removeImage($image)
     {
         if ( ! empty($image) )
         {
             $imagePath = $this->uploadPath . '/' . $image;
             if ( file_exists($imagePath) ) unlink($imagePath);
         }
     }
 
     public function get_avatar($name)
     {
         $avatar_path = $this->uploadPath . '/' . $name;
     if (file_exists($avatar_path)) {
         $file = file_get_contents($avatar_path);
         return response($file, 200)->header('Content-Type', 'image/jpeg');
         }
     $res['success'] = false;
     $res['message'] = "Avatar not found";
         
         return $res;
     }

      //  for mobile
    public function loginMobile(Request $request)
    {
        $input = $request->only('email', 'password');
        $token = null;

        if (!$token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], 401);
        }

          // Find the user by email
          $user = DB::table('karyawan')
          ->leftJoin('roles','karyawan.jabatan_id','=','roles.id')
          ->leftJoin('users','karyawan.users_id','=','users.id')
          ->select('karyawan.id','karyawan.name','karyawan.nip',
          'karyawan.tgl_lahir as tgl_lahir',
          'users.email as email'
          ,'karyawan.jenis_kelamin as jenis_kelamin','karyawan.telp','roles.key as jabatan')
          ->where('users.email','=',$request->get('email'))
          ->first();

          $response = [
            'StatusCode'    => 200,
            'message'   => 'Login Berhasil',
            'token'      => $token,
            'Data' => $user,
        ];   

        return response()->json(['result' =>$response ]);
    }

     // for mobile

     public function registerMobile(Request $req){
        if (DB::table('users')
        ->where('email', $req->email)
        ->first() !=null) {
            $response=[ 'statusCode'=>500,
            'message' => 'Email Sudah terdaftar',
            ];
            return response()->json(['result'=>$response], 200);
        }
        DB::table('users')->insert([
            'name'     => $req->nama,
            'email'    => $req->email,
            'password' => Hash::make($req->password),
            'is_admin' => $req->role_id
          ]);
       
          DB::table('karyawan')->insert([
            'users_id'      => User::all()->last()->id,
            'nama'          => $req->nama,
            'nik'           => $req->nik,
            'telp'          => $req->telepon,
            'jabatan_id'    => $req->jabatan,
            'jenis_kelamin' => $req->jk,
            'tgl_lahir'     => $req->tglLahir,
          ]);

          
        $response = [
            'StatusCode' => 200,
            'message'    => 'Berhasil register Data',
            // 'Data'       => $user,
        ]; 
        return response()->json(['result' =>$response ]);
    }
}
