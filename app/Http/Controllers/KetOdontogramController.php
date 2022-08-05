<?php

namespace App\Http\Controllers;

use App\KetOdontogram;
use Illuminate\Http\Request;

class KetOdontogramController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        KetOdontogram::updateOrCreate(
            [
                'customer_id' => $request->input('customer_id')
            ],
            [
                'occlusi' => $request->input('occlusi'),
                't_palatinus' => $request->input('t_palatinus'),
                't_mandibularis' => $request->input('t_mandibularis'),
                'palatum' => $request->input('palatum'),
                'occlusi' => $request->input('occlusi'),
                'diastema' => $request->input('diastema'),
                'anomali' => $request->input('anomali'),
                'ket_occlusi' => $request->input('ket_occlusi'),
                'ket_tp' => $request->input('ket_tp'),
                'ket_tm' => $request->input('ket_tm'),
                'ket_palatum' => $request->input('ket_palatum'),
                'ket_diastema' => $request->input('ket_diastema'),
                'ket_anomali' => $request->input('ket_anomali'),
                'lain' => $request->input('lain'),
            ]
        );


        return redirect()->route('admin.pasien.odontogram', $request->input('customer_id'));
    }

    public function show(KetOdontogram $ketOdontogram)
    {
        //
    }

    public function edit(KetOdontogram $ketOdontogram)
    {
        //
    }

    public function update(Request $request, KetOdontogram $ketOdontogram)
    {
        //
    }

    public function destroy(KetOdontogram $ketOdontogram)
    {
        //
    }
}
