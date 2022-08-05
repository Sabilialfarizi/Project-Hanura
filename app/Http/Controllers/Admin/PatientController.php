<?php

namespace App\Http\Controllers\Admin;

use App\{Customer, Fisik, GigiPasien, KetOdontogram, Odontogram, RekamMedis, RincianPembayaran, User, SimbolOdontogram};
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatientRequest;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        return view('admin.patient.index');
    }

    public function ajaxPasien()
    {
        $patients = Customer::with('user', 'cabang')->get();

        return datatables()
            ->of($patients)
            ->editColumn('nama', function ($pasien) {
                return '<a href="' . route('admin.pasien.image', $pasien->id) . '">' . $pasien->nama . '</a>';
            })
            ->editColumn('action', function ($pasien) {
                return '<a href="' . route('admin.pasien.odontogram', $pasien->id) . '" class="btn btn-sm mt-1 btn-success mr-1"><i class="fa fa-plus-square"></i></a>' . '<a href="' . route('admin.pasien.edit', $pasien->id) . '" class="btn btn-sm mt-1 btn-info"><i class="fa fa-edit"></i></a>' .  ' <a href="' . route('admin.pasien.history', $pasien->id) . '" class="btn btn-sm mt-1 btn-secondary"><i class="fa fa-money"></i></a>';
            })
            ->editColumn('ttl', function ($pasien) {
                return $pasien->tempat_lahir . ', ' . Carbon::parse($pasien->tgl_lahir)->format('d/m/Y');
            })
            ->editColumn('marketing', function ($pasien) {
                return $pasien->user->name;
            })
            ->editColumn('cabang', function ($pasien) {
                return $pasien->cabang->nama;
            })
            ->addIndexColumn()
            ->rawColumns(['nama', 'action'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.patient.create');
    }

    public function store(StorePatientRequest $request)
    {
        $user = User::find(auth()->user()->id);
        $attr = $request->all();

        $pict = $request->file('pict');
        $pictUrl = $pict->storeAs('images/patients', \Str::random(15) . '.' . $pict->extension());

        $attr['user_id'] = $user->id;
        $attr['cabang_id'] = $user->cabang_id;
        $attr['pict'] = $pictUrl;
        $attr['is_active'] = 1;

        $customer = Customer::create($attr);
        Odontogram::create([
            'customer_id' => $customer->id
        ]);

        GigiPasien::create([
            'customer_id' => $customer->id
        ]);

        KetOdontogram::create([
            'customer_id' => $customer->id
        ]);

        Fisik::create([
            'customer_id' => $customer->id
        ]);

        return redirect()->route('admin.pasien.index')->with('success', 'Patient has been added');
    }

    public function show(Customer $customer)
    {
        //
    }

    public function edit(Customer $pasien)
    {
        return view('admin.patient.edit', compact('pasien'));
    }

    public function update(Request $request, Customer $pasien)
    {
        try {
            if ($request->pict) {
                $attr = $request->except(['_token', '_method']);
                $pict = $request->file('pict');
                \Storage::delete($pasien->pict);
                $pictUrl = $pict->storeAs('images/patients', \Str::random(15) . '.' . $pict->extension());
                $attr['pict'] = $pictUrl;
                $pasien->update($attr);
                return redirect()->route('admin.pasien.index');
            } else {

                $attr = $request->except(['_token', '_method']);
                $pasien->update($attr);
                return redirect()->route('admin.pasien.index')->with('success', 'Pasien has been added');
            }
        } catch (Exception $err) {
            dd($err->getMessage());
        }
    }

    public function destroy(Customer $customer)
    {
        //
    }

    public function odontogram(Customer $customer)
    {
        $ketodonto = KetOdontogram::where('customer_id', $customer->id)->first();
        $riwayat = RekamMedis::with('simbol')->where('customer_id', $customer->id)->get();

        return view('admin.patient.odontogram', compact('customer', 'ketodonto', 'riwayat'));
    }

    public function cekfisik(Customer $customer)
    {
        return view('admin.patient.cekfisik', compact('customer'));
    }

    public function storefisik(Request $request, Customer $customer)
    {
        $customer->fisik()->update($request->except('_token'));
        return redirect()->route('admin.pasien.cekfisik', $customer->id)->with('success', 'Pemeriksaan berhasil');
    }

    public function cetakodontogram(Customer $customer)
    {
        return view('admin.patient.cetakodonto', compact('customer'));
    }

    public function cetakriwayat(Customer $customer)
    {
        $riwayat = RekamMedis::where('customer_id', $customer->id)->get();
        return view('admin.patient.cetakriwayat', compact('customer', 'riwayat'));
    }

    public function simbol($warna)
    {
        $simbol =  SimbolOdontogram::where('warna', $warna)->first();

        return response()->json([
            'warna' => $simbol->warna,
            'nama' => $simbol->nama_simbol,
            'singkatan' => $simbol->singkatan,
        ], 200);
    }

    public function history(Customer $customer)
    {
        $histories = RincianPembayaran::with('booking')->whereHas('booking', function ($booking) use ($customer) {
            return $booking->where('customer_id', $customer->id);
        })->where('is_active', 1)->get();

        return view('admin.patient.history', compact('histories', 'customer'));
    }

    public function image(Customer $customer)
    {
        return view('admin.patient.image', compact('customer'));
    }
}
