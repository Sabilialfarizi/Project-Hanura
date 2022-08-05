<?php

namespace App\Http\Controllers;

use App\Barang;
use Illuminate\Support\Facades\DB;
use App\Booking;
use App\Customer;
use App\Holidays;
use App\Pengajuan;
use App\Purchase;
use App\Reinburst;
use App\Tindakan;
use App\Spr;
use App\TukarFaktur;
use App\User;
use App\DetailUsers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // $macAddr = substr(exec('getmac'), 0, 17);

        // if (auth()->user()->mac_address == null) {
        //     $user = User::find(auth()->user()->id);
        //     $user->update([
        //         'mac_address' => $macAddr
        //     ]);
        // }

        $macAddr = substr(exec('getmac'), 0, 17);
        // return $macAddr;
        // if (auth()->user()->mac_address != $macAddr) {
        //     Auth::logout();
        //     return redirect('login');
        // }

        $jadwal = [];
        $datang = [];
        $periksa = [];

        // $pasien = Customer::count();
        // $dokter = User::role('dokter')->count();
        // $appointments =  Booking::count();
        // $tindakan =  Tindakan::with('booking')->where('status', 0)->count();

        if (auth()->user()->hasRole('super-admin')) {
            $now = Carbon::now()->format('Y-m-d');
            $customer = Spr::count();
            // $reinburst_pending = Reinburst::where('id_user', auth()->user()->id)->where('status_pembayaran','pending')->get()->count();
             $reinburst_pending = Reinburst::where('id_user', auth()->user()->id)->get()->count();
            $warehouse =  Barang::count();

            return view('dashboard.index', [
                'customer' => $customer,
                'reinburst_pending' => $reinburst_pending,
                'warehouse' => $warehouse,
            ]);
        }

        if (auth()->user()->hasRole('dpp')) {
        
            $kabupatens = DB::table('kabupatens')->groupBy('id_kab')->get()->count();
            $provinsi = DB::table('provinsis')->groupBy('id_prov')->get()->count();
          
        
   
            $newusia = DB::table('detail_users')
            //   ->join('users','detail_users.userid','=','users.id')
            //   ->join('model_has_roles','users.id','=','model_has_roles.model_id')
              ->select(DB::raw('YEAR(CURDATE())-YEAR(detail_users.tgl_lahir) AS usia, count(detail_users.no_member) as jumlah'))
              ->where('detail_users.status_kta',1)
              ->where(DB::raw('LENGTH(detail_users.no_member)'),'>',[18,20])
              ->groupBy('detail_users.nik')
              ->get();
        
            $jumlahusia = [
              '18-24',
              '25-34',
              '35-44',
              '45-54',
              '55-64',
              '>64',
            ];
            $jumlahBerdasarkanUsia = [
              '18-24' => 0,
              '25-34' => 0,
              '35-44' => 0,
              '45-54' => 0,
              '55-64' => 0,
              '>64' => 0,
            ];
    
            foreach($newusia as $u) {
              $uint = intval($u->usia);
              $jumlah = intval($u->jumlah);
               
              if($uint > 18 && $uint <= 24) {
                $jumlahBerdasarkanUsia['18-24'] += $jumlah;
              } else if($uint = 25 && $uint <= 34) {
                  $jumlahBerdasarkanUsia['25-34'] += $jumlah;
              } else if($uint = 35 && $uint <= 44) {
                  $jumlahBerdasarkanUsia['35-44'] += $jumlah;
              } else if($uint = 45 && $uint <= 54) {
                  $jumlahBerdasarkanUsia['45-54'] += $jumlah;
              } else if($uint = 55 && $uint <= 64) {
                  $jumlahBerdasarkanUsia['55-64'] += $jumlah;
              } else if($uint =  64) {
                  $jumlahBerdasarkanUsia['>64'] += $jumlah;
              }
             
            }
            
            // return $jumlahBerdasarkanUsia;
            
      
            $user= DetailUsers::where('detail_users.status_kta',1)
                      ->where(DB::raw('LENGTH(detail_users.no_member)'),'>',[18,20])
                      ->select(DB::raw('count(detail_users.id) as `data`'),  DB::raw('YEAR(detail_users.created_at) year'))
                      ->groupby('year')
                      ->pluck('data');
                      
           
           
            $year=  DetailUsers::where('status_kta',1)
                        ->where(DB::raw('LENGTH(no_member)'),'>',[18,20])
                        ->select(  DB::raw('YEAR(created_at) as `year`'))
                        ->groupby('year')
                        ->orderBy('year','asc')
                        ->pluck('year');

            
            
            $id = auth()->user()->id;
            $detail = DetailUsers:: where('userid', $id)->first();
            
           
     
        
              
            $total_anggota_user = DB::table('detail_users')
                    ->where(DB::raw('LENGTH(detail_users.no_member)'),'>',[18,20])
                    ->where('detail_users.status_kta',1)
                    ->groupBy('detail_users.nik')
                    ->get();
            $dki = $total_anggota_user->where('provinsi_domisili', 31)->count();
                    
            $sumut = $total_anggota_user->where('provinsi_domisili',12)->count();
                    
            $sumbar = $total_anggota_user->where('provinsi_domisili',13)->count();
                    
            $aceh = $total_anggota_user->where('provinsi_domisili',11)->count();
                    
            $riau = $total_anggota_user->where('provinsi_domisili',14)->count();
                    
            $jambi = $total_anggota_user->where('provinsi_domisili',15)->count();
                    
            $sumsel = $total_anggota_user->where('provinsi_domisili',16)->count();
                    
            $bengkulu = $total_anggota_user->where('provinsi_domisili',17)->count();
                    
            $lampung = $total_anggota_user->where('provinsi_domisili',18)->count();
                    
            $kepbangbel =  $total_anggota_user->where('provinsi_domisili',19)->count();
                    
            $kepri =  $total_anggota_user->where('provinsi_domisili',21)->count();
            
            $jabar = $total_anggota_user->where('provinsi_domisili',32)->count();
            
            $jateng = $total_anggota_user->where('provinsi_domisili',33)->count();
            
            $diy = $total_anggota_user->where('provinsi_domisili',34)->count();
            
            $jatim =  $total_anggota_user->where('provinsi_domisili',35)->count();
                    
            $banten =  $total_anggota_user->where('provinsi_domisili',36)->count();
                    
            $bali = $total_anggota_user->where('provinsi_domisili',51)->count();
                    
            $ntb =  $total_anggota_user->where('provinsi_domisili',52)->count();
                    
            $ntt =  $total_anggota_user->where('provinsi_domisili',53)->count();
                    
            $kalbar =  $total_anggota_user->where('provinsi_domisili',61)->count();
                    
            $kalteng = $total_anggota_user->where('provinsi_domisili',62)->count();
                    
            $kalsel =  $total_anggota_user->where('provinsi_domisili',63)->count();
                    
            $kaltim =  $total_anggota_user->where('provinsi_domisili',64)->count();
                    
            $kalut = $total_anggota_user->where('provinsi_domisili',65)->count();
                    
            $sulut = $total_anggota_user->where('provinsi_domisili',71)->count();
                    
            $sulteng = $total_anggota_user->where('provinsi_domisili',72)->count();
                    
            $sulsel = $total_anggota_user->where('provinsi_domisili',73)->count();
                    
            $sulbar =  $total_anggota_user->where('provinsi_domisili',76)->count();
                    
            $sulgar =  $total_anggota_user->where('provinsi_domisili',74)->count();
                    
            $papua =  $total_anggota_user->where('provinsi_domisili',92)->count();
                    
            $papuabar =  $total_anggota_user->where('provinsi_domisili',91)->count();
                    
            $maluku =  $total_anggota_user->where('provinsi_domisili',81)->count();
                    
            $malukuut = $total_anggota_user->where('provinsi_domisili',82)->count();
                    
            $gorontalo =  $total_anggota_user->where('provinsi_domisili',75)->count();
              
              
              $total_anggota =  $total_anggota_user->count();
              
              $total_user = DB::table('detail_users')
                          ->join('users','detail_users.userid','=','users.id')
                          ->where('detail_users.status_kta',1)
                          ->where('users.username','!=','')
                          ->where('users.generated_dpp', 0)
                          ->groupBy('users.id')
                          ->get()
                          ->count();
             
              $anggota = $total_anggota_user->count();
            
              $perempuan = $total_anggota_user->where('gender',2)
                            ->count();
                              
                              
              $laki = $total_anggota_user->where('gender',1)
                      ->count();
              
              $hrd_pending =  DetailUsers::where(DB::raw('LENGTH(detail_users.no_member)'),'>',[18,20])
                              ->groupBy('detail_users.nik')
                              ->where('detail_users.status_kta', 0)
                              ->get()
                              ->count();
             
            return view('dashboard.index', [
               'anggota' => $anggota,
                'total_user' => $total_user,
                'user'=> json_encode($user,JSON_NUMERIC_CHECK),
                'year' =>json_encode($year,JSON_NUMERIC_CHECK),
                'laki' => $laki,
                'jumlahBerdasarkanUsia1'=> json_encode($jumlahBerdasarkanUsia['18-24'], JSON_NUMERIC_CHECK),
                'jumlahBerdasarkanUsia2'=> json_encode($jumlahBerdasarkanUsia['25-34'], JSON_NUMERIC_CHECK),
                'jumlahBerdasarkanUsia3'=> json_encode($jumlahBerdasarkanUsia['35-44'], JSON_NUMERIC_CHECK),
                'jumlahBerdasarkanUsia4'=> json_encode($jumlahBerdasarkanUsia['45-54'], JSON_NUMERIC_CHECK),
                'jumlahBerdasarkanUsia5'=> json_encode($jumlahBerdasarkanUsia['55-64'], JSON_NUMERIC_CHECK),
                'jumlahBerdasarkanUsia6'=> json_encode($jumlahBerdasarkanUsia['>64'], JSON_NUMERIC_CHECK),
                'jumlahusia'=>json_encode($jumlahusia,JSON_NUMERIC_CHECK),
                'kabupatens' => $kabupatens,
                'provinsi' => $provinsi,
                'perempuan' => $perempuan,
                'total_anggota' => $total_anggota,
                'hrd_pending' => $hrd_pending,
                'dki' => $dki,
                'sumut' => $sumut,
                'sumbar' => $sumbar,
                'aceh' => $aceh,
                'riau' => $riau,
                'jambi' => $jambi,
                'sumsel' => $sumsel,
                'bengkulu' => $bengkulu,
                'lampung' => $lampung,
                'kepbangbel' => $kepbangbel,
                'kepri' => $kepri,
                'jabar' => $jabar,
                'jateng' => $jateng,
                'diy' => $diy,
                'jatim' => $jatim,
                'banten' => $banten,
                'bali' => $bali,
                'ntb' => $ntb,
                'ntt' => $ntt,
                'kalbar' => $kalbar,
                'kalteng' => $kalteng,
                'kalsel' => $kalsel,
                'kaltim' => $kaltim,
                'kalut' => $kalut,
                'sulut' => $sulut,
                'sulteng' => $sulteng,
                'sulsel' => $sulsel,
                'sulbar' => $sulbar,
                'sulgar' => $sulgar,
                'papua' => $papua,
                'papuabar' => $papuabar,
                'maluku' => $maluku,
                'malukuut' => $malukuut,
                'gorontalo' => $gorontalo,
               
            ]);
        }
        if (auth()->user()->hasRole('dpd')) {
            // $hrd = User::whereHas('roles', function ($data) {
            //     return $data->where('name', 'hrd');
            // })->where('is_active', 1)->get()->count();
             $id = Auth::user()->id;
             $detail = DB::table('detail_users')->where('userid', $id)->first();
             $kabupatens = DB::table('kabupatens')->groupBy('id_kab')->get()->count();
             $provinsi = DB::table('provinsis')->groupBy('id_prov')->get()->count();
             
             $total_anggota_user = DB::table('detail_users')
                    ->where(DB::raw('LENGTH(detail_users.no_member)'),'>',[18,20])
                    ->where('detail_users.status_kta',1)
                    ->where('detail_users.provinsi_domisili',$detail->provinsi_domisili)
                    ->groupBy('detail_users.nik')
                    ->get();
          
             $perempuan = $total_anggota_user->where('gender',2)->count();
               
             $laki = $total_anggota_user->where('gender',1)->count();
               
             $total_anggota = $total_anggota_user->count();
               
             $total_user = DB::table('users')->leftJoin('detail_users', 'users.id', '=', 'detail_users.userid')
                            ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                            ->leftJoin('kabupatens', 'kabupatens.id_kab', '=', 'detail_users.kabupaten_domisili')
                            ->leftJoin('provinsis', 'provinsis.id_prov', '=', 'detail_users.provinsi_domisili')
                            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
                            ->select('users.super_admin', 'detail_users.id', 'users.username', 'provinsis.name as nama', 'users.name', 'users.email', 'users.phone_number', 'roles.key', 'detail_users.provinsi_domisili', 'detail_users.no_member')
                            ->where('detail_users.status_kta', 1)
                            ->whereIn('model_has_roles.role_id', array(11,4))
                            ->where('users.username', '!=', '')
                            ->where('provinsis.id_prov', $detail->provinsi_domisili)
                            ->orderBy('detail_users.id', 'desc')
                            ->groupBy('detail_users.id')
                            ->get()
                            ->count();
              
             
            
             
                  
           $penguruspusat =  DB::table('kepengurusan')->where('id_daerah', 0)
                             ->leftJoin('jabatans','kepengurusan.jabatan','=','jabatans.kode')
                             ->where('kepengurusan.deleted_at',null)
                             ->select('kepengurusan.nama as name','kepengurusan.kta','jabatans.nama','jabatans.urutan','kepengurusan.nik','kepengurusan.foto','kepengurusan.ttd')
                             ->orderBy('jabatans.urutan','asc')
                             ->whereBetween('kepengurusan.jabatan',array(1001,1201))
                             ->groupBy('kepengurusan.id_kepengurusan')
                             ->get();

            $id = Auth::user()->id;
            $detail = DB::table('detail_users')->where('userid', $id)->first();
            $prov = DB::table('provinsis')->where('id_prov', $detail->provinsi_domisili)->first();
            
           
            return view('dashboard.index', [
                'laki' => $laki,
                'prov' => $prov,
                'total_user'=>$total_user,
                'penguruspusat'=>$penguruspusat,
                'kabupatens' => $kabupatens,
                'provinsi' => $provinsi,
                'perempuan' => $perempuan,
                'total_anggota' => $total_anggota,
          
        
            ]);
        }
        if (auth()->user()->hasRole('dpc')) {
            // $hrd = User::whereHas('roles', function ($data) {
            //     return $data->where('name', 'hrd');
            // })->where('is_active', 1)->get()->count();
            $id = Auth::user()->id;
            $use = DB::table('users')->where('id', $id)->first();
            $detail = DB::table('detail_users')->where('userid', $id)->first();
            $kab = DB::table('kabupatens')->where('id_kab', $detail->kabupaten_domisili)->first();
            $target = DB::table('kantor')->where('id_daerah' , $detail->kabupaten_domisili)->first();
       
            
           $penguruspusat =  DB::table('kepengurusan')->where('id_daerah', 0)
                            ->leftJoin('jabatans','kepengurusan.jabatan','=','jabatans.kode')
                            ->where('kepengurusan.deleted_at',null)
                            ->select('kepengurusan.nama as name','kepengurusan.kta','jabatans.nama','jabatans.urutan','kepengurusan.nik','kepengurusan.foto','kepengurusan.ttd')
                            ->orderBy('jabatans.urutan','asc')
                            ->whereBetween('kepengurusan.jabatan',array(1001,1201))
                            ->groupBy('kepengurusan.id_kepengurusan')
                            ->get();
          
            $kabupatens = DB::table('kabupatens')->groupBy('id_kab')->get()->count();
            $provinsi = DB::table('provinsis')->groupBy('id_prov')->get()->count();
            
            $total_anggota_user = DB::table('detail_users')
                    ->where(DB::raw('LENGTH(detail_users.no_member)'),'>',[18,20])
                    ->where('detail_users.kabupaten_domisili', $detail->kabupaten_domisili)
                    ->where('detail_users.status_kta',1)
                    ->groupBy('detail_users.nik')
                    ->get();
             
              
            $perempuan = $total_anggota_user->where('gender',2)->count();
               
            $laki = $total_anggota_user->where('gender', 1)->count();
               
            $total_anggota = $total_anggota_user->count();
               
 
              
            $total_user = DB::table('detail_users')
                ->join('users','detail_users.userid','=','users.id')
                ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                ->where('detail_users.kabupaten_domisili', $detail->kabupaten_domisili)
                ->where('detail_users.status_kta',1)
                ->whereIn('model_has_roles.role_id',array(4,5))
                ->where('users.username','!=','')
                ->groupBy('detail_users.nik')
                ->get()
                ->count();
             
              
            $hrd_pending = User::join('model_has_roles','users.id','=','model_has_roles.model_id')
                ->join('detail_users','detail_users.userid','=','users.id')
                ->where('detail_users.kabupaten_domisili', $detail->kabupaten_domisili)
                ->where('model_has_roles.role_id', 4)
                ->where('detail_users.status_kta', 0)
                 ->groupBy('detail_users.nik')
                ->get()
                ->count();
              
      
            $prov = DB::table('provinsis')->groupBy('id_prov')->get();
             

           
            return view('dashboard.index', [
                'detail'=>$detail,
                'target' => $target,
                'kab'=>$kab,
                'total_user'=>$total_user,
                'penguruspusat' =>$penguruspusat,
                'laki' => $laki,
                'kabupatens' => $kabupatens,
                'provinsi' => $provinsi,
                'prov' => $prov,
                'perempuan' => $perempuan,
                'total_anggota' => $total_anggota,
                'hrd_pending' => $hrd_pending,
                
        
            ]);
        }
       

        return view('dashboard.index');
    }

    public function profile()
    {
        $profile = User::with('roles')->where('id', auth()->user()->id)->first();
        
        $model = DB::table('model_has_roles')
        ->join('roles','model_has_roles.role_id','=','roles.id')
        ->where('model_has_roles.model_id', auth()->user()->id)
   
        ->first();
       
        
      
        $detail = DetailUsers::where('userid',$profile->id)->first();

   
        return view('dashboard.profile', compact('profile','detail','model'));
    }

    public function edit()
    {
        $profile = User::with('roles')->find(auth()->user()->id);
     
   
        return view('dashboard.edit-profile', compact('profile'));
    }

    public function update(Request $request)
    {
       

        $user = User::find(auth()->user()->id);
     
        $imagelama = '/www/wwwroot/siap.partaihanura.or.id//uploads/img/users/' . $user->image;
        
       
      
        $detail = DB::table('detail_users')->where('userid',$user->id)->first();
    
      

        if (request('password') == null) {
            $attr['password'] = $user->password;
        } else {
            $attr['password'] =  Hash::make(request('password'));
        }
        
        $files = ['image'];

        foreach($files as $file){
            if($request->file($file)){
                $filea= File::delete($imagelama);
        
                $uploadedFile = $request->file($file);
                $filename = time() . '.' . $uploadedFile->getClientOriginalName();
                if ($file == 'image') {
                      
                    Image::make($uploadedFile)->resize(250, 300)->save('uploads/img/users/' . $filename);
                }
                
                $files[$file] = $filename;
            }else{
                $oldFile = $file . '_lama';
                
             
                if($request->input($oldFile) !== 'noname' && $request->input($oldFile) !== ''){
                    $files[$file] = $request->input($oldFile);
                }else{
                    $files[$file] = 'noname';
                }
            }
        }
      
         $detail1 = DB::table('users')->where('id',$user->id)->update([
            'email'          => $request->email,
            'phone_number'          => $request->phone_number,
            'name'        => $request->name,
            'address'   =>$request->address,
            'password' => $attr['password'],
             'image'        =>$files['image']
            ]);
         
         $detail = DB::table('detail_users')->where('userid',$user->id)->update([
            'nickname'          => $request->name,
            'no_hp'          => $request->phone_number,
            'alamat'        => $request->address,
            'alamat_domisili'        => $request->address,
            'avatar'        =>$files['image']
            ]);
           
    

        return back()->with('success', 'Your profile has been updated');
    }
}
