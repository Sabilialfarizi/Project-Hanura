<?php

namespace App\Http\Controllers;

use App\Customer;
use App\GigiPasien;
use App\Odontogram;
use App\RekamMedis;
use App\SimbolOdontogram;
use Illuminate\Http\Request;

class RekamMedisController extends Controller
{
    public function create()
    {
        $pasien = Customer::find(request('pasien'));
        $gigi = request('gigi');
        $kondisi = SimbolOdontogram::get();
        $history = RekamMedis::with('simbol', 'user')->where('customer_id', request('pasien'))->where('no_gigi', $gigi)->get();

        return view('rekam-medis.create', compact('pasien', 'gigi', 'kondisi', 'history'));
    }

    public function store(Request $request)
    {
        $customer = Customer::find($request->input('customer_id'));
        $no_gigi = strtolower('p' . $request->input('no_gigi'));
        $simbol = SimbolOdontogram::find($request->input('kondisi'));
        $gigi       = str_replace('p', '', $no_gigi);
        $gigi = str_replace('c', '', $gigi);
        $kondisi = $simbol->warna;
        $singkatan = $simbol->singkatan;

        if (in_array(request('kondisi'), [4, 6, 7, 8, 15, 17, 18, 19, 20, 21])) {
            $odonto = Odontogram::where('customer_id', $customer->id)->first();
            $gigiPasien = GigiPasien::where('customer_id', $customer->id)->first();

            $sdo1 = ['p' . $gigi . 'c' => $kondisi];
            $sdo2 = ['p' . $gigi . 't' => $kondisi];
            $sdo3 = ['p' . $gigi . 'r' => $kondisi];
            $sdo4 = ['p' . $gigi . 'b' => $kondisi];
            $sdo5 = ['p' . $gigi . 'l' => $kondisi];

            $gigi1 = ['p' . $gigi . 'c' => $singkatan];
            $gigi2 = ['p' . $gigi . 't' => $singkatan];
            $gigi3 = ['p' . $gigi . 'r' => $singkatan];
            $gigi4 = ['p' . $gigi . 'b' => $singkatan];
            $gigi5 = ['p' . $gigi . 'l' => $singkatan];

            $odonto->update($sdo1);
            $odonto->update($sdo2);
            $odonto->update($sdo3);
            $odonto->update($sdo4);
            $odonto->update($sdo5);

            $gigiPasien->update($gigi1);
            $gigiPasien->update($gigi2);
            $gigiPasien->update($gigi3);
            $gigiPasien->update($gigi4);
            $gigiPasien->update($gigi5);

            $data = [
                'customer_id' => $customer->id,
                'user_id' => auth()->user()->id,
                'tanggal' => date('Y-m-d'),
                'no_gigi' => $gigi . "ALL",
                'simbol_id' => $request->input('kondisi'),
                'keterangan' => $request->input('anamnesa'),
                'tindakan' => $request->input('tindakan'),
            ];
        } else {
            $upgigi[$no_gigi] = $simbol->singkatan;
            $customer->gigi()->update($upgigi);

            $odon[$no_gigi] = $simbol->warna;
            $customer->odontogram()->update($odon);

            $data = [
                'customer_id' => $customer->id,
                'user_id' => auth()->user()->id,
                'tanggal' => date('Y-m-d'),
                'no_gigi' => $request->input('no_gigi'),
                'simbol_id' => $request->input('kondisi'),
                'keterangan' => $request->input('anamnesa'),
                'tindakan' => $request->input('tindakan'),
            ];
        }

        RekamMedis::create($data);

        if (auth()->user()->hasRole('super-admin')) {
            return redirect()->route('admin.pasien.odontogram', $customer->id)->with('success', 'Odontogram has been added');
        } else {
            return redirect()->route('dokter.pasien.odontogram', $customer->id)->with('success', 'Odontogram has been added');
        }
    }
}
