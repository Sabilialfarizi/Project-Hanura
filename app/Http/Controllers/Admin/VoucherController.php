<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVoucherRequest;
use App\Http\Requests\UpdateVoucherRequest;
use App\RincianPembayaran;
use App\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VoucherController extends Controller
{
    public function index()
    {
        abort_unless(\Gate::allows('voucher-access'), 403);

        $vouchers = Voucher::get();

        return view('admin.voucher.index', compact('vouchers'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('voucher-create'), 403);

        $voucher = new Voucher();
        return view('admin.voucher.create', compact('voucher'));
    }

    public function store(Request $request)
    {
        abort_unless(\Gate::allows('voucher-create'), 403);
        request()->validate([
            'tgl_mulai' => 'required',
            'tgl_akhir' => 'required',
            'min_transaksi' => 'required',
            'nominal' => 'required',
            'type' => 'required',
            'persentase' => 'required',
        ]);

        $attr = request()->all();

        if (request('random') == 1) {
            for ($i = 1; $i <= request('kuota'); $i++) {
                $attr['kode_voucher'] = strtoupper(Str::random(10));
                $attr['kuota'] = 1;

                Voucher::create($attr);
            }
        } else {
            request()->validate(
                ['kode_voucher' => 'required|unique:vouchers'],
                [
                    'kode_voucher.required' => 'The kode voucher field is required.',
                    'kode_voucher.unique' => 'The kode voucher has already been taken.'
                ]
            );

            $attr['kode_voucher'] = request('kode_voucher');
            $attr['kuota'] = request('kuota');

            Voucher::create($attr);
        }

        return redirect()->route('admin.voucher.index')->with('success', 'Voucher has been added');
    }

    public function show($id)
    {
        $voucher = Voucher::where('kode_voucher', $id)->first();
        return response()->json([
            'voucher' => $voucher
        ], 200);
    }


    public function edit(Voucher $voucher)
    {
        abort_unless(\Gate::allows('voucher-edit'), 403);

        return view('admin.voucher.edit', compact('voucher'));
    }

    public function update(UpdateVoucherRequest $request, Voucher $voucher)
    {
        abort_unless(\Gate::allows('voucher-edit'), 403);

        $voucher->update($request->all());

        return redirect()->route('admin.voucher.index')->with('success', 'Voucher has been updated');
    }

    public function destroy(Voucher $voucher)
    {
        abort_unless(\Gate::allows('voucher-delete'), 403);

        $voucher->delete();

        return redirect()->route('admin.voucher.index')->with('success', 'Voucher has been deleted');
    }
}
