<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Booking;
use App\Komisi;
use App\Payment;
use App\RincianKomisi;
use App\RincianPembayaran;
use App\Tindakan;
use App\Spr;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;

class CustomerController extends Controller
{
    public function index()
    
    {
        return view('admin.customer.index');
    }

    public function ajax(Request $request)
    {
        if(request()->ajax()){

        
        if (!empty($request->from)) {
            $pembatalans = DB:: table('spr')
            ->leftjoin('unit_rumah','spr.id_unit','=','unit_rumah.id_unit_rumah')
            ->select('spr.tanggal_transaksi','spr.no_transaksi','spr.nama','spr.no_hp','spr.no_ktp','unit_rumah.no','unit_rumah.blok','unit_rumah.type'
            ,'spr.id_transaksi','unit_rumah.type','spr.harga_net')
            ->whereBetween('spr.tanggal_transaksi', array($request->from, $request->to))
            ->orderBy('spr.id_transaksi','desc')->get();
         
        } else {
            $pembatalans = DB:: table('spr')
            ->leftjoin('unit_rumah','spr.id_unit','=','unit_rumah.id_unit_rumah')
            ->select('spr.tanggal_transaksi','spr.no_transaksi','spr.nama','spr.no_hp','spr.no_ktp','unit_rumah.no','unit_rumah.blok','unit_rumah.type'
            ,'spr.id_transaksi','unit_rumah.type','spr.harga_net')
            ->orderBy('spr.id_transaksi','desc')
            ->get();
        }
      

        return datatables()
            ->of($pembatalans)
            ->editColumn('no_transaksi', function ($pembatalan) {
                return $pembatalan->no_transaksi;
            })
            ->editColumn('nama', function ($pembatalan) {
                return $pembatalan->nama;
            })
            ->editColumn('no_ktp', function ($pembatalan) {
                return $pembatalan->no_ktp;
            })
            ->editColumn('no_hp', function ($pembatalan) {
                return $pembatalan->no_hp;
            })
            ->editColumn('unit', function ($pembatalan) {
                return $pembatalan->type;
            })
            ->editColumn('blok', function ($pembatalan) {
                return $pembatalan->blok;
            })
            ->editColumn('no', function ($pembatalan) {
                return $pembatalan->no;
            })
            ->editColumn('harga_net', function ($pembatalan) {
                return $pembatalan->harga_net;
            })
            ->editColumn('tanggal_transaksi', function ($pembatalan) {
                return Carbon::parse($pembatalan->tanggal_transaksi)->format('d/m/Y');
            })
         
           
            ->addIndexColumn()
            ->rawColumns(['no_transaksi'])
            ->make(true);
        }
            
    }

   
}
