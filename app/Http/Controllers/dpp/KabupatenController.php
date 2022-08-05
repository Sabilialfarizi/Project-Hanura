<?php

namespace App\Http\Controllers\Dpp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Provinsi, Kabupaten , DetailUsers , User , Kepengurusan, Kantor};
use App\Exports\{KabupatenExport,KabupatenExport_hp};
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;
use Illuminate\Support\Facades\DB;

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
        $detail = DetailUsers::orderBy('id','asc')->groupBy('kabupaten_domisili')->get();
        // dd($detail);

        $kabupaten = Kabupaten::orderBy('id', 'asc')->groupBy('name')->get();
  
        return view('dpp.kabupaten.index', compact('kabupaten','detail'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
       
        // abort_unless(\Gate::allows('category_create'), 403);
        $provinsi = Provinsi::where('status', 1)->where('id_prov',$id)->pluck('name', 'id_prov');

        return view('dpp.kabupaten.create', compact('provinsi'));
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
            'id_prov' => 'required',
            'id_kab' => 'required|unique:kabupatens,id_kab',
            'name' => 'required',
            'id_wilayah' => 'required',
        ],
        [
            'id_prov.required' => 'Provinsi tidak boleh kosong',
            'id_kab.required' => 'Kode Kabupaten harus diisi',
            'id_kab.unique' => 'Kode Kabupaten sudah ada',
            'name.required' => 'Nama Kabupaten harus diisi',
            'id_wilayah.required' => 'ID Wilayah harus diisi',
        ]);

         Kabupaten::create([
              'id_prov' => $request->id_prov,
              'id_kab' => $request->id_kab,
              'name' => $request->name,
              'id_wilayah' => $request->id_wilayah,
         ]);
         return redirect("/dpp/provinsi/$request->id_prov")->with('success','Data berhasil dibuat');
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function export($id) 
    {
        $kabupaten = Kabupaten::where('id_kab', $id)->first();
        $exporter = app()->makeWith(KabupatenExport::class, compact('id'));   
        return $exporter->download($kabupaten->name . '.xlsx');
    }
     public function show($id)
    {
        // abort_unless(\Gate::allows('member_edit'), 403);

         $detail = DetailUsers::join('users','detail_users.userid','=','users.id')
         ->join('model_has_roles','detail_users.userid','=','model_has_roles.model_id')
         ->where('detail_users.kabupaten_domisili', $id)
         ->where('detail_users.status_kta',1)
        //  ->where('model_has_roles.role_id',4)
         ->where('detail_users.status_kpu',2)
     
         ->groupBy('detail_users.no_member')
         ->get();
            $kelurahan= DetailUsers::join('users','detail_users.userid','=','users.id')
           ->leftJoin('kelurahans','detail_users.kelurahan_domisili','=','kelurahans.id_kel')
            // ->leftJoin('model_has_roles','users.id','=','model_has_roles.model_id')
            ->where('detail_users.status_kta',1)
            ->where('detail_users.status_kpu','!=',array(1,3,4))
            // ->where('model_has_roles.role_id','=', array(4,5))
            ->where('detail_users.kabupaten_domisili',$id)
            ->select(DB::raw('count(detail_users.kelurahan_domisili) as `data`'),'detail_users.*')
            ->groupBy('detail_users.kelurahan_domisili')
            ->orderBy('data','asc')
            ->get();
             
        $ketua = Kepengurusan::where('id_daerah', $id)->where('jabatan', 3001)->first();
     
        $sekre = Kepengurusan::where('id_daerah', $id)->where('jabatan', 3002)->first();
        
        $kantor = Kantor::where('id_daerah', $id)->first();
    
    
        $kabupaten = Kabupaten::where('id_kab',$id)->first();
         $pdf = PDF::loadview('dpp.kabupaten.show',['kantor'=>$kantor,'detail'=>$detail, 'kelurahan'=>$kelurahan,'ketua'=>$ketua,'sekre'=>$sekre,'kabupaten'=>$kabupaten])->setPaper('A4','portrait') ;

        return $pdf->stream();
  
   
        // return view('dpp.kabupaten.show', compact('kabupaten','detail','ketua','sekre'));
    }
     public function showkta($id)
    {
        

         $detail = DetailUsers::join('users','detail_users.userid','=','users.id')
         ->join('model_has_roles','detail_users.userid','=','model_has_roles.model_id')
         ->where('detail_users.kabupaten_domisili', $id)
         ->where('detail_users.status_kta',1)
        //  ->where('model_has_roles.role_id',4)
         ->where('detail_users.status_kpu',2)
         ->groupBy('detail_users.no_member')
                ->get();
        
        $kantor = Kantor::where('id_daerah', $id)->first();
             
        $ketua = Kepengurusan::where('id_daerah', $id)->where('jabatan', 3001)->first();
     
        $sekre = Kepengurusan::where('id_daerah', $id)->where('jabatan', 3002)->first();
        
        // $qrcode =  QrCode::size(60)->generate($details->no_member);
         
        $kabupaten = Kabupaten::where('id_kab',$id)->first();
        $customPaper = array(0,0,609.4488,935.433);
        $pdf = PDF::loadview('dpp.kabupaten.showkta',['detail'=>$detail, 'ketua'=>$ketua,'sekre'=>$sekre,'kabupaten'=>$kabupaten,'kantor'=>$kantor])->setPaper('A4','portrait') ;


        return $pdf->stream();
   
        // return view('dpp.kabupaten.showkta', compact('kabupaten','detail','ketua','sekre'));
    }
    
    
    public function export_hp($id) 
    {
        $kabupaten = Kabupaten::where('id_kab', $id)->first();
        $exporter = app()->makeWith(KabupatenExport_hp::class, compact('id'));   
        return $exporter->download($kabupaten->name .'_hp.xlsx');
    }
     public function show_hp($id)
    {
       

         $detail = DetailUsers::join('users','detail_users.userid','=','users.id')
         ->join('model_has_roles','detail_users.userid','=','model_has_roles.model_id')
         ->where('detail_users.kabupaten_domisili', $id)
         ->where('detail_users.status_kta',1)
           ->whereIn('detail_users.status_kpu',array(2,5))
        //  ->where('model_has_roles.role_id',4)
         ->groupBy('detail_users.id')
                ->get();
                  $kelurahan= DetailUsers::join('users','detail_users.userid','=','users.id')
           ->leftJoin('kelurahans','detail_users.kelurahan_domisili','=','kelurahans.id_kel')
            // ->leftJoin('model_has_roles','users.id','=','model_has_roles.model_id')
            ->where('detail_users.status_kta',1)
            ->whereIn('detail_users.status_kpu',array(2,5))
            // ->where('model_has_roles.role_id','=', array(4,5))
            ->where('detail_users.kabupaten_domisili',$id)
            ->select(DB::raw('count(detail_users.kelurahan_domisili) as `data`'),'detail_users.*')
            ->groupBy('detail_users.kelurahan_domisili')
            ->orderBy('data','asc')
            ->get();
        
        $kantor = Kantor::where('id_daerah', $id)->first();
        $ketua = Kepengurusan::where('id_daerah', $id)->where('jabatan', 3001)->first();
     
        $sekre = Kepengurusan::where('id_daerah', $id)->where('jabatan', 3002)->first();
     

         
        $kabupaten = Kabupaten::where('id_kab',$id)->first();
         $pdf = PDF::loadview('dpp.kabupaten.show_hp',['detail'=>$detail,'kelurahan'=>$kelurahan, 'ketua'=>$ketua,'sekre'=>$sekre,'kabupaten'=>$kabupaten,'kantor'=>$kantor])->setPaper('A4','portrait') ;

        return $pdf->stream();
  
   
        // return view('dpp.kabupaten.show', compact('kabupaten','detail','ketua','sekre'));
    }
     public function showkta_hp($id)
    {
        

         $detail = DetailUsers::join('users','detail_users.userid','=','users.id')
            ->join('model_has_roles','detail_users.userid','=','model_has_roles.model_id')
         ->where('detail_users.kabupaten_domisili', $id)
         ->where('detail_users.status_kta',1)
          ->whereIn('detail_users.status_kpu',array(2,5))
        //  ->where('model_has_roles.role_id',4)
         ->groupBy('detail_users.no_member')
                ->get();
        
                
          $kantor = Kantor::where('id_daerah', $id)->first();
        $ketua = Kepengurusan::where('id_daerah', $id)->where('jabatan', 3001)->first();
     
        $sekre = Kepengurusan::where('id_daerah', $id)->where('jabatan', 3002)->first();
        
        // $qrcode =  QrCode::size(60)->generate($details->no_member);
         
        $kabupaten = Kabupaten::where('id_kab',$id)->first();
        $customPaper = array(0,0,210,330);
        $customPaper = array(0,0,609.4488,935.433);
        $pdf = PDF::loadview('dpp.kabupaten.showkta',['detail'=>$detail, 'ketua'=>$ketua,'sekre'=>$sekre,'kabupaten'=>$kabupaten,'kantor'=>$kantor])->setPaper($customPaper,'portrait') ;


        return $pdf->stream();
   
        // return view('dpp.kabupaten.showkta', compact('kabupaten','detail','ketua','sekre'));
    }


    /**
     * Show the form for editing the specified resource.
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function edit($id)
    {
        $kabupaten = Kabupaten::find($id);
        $provinsi = Provinsi::where('status', 1)->where('id_prov', $kabupaten->id_prov)->first();

        return view('dpp.kabupaten.edit', compact('kabupaten','provinsi'));
    }
    
    public function update($id, Request $request)
    {
        // $category = Category::find($id);
        // $category->name          = $request->name;
        // $category->updated_by    = \Auth::user()->id;
        // $category->updated_at    = date('Y-m-d H:i:s');
        // $category->update();

        $request->validate([
            'id_prov' => 'required',
            'id_kab' => 'required',
            'name' => 'required',
            'id_wilayah' => 'required',
        ],
        [
            'id_prov.required' => 'Provinsi tidak boleh kosong',
            'id_kab.required' => 'Kode Kabupaten harus diisi',
           
            'name.required' => 'Nama Kabupaten harus diisi',
            'id_wilayah.required' => 'ID Wilayah harus diisi',
        ]);
 
         Kabupaten::find($id)->update([
              'id_prov' => $request->id_prov,
              'id_kab' => $request->id_kab,
              'name' => $request->name,
              'id_wilayah' => $request->id_wilayah,
         ]);

        return redirect("/dpp/provinsi/$request->id_prov")->with('success','Data berhasil dibuat');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // abort_unless(\Gate::allows('category_delete'), 403);
        $id_kab = Kabupaten::where('id', $id)->first();
 
        $kabupaten = Kabupaten::find($id)->delete();
        
       return redirect("/dpp/provinsi/$id_kab->id_prov")->with('success','Data berhasil dibuat');
    }
}