<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBarangRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UpdateBarangRequest;
use Carbon\Carbon;

use App\PembatalanUnit;
use App\Penggajian;
use App\Spr;
use App\UnitRumah;

class PembatalanUnitController extends Controller
{
    public function index()
    {
  
        return view('admin.pembatalans.index');
    }



    public function update($id)
    {
        $post = PembatalanUnit::where('id',$id)->get();
        // dd($post);
        foreach ($post as $pur) {
            $pur->update(['status' => 'Approval']);
            $unit = Spr::select('id_unit')->where('id_transaksi', $pur->spr_id)->get();
            // dd($unit);
            // $unit_rumah = DB::table('unit_rumahs')
            // ->leftJoin('sprs','unit_rumahs.id','=','sprs.id_unit')
            // ->select('unit_rumahs.id','sprs.id_unit')
            // ->where('unit_rumahs.id', $unit)->get();
            $unit_rumah = UnitRumah::whereIn('id_unit_rumah',$unit)->update([

             'status_penjualan' => 'Available']);
            // dd($unit_rumah);
            // $unit_rumah->update([
            //     'status_penjualan' => 'Available']);
        }
        

        return redirect()->route('admin.pembatalans.index')->with('success', 'Status has been updated');
    }

    
    // public function destroy(Barang $product)
    // {
    //     // abort_unless(\Gate::allows('product-delete'), 403);

    //     $product->delete();
    //     return redirect()->route('admin.product.index')->with('success', 'Product has been deleted');
    // }

    public function ajax(Request $request)
    {
        if(request()->ajax()){
            if(!empty($request->from)){

        $pembatalans = DB:: table('pembatalan_unit')
        ->leftjoin('spr','pembatalan_unit.spr_id','=','spr.id')
        ->leftjoin('unit_rumahs','spr.id_unit','=','unit_rumahs.id')
        ->leftjoin('users','spr.id_sales','=','users.id')
        ->whereBetween('pembatalan_unit.tanggal',array($request->from, $request->to))
        ->select('pembatalan_unit.tanggal','spr.no_transaksi','users.name','spr.status_approval','spr.id_sales','pembatalan_unit.no_pembatalan','pembatalan_unit.id','pembatalan_unit.diajukan','unit_rumahs.type','spr.no_transaksi','spr.harga_net','spr.status_dp','spr.status_booking','spr.nama','pembatalan_unit.status')
        ->get();
        // dd($pembatalans);
    }else{
        $pembatalans = DB:: table('pembatalan_unit')
        ->leftjoin('spr','pembatalan_unit.spr_id','=','spr.id')
        ->leftjoin('unit_rumahs','spr.id_unit','=','unit_rumahs.id')
        ->leftjoin('users','spr.id_sales','=','users.id')
        ->select('pembatalan_unit.tanggal','spr.no_transaksi','users.name','spr.status_approval','spr.id_sales','pembatalan_unit.no_pembatalan','pembatalan_unit.id','pembatalan_unit.diajukan','unit_rumahs.type','spr.no_transaksi','spr.harga_net','spr.status_dp','spr.status_booking','spr.nama','pembatalan_unit.status')
        ->get();
        // dd($pembatalans);
        
            }
        return datatables()
            ->of($pembatalans)
            ->editColumn('no_pembatalan', function ($pembatalan) {
                return $pembatalan->no_pembatalan;
            })
            ->editColumn('tanggal', function ($pembatalan) {
                return Carbon::parse($pembatalan->tanggal)->format('d/m/Y');
            })
            ->editColumn('type', function ($pembatalan) {
                return $pembatalan->type;
            })
            ->editColumn('spr', function ($pembatalan) {
                return $pembatalan->no_transaksi;
            })
            ->editColumn('total_beli', function ($pembatalan) {
                return $pembatalan->harga_net;
            })
            ->editColumn('konsumen', function ($pembatalan) {
                return $pembatalan->nama;
            })
            ->editColumn('sales', function ($pembatalan) {
                return $pembatalan->name;
            })
            ->editColumn('booking_fee', function ($pembatalan) {
                return $pembatalan->status_booking;
            })
            ->editColumn('dp', function ($pembatalan) {
                return $pembatalan->status_dp;
            })
            ->editColumn('diajukan', function ($pembatalan) {
                return $pembatalan->diajukan;
            })
            ->editColumn('status', function ($pembatalan) {
                return '<span class="custom-badge status-">' . $pembatalan->status . '</span>';
            })
            ->editColumn('refund', function ($pembatalan) {
                return $pembatalan->status_approval;
            })
            ->editColumn('action', function ($data) {
                
                $tindakan = PembatalanUnit::where('id', $data->id)->where('status', 'Pending')->get();
                if (count($tindakan)==0){
                    return "Not Found";
                 
            }else {
                
                $button = '<a href="' . route('admin.pembatalans.update', $data->id) . '"  class="custom-badge status-green"><i class="fa-solid fa-check-to-slot"></i></a>';
                return $button;
            
             
                } 
            
            })
            ->addIndexColumn()
            ->rawColumns(['no_pembatalan', 'status', 'refund','action'])
            ->make(true);
            // ->addColumn('action', function ($row) {
            //     $html = '<a href="" class="btn btn-xs btn-secondary">Edit</a> ';
            //     $html .= '<button data-rowid="'.$row->id.'" class="btn btn-xs btn-danger">Del</button>';
            //     return $html;
            // })
            
            // ->toJson()
        }
    }
}
