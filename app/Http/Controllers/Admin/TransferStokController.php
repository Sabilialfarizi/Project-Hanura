<?php

namespace App\Http\Controllers\Admin;

use App\Barang;
use App\Cabang;
use App\HargaProdukCabang;
use App\Http\Controllers\Controller;
use App\InOut;
use App\TransferStok;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransferStokController extends Controller
{
    public function index()
    {
        if (request('from') && request('to')) {
            $from = Carbon::createFromFormat('d/m/Y', request('from'))->format('Y-m-d H:i:s');
            $to = Carbon::createFromFormat('d/m/Y', request('to'))->format('Y-m-d H:i:s');

            $transfers = TransferStok::groupBy('invoice')->where('asal_id', auth()->user()->cabang_id)->whereBetween('created_at', [$from, $to])->get();
        } else {
            $transfers = TransferStok::groupBy('invoice')->where('asal_id', auth()->user()->cabang_id)->get();
        }

        return view('admin.transfer.index', compact('transfers'));
    }

    public function create()
    {
        $cabangs = Cabang::get();
        return view('admin.transfer.create', compact('cabangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cabang_id' => 'required',
            'barang_id' => 'required',
            'qty' => 'required',
            'invoice' => 'required',
        ]);

        $barang = $request->input('barang_id', []);
        $attr = [];
        $out = [];

        DB::beginTransaction();
        foreach ($barang as $key => $no) {
            $attr[] = [
                'invoice' => $request->invoice,
                'asal_id' => auth()->user()->cabang_id,
                'barang_id' => $no,
                'tujuan_id' => $request->cabang_id,
                'qty' => $request->qty[$key],
                'user_id' => auth()->user()->id,
                'created_at' => $request->tanggal
            ];

            $asal = HargaProdukCabang::where('cabang_id', auth()->user()->cabang_id)->where('barang_id', $no)->first();
            $asalawal = $asal->qty;

            $asal->update(['qty' => $asalawal - $request->qty[$key]]);

            $tujuan = HargaProdukCabang::where('cabang_id', $request->cabang_id)->where('barang_id', $no)->first();
            $awal = $tujuan->qty;

            $tujuan->update(['qty' => $awal + $request->qty[$key]]);

            $out[] = [
                'invoice' => $request->invoice,
                'cabang_id' => $request->cabang_id,
                'barang_id' => $no,
                'out' => $request->qty[$key],
                'last_stok' => $tujuan->qty,
                'user_id' => auth()->user()->id
            ];
        }

        TransferStok::insert($attr);
        InOut::insert($out);

        DB::commit();

        return redirect()->route('admin.transfer.index')->with('success', 'Transfer Stok barang berhasil');
    }

    public function show(TransferStok $transferStok)
    {
        //
    }

    public function edit(TransferStok $transferStok)
    {
        //
    }

    public function update(Request $request, TransferStok $transferStok)
    {
        //
    }

    public function destroy(TransferStok $transfer)
    {
        $transfers = TransferStok::where('invoice', $transfer->invoice)->get();

        DB::beginTransaction();
        foreach ($transfers as $tf) {
            $asal = HargaProdukCabang::where('cabang_id', $tf->asal_id)->where('barang_id', $tf->barang_id)->first();
            $asalawal = $asal->qty;

            $asal->update(['qty' => $asalawal + $tf->qty]);

            $tujuan = HargaProdukCabang::where('cabang_id', $tf->tujuan_id)->where('barang_id', $tf->barang_id)->first();
            $awal = $tujuan->qty;

            $tujuan->update(['qty' => $awal - $tf->qty]);

            InOut::where('invoice', $tf->invoice)->first()->delete();

            $tf->delete();
        }
        DB::commit();

        return redirect()->route('admin.transfer.index')->with('success', 'Transfer Stok barang berhasil dihapus');
    }

    public function WhereProduct(Request $request)
    {
        $data = [];
        $product =  Barang::where('jenis', 'barang')
            // ->where('cabang_id', auth()->user()->cabang_id)
            ->where('nama_barang', 'like', '%' . $request->q . '%')
            ->get();
        foreach ($product as $row) {
            $data[] = ['id' => $row->id, 'text' => $row->nama_barang];
        }

        return response()->json($data);
    }
}
