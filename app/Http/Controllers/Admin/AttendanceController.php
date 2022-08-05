<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\{Cabang, Holidays, Jadwal, Ruangan, Shift, User};
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $array = [];
    public function index()
    {
        $user = User::whereHas('roles', function ($e) {
            return $e->where('name', 'dokter');
        })->orWhereHas('roles', function ($qr) {
            return $qr->where('name', 'perawat');
        })->orWhereHas('roles', function ($qr) {
            return $qr->where('name', 'office-boy');
        })->whereHas('jadwal', function ($q) {
            return $q->whereMonth('tanggal', Carbon::now()->format('m'))->whereYear('tanggal', Carbon::now()->format('Y'));
        })->get();
        
        $datetime = Carbon::now();

        $month = $datetime->format('m');
        $year = $datetime->format('Y');
        $day = $datetime->endOfMonth()->format('d');

        return view('admin.attendance.index', [
            'user' => $user,
            'user_mode' => User::latest()->get(),
            'holiday' => Holidays::whereMonth('holiday_date', $datetime->format('m'))->whereYear('holiday_date', $datetime->format('Y'))->get(),
            'cabangs' => Cabang::get(),
            'ruangans' => Ruangan::get(),
            'shift' => Shift::pluck('kode'),
            'month' => $month,
            'year' => $year,
            'day' => $day
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.attendance.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $year = $request->year;
        $month = $request->month;
        $tanggal_akhir = Carbon::now()->endOfMonth()->format('d');
        $holiday = Holidays::whereMonth('holiday_date', $month)->pluck('holiday_date');

        if (isset($request->SF1)) {
            for ($i = 0; $i < count($request->SF1); $i++) {
                if (in_array($request->SF1[$i], $holiday->toArray())) {
                    return back()->with('error', 'Hari Libur');
                }
            }
        }

        if (isset($request->SF2)) {
            for ($i = 0; $i < count($request->SF2); $i++) {
                if (in_array($request->SF2[$i], $holiday->toArray())) {
                    return back()->with('error', 'Hari Libur');
                }
            }
        }

        if (Jadwal::where('user_id', $request->user_id)->whereMonth('tanggal', Carbon::parse($year.'-'.$month)->format('m'))->count() < Carbon::parse($year.'-'.$month)->endOfMonth()->format('d') || Jadwal::where('user_id', '=', $request->user_id)->get()->count() == 0) {
            for ($i = 0; $i < $tanggal_akhir; $i++) {
                if (in_array(Carbon::parse($year.'-'.$month)->startOfMonth()->addDays($i)->format('Y-m-d'), $holiday->toArray())) {
                    Jadwal::create([
                        'user_id' => $request->user_id,
                        'tanggal' => Carbon::parse($year.'-'.$month)->addDays($i)->format('Y-m-d'),
                        'shift_id' => 3
                    ]);
                } else {
                    Jadwal::create([
                        'user_id' => $request->user_id,
                        'tanggal' => Carbon::parse($year.'-'.$month)->addDays($i)->format('Y-m-d'),
                        'shift_id' => 1
                    ]);
                }
            }
            return back()->with('success', 'merefresh data');
        }
        $SF1 = [];
        try {
            if (isset($request->SF1)) {
                for ($i = 0; $i < Carbon::parse($year.'-'.$month)->endOfMonth()->format('d'); $i++) {
                    if (in_array(Carbon::parse($year.'-'.$month)->startOfMonth()->addDays($i)->format('Y-m-d'), $request->SF1)) {
                        Jadwal::where('user_id', $request->user_id)->whereDate('tanggal', Carbon::parse($year.'-'.$month)->startOfMonth()->addDays($i)->format('Y-m-d'))->update([
                            'ruangan_id' => $request->ruangan_id,
                            'shift_id' => 1
                        ]);
                        if (Jadwal::where('user_id', $request->user_id)->whereDate('tanggal', Carbon::parse($year.'-'.$month)->startOfMonth()->addDays($i)->format('Y-m-d'))->where('shift_id', 1)->get()->count() > 1) {
                            Jadwal::where('user_id', $request->user_id)->whereDate('tanggal', Carbon::parse($year.'-'.$month)->startOfMonth()->addDays($i)->format('Y-m-d'))->where('shift_id', 1)->first()->delete();
                        }
                        array_push($SF1, Jadwal::where('user_id', $request->user_id)->whereDate('tanggal', Carbon::parse($year.'-'.$month)->startOfMonth()->addDays($i)->format('Y-m-d'))->first());
                    }
                }
            } else {
                if (isset($request->SF2)) {
                    $SF2 = [];
                    $update = array_diff($request->SF2, $SF2);
                    $update = array_values($update);

                    for ($i = 0; $i < Carbon::parse($year.'-'.$month)->endOfMonth()->format('d'); $i++) {
                        if (in_array(Carbon::parse($year.'-'.$month)->startOfMonth()->addDays($i)->format('Y-m-d'), $update)) {
                            echo Carbon::parse($year.'-'.$month)->startOfMonth()->addDays($i)->format('Y-m-d') . '  yang di pilih  SF2 <br>';
                            Jadwal::where('user_id', $request->user_id)->whereDate('tanggal', Carbon::parse($year.'-'.$month)->startOfMonth()->addDays($i)->format('Y-m-d'))->update([
                                'ruangan_id' => $request->ruangan_id,
                                'shift_id' => 2
                            ]);
                            if (Jadwal::where('user_id', $request->user_id)->whereDate('tanggal', Carbon::parse($year.'-'.$month)->startOfMonth()->addDays($i)->format('Y-m-d'))->where('shift_id', 2)->get()->count() > 1) {
                                Jadwal::where('user_id', $request->user_id)->whereDate('tanggal', Carbon::parse($year.'-'.$month)->startOfMonth()->addDays($i)->format('Y-m-d'))->where('shift_id', 2)->first()->delete();
                            }
                        }
                    }
                }
                if (isset($request->L)) {
                    for ($i = 0; $i < Carbon::parse($year.'-'.$month)->endOfMonth()->format('d'); $i++) {
                        if (in_array(Carbon::parse($year.'-'.$month)->startOfMonth()->addDays($i)->format('Y-m-d'), $request->L)) {
                            Jadwal::where('user_id', $request->user_id)->whereDate('tanggal', Carbon::parse($year.'-'.$month)->startOfMonth()->addDays($i)->format('Y-m-d'))->update([
                                'ruangan_id' => $request->ruangan_id,
                                'shift_id' => 3,
                            ]);
                            if (Jadwal::where('user_id', $request->user_id)->where('tanggal', Carbon::parse($year.'-'.$month)->startOfMonth()->addDays($i)->format('Y-m-d'))->where('shift_id', 3)->get()->count() > 1) {
                                Jadwal::where('user_id', $request->user_id)->where('tanggal', Carbon::parse($year.'-'.$month)->startOfMonth()->addDays($i)->format('Y-m-d'))->where('shift_id', 3)->first()->delete();
                            }
                        }
                    }
                }
                return back();
            }
            $SF2 = [];
            if (isset($request->SF2)) {
                for ($i = 0; $i < Carbon::parse($year.'-'.$month)->endOfMonth()->format('d'); $i++) {
                    if (in_array(Carbon::parse($year.'-'.$month)->startOfMonth()->addDays($i)->format('Y-m-d'), $request->SF1) && in_array(Carbon::parse($year.'-'.$month)->startOfMonth()->addDays($i)->format('Y-m-d'), $request->SF2)) {
                        echo Carbon::parse($year.'-'.$month)->startOfMonth()->addDays($i)->format('Y-m-d') . 'create SF1 dan SF2 <br>';

                        Jadwal::create([
                            'user_id' => $request->user_id,
                            'cabang_id' => $request->cabang_id,
                            'shift_id' => 2,
                            'ruangan_id' => $request->ruangan_id,
                            'tanggal' => Carbon::parse($year.'-'.$month)->startOfMonth()->addDays($i)->format('Y-m-d')
                        ]);

                        array_push($SF2, Carbon::parse($year.'-'.$month)->startOfMonth()->addDays($i)->format('Y-m-d'));
                    } else {
                        echo Carbon::parse($year.'-'.$month)->startOfMonth()->addDays($i)->format('Y-m-d') . ' <br>';
                    }
                }

                $update = array_diff($request->SF2, $SF2);
                $update = array_values($update);

                for ($i = 0; $i < Carbon::parse($year.'-'.$month)->endOfMonth()->format('d'); $i++) {
                    if (in_array(Carbon::parse($year.'-'.$month)->startOfMonth()->addDays($i)->format('Y-m-d'), $update)) {
                        echo Carbon::parse($year.'-'.$month)->startOfMonth()->addDays($i)->format('Y-m-d') . '  yang di pilih  SF2 <br>';
                        Jadwal::where('user_id', $request->user_id)->whereDate('tanggal', Carbon::parse($year.'-'.$month)->startOfMonth()->addDays($i)->format('Y-m-d'))->update([
                            'ruangan_id' => $request->ruangan_id,
                            'shift_id' => 2
                        ]);
                        if (Jadwal::where('user_id', $request->user_id)->whereDate('tanggal', Carbon::parse($year.'-'.$month)->startOfMonth()->addDays($i)->format('Y-m-d'))->where('shift_id', 2)->get()->count() > 1) {
                            Jadwal::where('user_id', $request->user_id)->whereDate('tanggal', Carbon::parse($year.'-'.$month)->startOfMonth()->addDays($i)->format('Y-m-d'))->where('shift_id', 2)->first()->delete();
                        }
                    } else {
                        echo Carbon::parse($year.'-'.$month)->startOfMonth()->addDays($i)->format('Y-m-d') . ' <br>';
                    }
                }
                for ($i = 0; $i < count($SF2); $i++) {
                    if (in_array($SF2[$i], $request->SF2)) {
                        echo 'hapus' . $SF2[$i];
                    } else {
                        echo 'gg';
                    }
                }
            }
            if (isset($request->L)) {
                for ($i = 0; $i < Carbon::parse($year.'-'.$month)->endOfMonth()->format('d'); $i++) {
                    if (in_array(Carbon::parse($year.'-'.$month)->startOfMonth()->addDays($i)->format('Y-m-d'), $request->L)) {
                        Jadwal::where('user_id', $request->user_id)->whereDate('tanggal', Carbon::parse($year.'-'.$month)->startOfMonth()->addDays($i)->format('Y-m-d'))->update([
                            'ruangan_id' => $request->ruangan_id,
                            'shift_id' => 3,
                        ]);
                        if (Jadwal::where('user_id', $request->user_id)->where('tanggal', Carbon::parse($year.'-'.$month)->startOfMonth()->addDays($i)->format('Y-m-d'))->where('shift_id', 3)->get()->count() > 1) {
                            Jadwal::where('user_id', $request->user_id)->where('tanggal', Carbon::parse($year.'-'.$month)->startOfMonth()->addDays($i)->format('Y-m-d'))->where('shift_id', 3)->first()->delete();
                        }
                    }
                }
            }

            return back()->with('success', 'Berhasil Mengupdate Attendance');
        } catch (Exception $err) {
            return back()->with('error', $err->getMessage());
            // echo $err->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $user = User::find($id);
        $json = [
            'name' => $user->name,
            'cabang_id' => $user->cabang_id,
            'cabang' => $user->cabang->nama,
            'ruangan' => Ruangan::where('cabang_id', $user->cabang_id)->get()
        ];
        return response()->json($json);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    private function cek($row)
    {
        $bulan = Carbon::now()->format('m');
        $tanggal_akhir = Carbon::now()->endOfMonth()->format('d');
        $holiday = Holidays::whereMonth('holiday_date', $bulan)->pluck('holiday_date');

        for ($i = 0; $i < $tanggal_akhir; $i++) {
            if (in_array(Carbon::now()->startOfMonth()->addDays($i)->format('Y-m-d'), $holiday->toArray())) {
                return 'disabled';
            } else {
                return 'checked';
            }
        }
    }
    private function tanggal($user)
    {
        return $user;
    }
    private function kode($user, $tanggal)
    {
        $array = [];
        foreach ($user->where('tanggal', $tanggal) as $data) {
            array_push($array, $data->kode);
        }
        return $array;
    }
    private function cabang($user, $tanggal)
    {
        $array = [];
        foreach ($user->where('tanggal', $tanggal) as $data) {
            array_push($array, $data->cabang);
        }
        return $array;
    }
    private function ruang($user, $tanggal)
    {
        $array = [];
        foreach ($user->where('tanggal', $tanggal) as $data) {
            array_push($array, $data->ruang);
        }
        return $array;
    }
    public function update_user($month, $year)
    {
        try {
            $user = User::whereHas('roles', function ($qr) {
                return $qr->whereIn('name', ['dokter ', 'office-boy', 'perawat']);
            })->whereDoesntHave('jadwal', function ($re) use ($month, $year) {
                return $re->whereMonth('tanggal', $month)->whereYear('tanggal', $year);
            })->get();
            foreach ($user as $data) {
                $bulan = Carbon::parse($year . '-' . $month)->format('m');
                $tanggal_akhir = Carbon::parse($year . '-' . $month)->endOfMonth()->format('d');
                $holiday = Holidays::whereMonth('holiday_date', $bulan)->pluck('holiday_date');

                Jadwal::where('user_id', $data->id)->whereYear('tanggal',$month)->whereMonth('tanggal', $month)->delete();
                // dd(Jadwal::where('user_id', $id)->get());
                for ($i = 0; $i < $tanggal_akhir; $i++) {
                    if (in_array(Carbon::parse($year . '-' . $month)->startOfMonth()->addDays($i)->format('Y-m-d'), $holiday->toArray())) {
                        Jadwal::create([
                            'user_id' => $data->id,
                            'tanggal' => Carbon::parse($year . '-' . $month)->startOfMonth()->addDays($i)->format('Y-m-d'),
                            'cabang_id' => $data->cabang_id,
                            'ruangan_id' => $data->cabang->ruangan->first()->id,
                            'shift_id' => 3
                        ]);
                    } else {
                        Jadwal::create([
                            'user_id' => $data->id,
                            'tanggal' => Carbon::parse($year . '-' . $month)->startOfMonth()->addDays($i)->format('Y-m-d'),
                            'cabang_id' => $data->cabang_id,
                            'ruangan_id' => $data->cabang->ruangan->first()->id,
                            'shift_id' => 1
                        ]);
                    }
                }
            }

            return back()->with('success', 'Berhasil Mengupdate Data Jadwal ' . Carbon::parse($year . '-' . $month)->format('Y M') . ' => ' . $user->pluck('name') . ', => ' . Jadwal::get()->count());
        } catch (Exception $err) {
            return back()->with('error', $err->getMessage());
        }
    }
    public function edit($id)
    {
        try {
            $collection = new Collection();
            $shift = Shift::pluck('kode');
            $user = DB::table('users')
                ->join('jadwals', 'jadwals.user_id', '=', 'users.id')
                ->join('shifts', 'shifts.id', '=', 'jadwals.shift_id')
                ->join('cabangs', 'cabangs.id', '=', 'jadwals.cabang_id')
                ->join('ruangans', 'ruangans.id', '=', 'jadwals.ruangan_id')
                ->select([
                    'jadwals.tanggal as tanggal',
                ])
                ->where('jadwals.user_id', $id)
                ->whereYear('jadwals.tanggal', Carbon::now()->format('Y'))
                ->whereMonth('jadwals.tanggal', Carbon::now()->format('m'))
                ->orderBy('tanggal')
                ->distinct()
                ->get();
            $child = DB::table('users')
                ->join('jadwals', 'jadwals.user_id', '=', 'users.id')
                ->join('shifts', 'shifts.id', '=', 'jadwals.shift_id')
                ->join('cabangs', 'cabangs.id', '=', 'jadwals.cabang_id')
                ->join('ruangans', 'ruangans.id', '=', 'jadwals.ruangan_id')
                ->select([
                    'jadwals.tanggal as tanggal',
                    'shifts.kode as kode',
                    'cabangs.nama as cabang',
                    'ruangans.nama_ruangan as ruang',
                ])
                ->where('jadwals.user_id', $id)
                ->whereYear('jadwals.tanggal', Carbon::now()->format('Y'))
                ->whereMonth('jadwals.tanggal', Carbon::now()->format('m'))
                ->get();
            $a = 1;
            $i = 0;
            foreach ($user as $data) {
                $collection->push((object)[
                    'id' => $i++,
                    'no' => $a++,
                    'tanggal' => $this->tanggal($data->tanggal),
                    'kode' => $this->kode($child, $data->tanggal),
                    'cabang' => $this->cabang($child, $data->tanggal),
                    'ruang' => $this->ruang($child, $data->tanggal)
                ]);
            }
            $datatable =  datatables()->of($collection);

            $bulan = Carbon::now()->format('m');
            $tanggal_akhir = Carbon::now()->endOfMonth()->format('d');
            $holiday = Holidays::whereMonth('holiday_date', $bulan)->pluck('holiday_date');

            foreach ($shift as $row) {
                for ($i = 0; $i < $tanggal_akhir; $i++) {
                    if (in_array(Carbon::now()->startOfMonth()->addDays($i)->format('Y-m-d'), $holiday->toArray())) {
                        $datatable->editColumn($row, function ($data) use ($row, $id) {
                            return '<input type="checkbox" name="' . $row . '[]" value="' . $data->tanggal . '">';
                        });
                    } else {
                        $datatable->editColumn($row, function ($data) use ($row, $id) {
                            return '<input type="checkbox" name="' . $row . '[]" value="' . $data->tanggal . '">';
                        });
                    }
                }
            }

            $option = Shift::pluck('kode')->toArray();
            return $datatable
                ->addIndexColumn()
                ->rawColumns(array_values($option))
                ->make();
        } catch (Exception $err) {
            return response()->json($err->getMessage());
        }
    }
    public function AttendanceEditYearMonth($id, $year, $month)
    {
        try {
            $collection = new Collection();
            $shift = Shift::pluck('kode');
            $user = DB::table('users')
                ->join('jadwals', 'jadwals.user_id', '=', 'users.id')
                ->join('shifts', 'shifts.id', '=', 'jadwals.shift_id')
                ->join('cabangs', 'cabangs.id', '=', 'jadwals.cabang_id')
                ->join('ruangans', 'ruangans.id', '=', 'jadwals.ruangan_id')
                ->select([
                    'jadwals.tanggal as tanggal',
                ])
                ->where('jadwals.user_id', $id)
                ->whereYear('jadwals.tanggal', $year)
                ->whereMonth('jadwals.tanggal', $month)
                ->orderBy('tanggal')
                ->distinct()
                ->get();
            $child = DB::table('users')
                ->join('jadwals', 'jadwals.user_id', '=', 'users.id')
                ->join('shifts', 'shifts.id', '=', 'jadwals.shift_id')
                ->join('cabangs', 'cabangs.id', '=', 'jadwals.cabang_id')
                ->join('ruangans', 'ruangans.id', '=', 'jadwals.ruangan_id')
                ->select([
                    'jadwals.tanggal as tanggal',
                    'shifts.kode as kode',
                    'cabangs.nama as cabang',
                    'ruangans.nama_ruangan as ruang',
                ])
                ->where('jadwals.user_id', $id)
                ->whereYear('jadwals.tanggal', $year)
                ->whereMonth('jadwals.tanggal', $month)
                ->get();
            $a = 1;
            $i = 0;
            foreach ($user as $data) {
                $collection->push((object)[
                    'id' => $i++,
                    'no' => $a++,
                    'tanggal' => $this->tanggal($data->tanggal),
                    'kode' => $this->kode($child, $data->tanggal),
                    'cabang' => $this->cabang($child, $data->tanggal),
                    'ruang' => $this->ruang($child, $data->tanggal)
                ]);
            }
            $datatable =  datatables()->of($collection);

            $bulan = Carbon::now()->format('m');
            $tanggal_akhir = Carbon::now()->endOfMonth()->format('d');
            $holiday = Holidays::whereMonth('holiday_date', $bulan)->pluck('holiday_date');

            foreach ($shift as $row) {
                for ($i = 0; $i < $tanggal_akhir; $i++) {
                    if (in_array(Carbon::now()->startOfMonth()->addDays($i)->format('Y-m-d'), $holiday->toArray())) {
                        $datatable->editColumn($row, function ($data) use ($row, $id) {
                            return '<input type="checkbox" name="' . $row . '[]" value="' . $data->tanggal . '">';
                        });
                    } else {
                        $datatable->editColumn($row, function ($data) use ($row, $id) {
                            return '<input type="checkbox" name="' . $row . '[]" value="' . $data->tanggal . '">';
                        });
                    }
                }
            }

            $option = Shift::pluck('kode')->toArray();
            return $datatable
                ->addIndexColumn()
                ->rawColumns(array_values($option))
                ->make();
        } catch (Exception $err) {
            return response()->json($err->getMessage());
        }
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
        //
    }
    public function AttendanceResetYearMonth($id, $year, $month)
    {
        try {
            $datetime = Carbon::parse($year.'-'.$month);
            $bulan = $datetime->format('m');
            $tahun = $datetime->format('Y');
            $tanggal_akhir = $datetime->endOfMonth()->format('d');
            $holiday = Holidays::whereMonth('holiday_date', $bulan)->whereYear('holiday_date', $tahun)->pluck('holiday_date');
            $user = User::findOrFail($id);
            Jadwal::where('user_id', $id)->whereMonth('tanggal', $datetime->format('m'))->whereYear('tanggal', $datetime->format('Y'))->delete();
            // dd(Jadwal::where('user_id', $id)->get());
            for ($i = 0; $i < $tanggal_akhir; $i++) {
                if (in_array($datetime->startOfMonth()->addDays($i)->format('Y-m-d'), $holiday->toArray())) {
                    Jadwal::create([
                        'user_id' => $id,
                        'tanggal' => $datetime->startOfMonth()->addDays($i)->format('Y-m-d'),
                        'cabang_id' => $user->cabang_id,
                        'ruangan_id' => $user->cabang->ruangan->first()->id,
                        'shift_id' => 3
                    ]);
                } else {
                    Jadwal::create([
                        'user_id' => $id,
                        'tanggal' => $datetime->startOfMonth()->addDays($i)->format('Y-m-d'),
                        'cabang_id' => $user->cabang_id,
                        'ruangan_id' => $user->cabang->ruangan->first()->id,
                        'shift_id' => 1
                    ]);
                }
            }
            return back()->with('success', 'Berhasil Mereset Data Jadwal ' . $datetime->format('Y - M') . ', pada user ' . $user->name);
        } catch (Exception $err) {
            return back()->with('error', $err->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $bulan = Carbon::now()->format('m');
            $tanggal_akhir = Carbon::now()->endOfMonth()->format('d');
            $holiday = Holidays::whereMonth('holiday_date', $bulan)->pluck('holiday_date');
            $user = User::findOrFail($id);
            Jadwal::where('user_id', $id)->whereMonth('tanggal', Carbon::now()->format('m'))->delete();
            // dd(Jadwal::where('user_id', $id)->get());
            for ($i = 0; $i < $tanggal_akhir; $i++) {
                if (in_array(Carbon::now()->startOfMonth()->addDays($i)->format('Y-m-d'), $holiday->toArray())) {
                    Jadwal::create([
                        'user_id' => $id,
                        'tanggal' => Carbon::now()->startOfMonth()->addDays($i)->format('Y-m-d'),
                        'cabang_id' => $user->cabang_id,
                        'ruangan_id' => $user->cabang->ruangan->first()->id,
                        'shift_id' => 3
                    ]);
                } else {
                    Jadwal::create([
                        'user_id' => $id,
                        'tanggal' => Carbon::now()->startOfMonth()->addDays($i)->format('Y-m-d'),
                        'cabang_id' => $user->cabang_id,
                        'ruangan_id' => $user->cabang->ruangan->first()->id,
                        'shift_id' => 1
                    ]);
                }
            }
            return back()->with('success', 'Berhasil Mereset Data Jadwal ' . Carbon::now()->format('Y - M') . ', pada user ' . $user->name);
        } catch (Exception $err) {
            return back()->with('error', $err->getMessage());
        }
    }

    public function search(Request $request)
    {
        $pegawai = $request->pegawai;
        $month = $request->month;
        $year = $request->year;

        $datetimeparse = Carbon::parse($year.'-'.$month);
        $datetimenow = Carbon::now();

        if (!$request->month) {
            $month = $datetimenow->format('m');
        }
        if (!$request->year) {
            $year = $datetimenow->format('Y');
        }
        $day = $datetimeparse->endOfMonth()->format('d');

        if ($year == null && $month == null) {
            $user = User::where('name', 'like', '%' . $pegawai . '%')->get();
        } elseif ($year == '') {
            $user = User::where('name', 'like', '%' . $pegawai . '%')->whereHas('jadwal', function ($q) use ($month, $year) {
                return $q->whereMonth('tanggal', $month);
            })->get();
        } elseif ($month == '') {
            $user = User::where('name', 'like', '%' . $pegawai . '%')->whereHas('jadwal', function ($q) use ($month, $year) {
                return $q->whereYear('tanggal', $year);
            })->get();
        } else {
            $user = User::where('name', 'like', '%' . $pegawai . '%')->whereHas('jadwal', function ($q) use ($month, $year) {
                return $q->whereMonth('tanggal', $month)->whereYear('tanggal', $year);
            })->get();
        }
        return view('admin.attendance.index',    [
            'date' => $request->all(),
            'user' => $user,
            'holiday' => Holidays::whereMonth('holiday_date', $month)->whereYear('holiday_date', $year)->get(),
            'cabangs' => Cabang::get(),
            'ruangans' => Ruangan::get(),
            'shift' => Shift::pluck('kode'),
            'month' => $month,
            'year' => $year,
            'day' => $day
        ]);
    }
}
