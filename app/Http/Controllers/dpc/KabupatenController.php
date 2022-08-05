<?php

namespace App\Http\Controllers\Dpc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Provinsi, Kabupaten, DetailUsers, Kepengurusan, Kantor};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;


class KabupatenController extends Controller
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
        $status_belum = DB::table('status_kpu')->where('id_status', 1)->select('warna_status','nama_status')->first();
        $status_terkirim = DB::table('status_kpu')->where('id_status', 2)->select('warna_status','nama_status')->first();
        $status_verifikasi = DB::table('status_kpu')->where('id_status', 3)->select('warna_status','nama_status')->first();
        $status_tidak_lolos = DB::table('status_kpu')->where('id_status', 4)->select('warna_status','nama_status')->first();
        $hasil_perbaikan = DB::table('status_kpu')->where('id_status', 5)->select('warna_status','nama_status')->first();
     

  
        return view('dpc.kabupaten.index', compact('detail','status_belum','status_terkirim','status_verifikasi','status_tidak_lolos','hasil_perbaikan','kabupaten'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // abort_unless(\Gate::allows('category_create'), 403);
        
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show( $id)
    {
        
        $kabupaten = DetailUsers::where('kabupaten_domisili', $id)->get();
    
        
        return view('dpc.kabupaten.show', compact('kabupaten'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
      public function updatekpu($id)
    {
        // abort_unless(\Gate::allows('member_edit'), 403);

      
        $detail = DetailUsers::where('id', $id)->update([
            'status_kpu' => 1
            ]);
          


      return redirect()->route('dpc.kabupaten.index')->with('success', 'Kategori Informasi Sudah di Update');
    }
     public function showmember(Request $request)
    {
        // abort_unless(\Gate::allows('member_edit'), 403);
      
        

         $detail = DetailUsers::join('model_has_roles','detail_users.userid','=','model_has_roles.model_id')
         ->where('detail_users.id', $request->ids)
        //  ->where('detail_users.kabupaten_domisili', $id)
        //  ->where('detail_users.status_kta',1)
        //   ->whereBetween('model_has_roles.role_id',array(4,5))
        //  ->where('detail_users.status_kpu',2)
         ->orderBy('detail_users.kelurahan_domisili','asc')
         ->groupBy('detail_users.id')
        ->get();
         $det = DetailUsers::join('model_has_roles','detail_users.userid','=','model_has_roles.model_id')
         ->where('detail_users.id', $request->ids)
        //  ->where('detail_users.kabupaten_domisili', $id)
        //  ->where('detail_users.status_kta',1)
        //   ->whereBetween('model_has_roles.role_id',array(4,5))
        //  ->where('detail_users.status_kpu',2)
         ->orderBy('detail_users.kelurahan_domisili','asc')
         ->groupBy('detail_users.id')
        ->first();
  
      
           
        $ketua = Kepengurusan::where('id_daerah', $det->kabupaten_domisili)->where('jabatan', 3001)->first();
       
 
     
        $sekre = Kepengurusan::where('id_daerah', $det->kabupaten_domisili)->where('jabatan', 3002)->first();
        
        $kantor = Kantor::where('id_daerah', $det->kabupaten_domisili)->first();
    
     
        $kabupaten = Kabupaten::where('id_kab',$det->kabupaten_domisili)->first();
         $pdf = PDF::loadview('dpp.kabupaten.show',['kantor'=>$kantor,'detail'=>$detail, 'ketua'=>$ketua,'sekre'=>$sekre,'kabupaten'=>$kabupaten])->setPaper('A4','portrait') ;
          $filename ='Kta_Ktp_';
       
          return $pdf->stream($filename.  ucwords(strtolower($kabupaten->name)). ".pdf" ,array('Attachment'=>0));
       
  
   
        // return view('dpp.kabupaten.show', compact('kabupaten','detail','ketua','sekre'));
    }
      public function updateditolak($id)
    {
        // abort_unless(\Gate::allows('member_edit'), 403);

      
        $detail = DetailUsers::where('id', $id)->update([
            'status_kpu' => 0
            ]);
          


      return redirect()->route('dpc.kabupaten.index')->with('success', 'Kategori Informasi Sudah di Update');
    }
    
      public function updatestatus(Request $request)
    {

      
        $detail = DetailUsers::whereIn('id', $request->ids)->update(array(
            'status_kpu' => 1,
            'status_tms' => 0
            )); 
      


      return redirect()->route('dpc.kabupaten.index')->with('success', 'Kategori Informasi Sudah di Update');
    }
      public function updatenonaktif(Request $request)
    {
        $detail = DetailUsers::whereIn('id', $request->ids)->update(array(
            'status_kpu' => 2
            ));   
      


      return redirect()->route('dpc.kabupaten.index')->with('success', 'Kategori Informasi Sudah di Update');
    }
      public function updatereceived(Request $request)
    {

      
        $detail = DetailUsers::whereIn('id', $request->ids)->update(array(
            'status_kpu' => 2
            )); 
      


      return redirect()->route('dpc.kabupaten.index')->with('success', 'Kategori Informasi Sudah di Update');
    }
      public function updatehasil(Request $request)
    {

      
        $detail = DetailUsers::whereIn('id', $request->ids)->update(array(
            'status_kpu' => 5
            )); 
      


      return redirect()->route('dpc.kabupaten.index')->with('success', 'Kategori Informasi Sudah di Update');
    }
      public function updatefail(Request $request)
    {
        $detail = DetailUsers::whereIn('id', $request->ids)->update(array(
            'status_kpu' => 4,
            'status_tms' => 1
            ));   
      


      return redirect()->route('dpc.kabupaten.index')->with('success', 'Kategori Informasi Sudah di Update');
    }
    
    
    public function edit($id)
    {
       
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
        $category = Category::find($id);
        $category->name          = $request->name;
        $category->updated_by    = \Auth::user()->id;
        $category->updated_at    = date('Y-m-d H:i:s');
        $category->update();

        return redirect()->route('dpc.kategori.index')->with('success', 'Kategori Informasi Sudah di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    { 
        Category::where('id',$id)->delete();
        return redirect()->route('dpc.kategori.index')->with('success', 'Kategori Informasi Sudah di Delete');
    }
}
