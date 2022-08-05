<?php

namespace App\Http\Controllers\Dpc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Provinsi, Kabupaten , DetailUsers, Kelurahan, Kecamatan, Kantor};
use App\ArticleCategory as Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class ShowDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        // abort_unless(\Gate::allows('category_access'), 403);

      $kabupaten = DetailUsers::where('kabupaten_domisili', $id)->where('status_kta', 1)->get();
    //   dd($kabupaten);
        $detail = Kabupaten::where('id_kab', $id)->first();
 
   
        return view('dpc.provinsi.showData', compact('kabupaten','detail'));
    }

 
  
         public function showData($id)
    {
        // abort_unless(\Gate::allows('member_edit'), 403);

         $kabupaten = DetailUsers::where('kabupaten_domisili', $id)->where
         ('status_kta', 1)->get();
         $detail = Kabupaten::where('id_kab', $id)->first();
 
   
        return view('dpc.provinsi.show', compact('kabupaten','detail'));
    }
    
     public function showprovinsi($id)
    {
        // abort_unless(\Gate::allows('member_edit'), 403);

         $provinsi = DetailUsers::where('provinsi_domisili', $id)->where('status_kta', 1)->get();
         $detail = Provinsi::where('id_prov', $id)->first();
 
   
        return view('dpc.provinsi.showprovinsi', compact('provinsi','detail'));
    }
     public function showkabupaten($id)
    {
        // abort_unless(\Gate::allows('member_edit'), 403);

         $kabupaten = DetailUsers::where('kabupaten_domisili', $id)->where('status_kta', 1)->get();
         $detail = Kabupaten::where('id_kab', $id)->first();
 
   
        return view('dpc.kabupaten.showkabupaten', compact('kabupaten','detail'));
    }
     public function showkecamatan($id)
    {
        // abort_unless(\Gate::allows('member_edit'), 403);

        //  $kelurahan = DetailUsers::where('kelurahan_domisili', $id)->where('status_kta', 1)->get();
         $detail = Kabupaten::where('id_kab', $id)->first();
         
         $provinsi = Provinsi::where('id_prov',$detail->id_prov)->first();
        
        

         $kecamatan = Kecamatan::where('id_kab', $id)->get();
 
   
        return view('dpc.provinsi.showkecamatan', compact('kecamatan','detail','provinsi'));
    }
     public function showkelurahan($id)
    {
        // abort_unless(\Gate::allows('member_edit'), 403);

        //  $kelurahan = DetailUsers::where('kelurahan_domisili', $id)->where('status_kta', 1)->get();
         $detail = Kecamatan::where('id_kec', $id)->first();
      
         $kabupaten = Kabupaten::where('id_kab',$detail->id_kab)->first();

           
         $provinsi = Provinsi::where('id_prov',$kabupaten->id_prov)->first();

         $kelurahan = Kelurahan::where('id_kec', $id)->get();
       
        
 
   
        return view('dpc.provinsi.showkelurahan', compact('kelurahan','detail','kabupaten','provinsi'));
    }
    
      public function export_hp_parpol($id)
    {
        $get_kabupaten = Kabupaten::where('id_kab', $id)->first();

        $get_provinsi = Provinsi::where('id_prov' , $get_kabupaten->id_prov)->first();

        // get detail user from kab

        /*SELECT detail_users.* , kelurahans.name AS nama_kelurahan , kecamatans.name AS nama_kecamatan FROM detail_users
        INNER JOIN kelurahans ON kelurahans.id_kel = detail_users.kelurahan_domisili
        INNER JOIN kecamatans ON kecamatans.id_kec = detail_users.kecamatan_domisili
        WHERE detail_users.kabupaten_domisili LIKE '3175' AND detail_users.status_kta = 1*/

        $get_user = DetailUsers::join('kelurahans' , 'kelurahans.id_kel' , 'detail_users.kelurahan_domisili')
        ->join('kecamatans' , 'kecamatans.id_kec' , 'detail_users.kecamatan_domisili')
        ->where('detail_users.kabupaten_domisili' , $id)
        ->where('detail_users.status_kta' , 1)
        ->where('detail_users.status_kpu', 5)
        ->where('detail_users.kelurahan_domisili','asc')
        ->select('detail_users.*' , 'kelurahans.name AS nama_kelurahan' , 'kecamatans.name AS nama_kecamatan')
        ->get();
         $kantor = Kantor::where('id_daerah', $id)->first();
        
        $ketua = DB::table('kepengurusan')
          ->leftJoin('jabatans','kepengurusan.jabatan','=','jabatans.kode')
          ->select('kepengurusan.nama as name','kepengurusan.kta','jabatans.nama','jabatans.urutan','kepengurusan.nik','kepengurusan.foto','kepengurusan.ttd')
          ->where('kepengurusan.id_daerah',$id)
          ->where('kepengurusan.jabatan',3001)
          ->where('kepengurusan.deleted_at',null)
          ->orderBy('jabatans.urutan','asc')
          ->groupBy('kepengurusan.id_kepengurusan')
          ->first();
        $sekretaris = DB::table('kepengurusan')
          ->leftJoin('jabatans','kepengurusan.jabatan','=','jabatans.kode')
          ->select('kepengurusan.nama as name','kepengurusan.kta','jabatans.nama','jabatans.urutan','kepengurusan.nik','kepengurusan.foto','kepengurusan.ttd')
          ->where('kepengurusan.id_daerah',$id)
          ->where('kepengurusan.jabatan',3002)
          ->where('kepengurusan.deleted_at',null)
          ->orderBy('jabatans.urutan','asc')
          ->groupBy('kepengurusan.id_kepengurusan')
          ->first();
       
          $pdf = PDF::loadview('dpc.provinsi.export_hp_parpol',['kantor'=>$kantor,'get_kabupaten'=>$get_kabupaten, 'get_provinsi'=>$get_provinsi,'get_user'=>$get_user,'sekretaris'=>$sekretaris,'ketua'=>$ketua]);
         $filename ='LAMPIRAN 2 MODEL F2.HP-PARPOL_';
          return $pdf->stream($filename.  ucwords(strtolower($get_kabupaten->name)). ".pdf");


        // return view('dpc.provinsi.export_hp_parpol' , compact('get_kabupaten' , 'get_provinsi' , 'get_user'));

    }
     public function export_parpol($id)
    {
        $get_kabupaten = Kabupaten::where('id_kab', $id)->first();

        $get_provinsi = Provinsi::where('id_prov' , $get_kabupaten->id_prov)->first();

        // get detail user from kab

        /*SELECT detail_users.* , kelurahans.name AS nama_kelurahan , kecamatans.name AS nama_kecamatan FROM detail_users
        INNER JOIN kelurahans ON kelurahans.id_kel = detail_users.kelurahan_domisili
        INNER JOIN kecamatans ON kecamatans.id_kec = detail_users.kecamatan_domisili
        WHERE detail_users.kabupaten_domisili LIKE '3175' AND detail_users.status_kta = 1*/

        $get_user = DetailUsers::join('kelurahans' , 'kelurahans.id_kel' , 'detail_users.kelurahan_domisili')
        ->join('kecamatans' , 'kecamatans.id_kec' , 'detail_users.kecamatan_domisili')
        ->where('detail_users.kabupaten_domisili' , $id)
        ->where('detail_users.status_kta' , 1)
        ->where('detail_users.status_kpu', 2)
        ->select('detail_users.*' , 'kelurahans.name AS nama_kelurahan' , 'kecamatans.name AS nama_kecamatan')
       ->where('detail_users.kelurahan_domisili','asc')
        ->get();
        $kantor = Kantor::where('id_daerah', $id)->first();
        
        $ketua = DB::table('kepengurusan')
          ->leftJoin('jabatans','kepengurusan.jabatan','=','jabatans.kode')
          ->select('kepengurusan.nama as name','kepengurusan.kta','jabatans.nama','jabatans.urutan','kepengurusan.nik','kepengurusan.foto','kepengurusan.ttd')
          ->where('kepengurusan.id_daerah',$id)
          ->where('kepengurusan.jabatan',3001)
          ->where('kepengurusan.deleted_at',null)
          ->orderBy('jabatans.urutan','asc')
          ->groupBy('kepengurusan.id_kepengurusan')
          ->first();
        $sekretaris = DB::table('kepengurusan')
          ->leftJoin('jabatans','kepengurusan.jabatan','=','jabatans.kode')
          ->select('kepengurusan.nama as name','kepengurusan.kta','jabatans.nama','jabatans.urutan','kepengurusan.nik','kepengurusan.foto','kepengurusan.ttd')
          ->where('kepengurusan.id_daerah',$id)
          ->where('kepengurusan.jabatan',3002)
          ->where('kepengurusan.deleted_at',null)
          ->orderBy('jabatans.urutan','asc')
          ->groupBy('kepengurusan.id_kepengurusan')
          ->first();
       
          $pdf = PDF::loadview('dpc.provinsi.export_parpol',['kantor'=>$kantor,'get_kabupaten'=>$get_kabupaten, 'get_provinsi'=>$get_provinsi,'get_user'=>$get_user,'sekretaris'=>$sekretaris,'ketua'=>$ketua]);
            $filename ='LAMPIRAN 2 MODEL F2 PARPOL_';
          return $pdf->stream($filename.  ucwords(strtolower($get_kabupaten->name)). ".pdf");

        // return view('dpc.provinsi.export_hp_parpol' , compact('get_kabupaten' , 'get_provinsi' , 'get_user'));

    }
     public function lampiran_parpol($id)
    {

        $get_provinsi = Provinsi::where('id_prov' , $id)->first();
       

        $get_user = DB::table('kabupatens')->where('id_prov', $id)->groupBy('id_kab')->get();
     
        $kantor = Kantor::where('id_daerah', 0)->first();
   
        
        $ketua = DB::table('kepengurusan')
          ->leftJoin('jabatans','kepengurusan.jabatan','=','jabatans.kode')
          ->select('kepengurusan.nama as name','kepengurusan.kta','jabatans.nama','jabatans.urutan','kepengurusan.nik','kepengurusan.foto','kepengurusan.ttd')
          ->where('kepengurusan.jabatan',1001)
          ->where('kepengurusan.deleted_at',null)
          ->orderBy('jabatans.urutan','asc')
          ->groupBy('kepengurusan.id_kepengurusan')
          ->first();
       
       
        $sekretaris = DB::table('kepengurusan')
          ->leftJoin('jabatans','kepengurusan.jabatan','=','jabatans.kode')
          ->select('kepengurusan.nama as name','kepengurusan.kta','jabatans.nama','jabatans.urutan','kepengurusan.nik','kepengurusan.foto','kepengurusan.ttd')
          ->where('kepengurusan.jabatan',1002)
          ->where('kepengurusan.deleted_at',null)
          ->orderBy('jabatans.urutan','asc')
          ->groupBy('kepengurusan.id_kepengurusan')
          ->first();
       
       
          $pdf = PDF::loadview('dpc.provinsi.lampiran_parpol',['kantor'=>$kantor, 'get_provinsi'=>$get_provinsi,'get_user'=>$get_user,'sekretaris'=>$sekretaris,'ketua'=>$ketua]);
         $filename ='LAMPIRAN 1 MODEL F2 PARPOL_';
          return $pdf->stream($filename.  ucwords(strtolower($get_provinsi->name)). ".pdf");



    }
     public function lampiran_hp_parpol($id)
    {

        $get_provinsi = Provinsi::where('id_prov' , $id)->first();
       

        $get_user = DB::table('kabupatens')->where('id_prov', $id)->groupBy('id_kab')->get();
     

   
        
        $ketua = DB::table('kepengurusan')
          ->leftJoin('jabatans','kepengurusan.jabatan','=','jabatans.kode')
          ->select('kepengurusan.nama as name','kepengurusan.kta','jabatans.nama','jabatans.urutan','kepengurusan.nik','kepengurusan.foto','kepengurusan.ttd')
          ->where('kepengurusan.jabatan',1001)
          ->where('kepengurusan.deleted_at',null)
          ->orderBy('jabatans.urutan','asc')
          ->groupBy('kepengurusan.id_kepengurusan')
          ->first();
       
        $kantor = Kantor::where('id_daerah', 0)->first();
        $sekretaris = DB::table('kepengurusan')
          ->leftJoin('jabatans','kepengurusan.jabatan','=','jabatans.kode')
          ->select('kepengurusan.nama as name','kepengurusan.kta','jabatans.nama','jabatans.urutan','kepengurusan.nik','kepengurusan.foto','kepengurusan.ttd')
          ->where('kepengurusan.jabatan',1002)
          ->where('kepengurusan.deleted_at',null)
          ->orderBy('jabatans.urutan','asc')
          ->groupBy('kepengurusan.id_kepengurusan')
          ->first();
       
       
          $pdf = PDF::loadview('dpc.provinsi.lampiran_hp_parpol',[ 'kantor'=>$kantor,'get_provinsi'=>$get_provinsi,'get_user'=>$get_user,'sekretaris'=>$sekretaris,'ketua'=>$ketua]);
       
            $filename ='LAMPIRAN 1 MODEL F2.HP-PARPOL_';
          return $pdf->stream($filename.  ucwords(strtolower($get_provinsi->name)). ".pdf");




    }
    

}
