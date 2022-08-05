<?php

namespace App\Http\Controllers;

use App\Models\absensi;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\{ExportAbsensiAbsensiWeb, ExportDetailAbsensiWeb, Jam};
use Excel;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $format          = 'Y-m-d';
        $start           = Carbon::now()->startOfMonth();
        $formatdatestart = Carbon::parse($start)->format($format);
        $end             = Carbon::now()->endOfMonth();
        $formatdateend   = Carbon::parse($end)->format($format);
        $current = Carbon::now();
        $current->timezone = 'Asia/Jakarta';
        $current->check();
        $this->validate($request, [
            'limit' => 'integer',
        ]);

        $lists = DB::table('absensi as a')
            ->join('karyawan as b', 'b.id', '=', 'a.karyawan_id')
            ->join('roles as c', 'c.id', '=', 'b.jabatan_id')
            ->select(
                'b.nip',
                'b.nama',
                'c.jabatan',
                'b.id',
                'a.tanggal',
                'a.jam_masuk',
                'a.ft_selfie_in',
                'a.jam_keluar',
                'a.ft_selfie_out',
                'a.lokasi',
                'a.keterangan'
            )
            ->whereBetween('a.tanggal', [$formatdatestart, $formatdateend])

            ->when($request->keyword, function ($query) use ($request) {
                $query->where('nama', 'like', "%{$request->keyword}%"); // search by jabatan
            })->paginate($request->limit ? $request->limit : 20);

        $lists->appends($request->only('keyword'));

        $month = Carbon::now()->format('Y-m');


        return view('admin.attendance.index', compact('lists', 'month'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function show(absensi $absensi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function edit(absensi $absensi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, absensi $absensi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function destroy(absensi $absensi)
    {
        //
    }

    public function detailAbsensi(Request $request, $id)
    {
        $format          = 'Y-m-d';
        $start           = Carbon::now()->startOfMonth();
        $formatdatestart = Carbon::parse($start)->format($format);
        $end             = Carbon::now()->endOfMonth();
        $formatdateend   = Carbon::parse($end)->format($format);
        $this->validate($request, [
            'limit' => 'integer',
        ]);

        $lists = DB::table('absensi as a')
            ->join('karyawan as b', 'b.id', '=', 'a.karyawan_id')
            ->join('jabatan as c', 'c.id', '=', 'b.jabatan_id')
            ->select(
                'b.nik',
                'b.nama',
                'c.jabatan',
                'b.id',
                'a.tanggal',
                'a.jam_masuk',
                'a.ft_selfie_in',
                'a.jam_keluar',
                'a.ft_selfie_out',
                'a.lokasi',
                'a.keterangan'
            )
            ->whereBetween('a.tanggal', [$formatdatestart, $formatdateend])
            ->where('b.id', $id)

            ->when($request->keyword, function ($query) use ($request) {
                $query->where('nama', 'like', "%{$request->keyword}%"); // search by jabatan
            })->paginate($request->limit ? $request->limit : 20);

        $lists->appends($request->only('keyword'));
        // Menampilkan halaman absensi
        return view('absensi.detailAbsensi', compact('lists'));
    }

    public function exportDetailAbsensi($id, $daterange)
    {

        $date = explode('+', $daterange); //EXPLODE TANGGALNYA UNTUK MEMISAHKAN START & END
        return Excel::download(new ExportDetailAbsensiWeb($date[0], $date[1], $id), 'Laporan_Detail_Absensi_Periode_' . $date[0] . '_' . $date[1] . '.xlsx');
    }

    public function exportAbsensi($daterange)
    {
        $date = explode('+', $daterange); //EXPLODE TANGGALNYA UNTUK MEMISAHKAN START & END
        return Excel::download(new ExportAbsensiAbsensiWeb($date[0], $date[1]), 'Laporan_Absensi_Periode_' . $date[0] . '_' . $date[1] . '.xlsx');
    }

    //   mobile
    public function absenmasuk(Request $request)
    {
        try {
            DB::beginTransaction();

            $current           = Carbon::now();
            $current->timezone = 'Asia/Jakarta';
            $jamMasuk          = $current->toTimeString();
            $tanggalMasuk      = $current->toDateString();

            $kar = DB::table('karyawan')->where('ID', $request->karyawan_id)->first();

            if (
                DB::table('absensi')
                ->where('karyawan_id', $request->karyawan_id)
                ->where('Tanggal', $tanggalMasuk)->first() != null
            ) {
                $response = [
                    'statusCode' => 500,
                    'message' => 'Anda Sudah Absen',
                ];
                return response()->json(['result' => $response], 200);
            }

            $status = '';

            $now = Carbon::now();
            $jam = DB::table('shifts')->where('kode', 'SF1')->first();
            $mulai = Carbon::parse($jam->waktu_mulai)->format('H:i:s');
            $selesai = Carbon::parse($jam->waktu_selesai)->format('H:i:s');

            //SF1
            if ($jamMasuk <= $mulai) {
                $status = 'Tepat Waktu';
                $photo       = $request->file('ft_selfie_in')->getClientOriginalName();
                $photo       = uniqid() . '_' . $photo;
                $destination = base_path() . '/public/uploads/img/absensi';
                $request->file('ft_selfie_in')->move($destination, $photo);

                DB::table('absensi')->insert([
                    'karyawan_id'  => $request->karyawan_id,
                    'Tanggal'      => $tanggalMasuk,
                    'jam_masuk'    => $jamMasuk,
                    'jam_keluar'   => '00:00:00',
                    'latitude'     => $request->lat,
                    'longitude'    => $request->long,
                    'alamat'       => $request->alamat,
                    'lokasi'       => $request->lokasi,
                    'catatan'      => $request->keterangan,
                    'Keterangan'   => $status,
                    'shift_id'   => 1,
                    'ft_selfie_in' => $photo
                ]);
                DB::commit();
                $response = [
                    'statusCode' => 200,
                    'message' => 'Absen Berhasil',
                ];
                return response()->json(['result' => $response], 200);
            } else {
                $status = 'Terlambat';
                $photo       = $request->file('ft_selfie_in')->getClientOriginalName();
                $photo       = uniqid() . '_' . $photo;
                $destination = base_path() . '/public/uploads/img/absensi';
                $request->file('ft_selfie_in')->move($destination, $photo);

                DB::table('absensi')->insert([
                    'karyawan_id'  => $request->karyawan_id,
                    'Tanggal'      => $tanggalMasuk,
                    'jam_masuk'    => $jamMasuk,
                    'jam_keluar'   => '00:00:00',
                    'latitude'     => $request->lat,
                    'longitude'    => $request->long,
                    'alamat'       => $request->alamat,
                    'lokasi'       => $request->lokasi,
                    'catatan'      => $request->keterangan,
                    'Keterangan'   => $status,
                    'shift_id'   => 1,
                    'ft_selfie_in' => $photo
                ]);
                DB::commit();
                $response = [
                    'statusCode' => 200,
                    'message' => 'Absen Berhasil',
                ];
                return response()->json(['result' => $response], 200);
            }

            // $jam = DB::table('shifts')->where('kode', 'SF2')->first();
            // $mulai = Carbon::parse($jam->waktu_mulai)->format('H:i:s');
            // $selesai = Carbon::parse($jam->waktu_selesai)->format('H:i:s');

            // //SF2    
            // if ($jamMasuk <= $mulai && $jamMasuk >= $selesai) {
            //     $status = 'Tepat Waktu';
            //     $photo       = $request->file('ft_selfie_in')->getClientOriginalName();
            //     $photo       = uniqid() . '_' . $photo;
            //     $destination = base_path() . '/public/uploads/img/absensi';
            //     $request->file('ft_selfie_in')->move($destination, $photo);

            //     DB::table('absensi')->insert([
            //         'karyawan_id'  => $request->karyawan_id,
            //         'Tanggal'      => $tanggalMasuk,
            //         'jam_masuk'    => $jamMasuk,
            //         'jam_keluar'   => '00:00:00',
            //         'latitude'     => $request->lat,
            //         'longitude'    => $request->long,
            //         'alamat'       => $request->alamat,
            //         'lokasi'       => $request->lokasi,
            //         'catatan'      => $request->keterangan,
            //         'Keterangan'   => $status,
            //         'shift_id'   => 2,
            //         'ft_selfie_in' => $photo
            //     ]);
            //     DB::commit();
            //     $response = [
            //         'statusCode' => 200,
            //         'message' => 'Absen Berhasil',
            //     ];
            //     return response()->json(['result' => $response], 200);
            // } else {
            //     $status = 'Terlambat';
            //     $photo       = $request->file('ft_selfie_in')->getClientOriginalName();
            //     $photo       = uniqid() . '_' . $photo;
            //     $destination = base_path() . '/public/uploads/img/absensi';
            //     $request->file('ft_selfie_in')->move($destination, $photo);

            //     DB::table('absensi')->insert([
            //         'karyawan_id'  => $request->karyawan_id,
            //         'Tanggal'      => $tanggalMasuk,
            //         'jam_masuk'    => $jamMasuk,
            //         'jam_keluar'   => '00:00:00',
            //         'latitude'     => $request->lat,
            //         'longitude'    => $request->long,
            //         'alamat'       => $request->alamat,
            //         'lokasi'       => $request->lokasi,
            //         'catatan'      => $request->keterangan,
            //         'Keterangan'   => $status,
            //         'shift'   => 2,
            //         'ft_selfie_in' => $photo
            //     ]);
            //     DB::commit();
            //     $response = [
            //         'statusCode' => 200,
            //         'message' => 'Absen Berhasil',
            //     ];
            //     return response()->json(['result' => $response], 200);
            // }
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['messages' => $e], 200);
        }
    }

    public function absenkeluar(Request $request)
    {
        // get the current time  4;
        $current           = Carbon::now();
        $current->timezone = 'Asia/Jakarta';
        $jamKeluar         = $current->toTimeString();
        $tanggalKeluar     = $current->toDateString();

        $kar = DB::table('karyawan')->where('ID', $request->karyawan_id)->first();

        if (
            DB::table('absensi')->where(
                'karyawan_id',
                $request->karyawan_id
            )
            ->where('Tanggal', $tanggalKeluar)
            ->where('jam_keluar', '!=', "00:00:00")->first() != null
        ) {
            $response = [
                'statusCode' => 500,
                'message' => 'Anda Sudah Absen',
            ];
            return response()->json(['result' => $response], 200);
        }

        $jam = DB::table('shifts')->where('kode', 'SF1')->first();
        // $mulai = Carbon::parse($jam->mulai)->format('H:i:s');
        $selesai = Carbon::parse($jam->waktu_selesai)->format('H:i:s');

        if ($jamKeluar >= $selesai) {

            $status = '';
            $photo       = $request->file('ft_selfie_out')->getClientOriginalName();
            $photo       = uniqid() . '_' . $photo;
            $destination = base_path() . '/public/uploads/img/absensi';
            $request->file('ft_selfie_out')->move($destination, $photo);

            DB::table('absensi')
                ->where('karyawan_id', $request->karyawan_id)
                ->where('Tanggal', $tanggalKeluar)
                ->update([
                    'jam_keluar'    => $jamKeluar,
                    'ft_selfie_out' => $photo
                ]);

            $response =  [
                'statusCode' => 200,
                'message' => 'Absen Keluar Berhasil',
            ];

            return response()->json(['result' => $response], 200);
        } else {
            $response = [
                'statusCode' => 500,
                'message' => 'Anda Belum Boleh Pulang',
            ];
            return response()->json(['result' => $response], 200);
        }
    }

    public function getabsen($id)
    {
        date_default_timezone_set('asia/ho_chi_minh');
        $format    = 'Y/m/d';
        $start     = Carbon::now()->startOfMonth();
        $formatNow = Carbon::parse($start)->format($format);
        $now       = date($formatNow);
        $to        = date($format);
        $date      = ['from' => $now, 'to' => $to];

        $data = DB::table('absensi')
            ->leftJoin('karyawan', 'karyawan.id', '=', 'absensi.karyawan_id')
            ->leftJoin('jabatan', 'karyawan.jabatan_id', '=', 'jabatan.id')
            ->select(
                'karyawan.id',
                'karyawan.nama',
                'karyawan.nik',
                'karyawan.telp',
                'jabatan.jabatan as jabatan',
                'absensi.tanggal as tanggal',
                DB::raw('TIME_FORMAT(absensi.jam_masuk,"%H:%i" ) jam_masuk'),
                DB::raw('TIME_FORMAT(absensi.jam_keluar,"%H:%i") as jam_keluar'),
                DB::raw('case when timediff(absensi.jam_keluar,absensi.jam_masuk) < 0
        then "00:00"
        else TIME_FORMAT(timediff(absensi.jam_keluar, absensi.jam_masuk) ,"%H:%i")
        end as totjam'),
                'absensi.alamat as alamat',
                'absensi.lokasi as lokasi',
                'absensi.catatan as catatan',
                'absensi.keterangan as keterangan'
            )
            ->where('tanggal', '>=', $date['from'])
            ->where('tanggal', '<=', $date['to'])
            ->where('karyawan.id', '=', $id)
            ->orderBy('absensi.tanggal', 'DESC')
            ->get();
        $response     = [
            'statusCode' => 200,
            'message' => 'Berhasil Menampilkan Data',
            'Data'    => $data
        ];
        return response()->json(['result' => $response], 200);
    }

    public function getdailyabsen($id)
    {
        $current           = Carbon::now();
        $current->timezone = 'Asia/Jakarta';
        $tanggal           = $current->toDateString();
        $data              = DB::table('absensi')
            ->leftJoin('karyawan', 'karyawan.id', '=', 'absensi.karyawan_id')
            ->leftJoin('jabatan', 'karyawan.jabatan_id', '=', 'jabatan.id')
            ->select(
                'karyawan.id',
                'karyawan.nama',
                'karyawan.nik',
                'karyawan.telp',
                'jabatan.jabatan as jabatan',
                'absensi.tanggal as tanggal',
                DB::raw('TIME_FORMAT(absensi.jam_masuk,"%H:%i" ) jam_masuk'),
                DB::raw('TIME_FORMAT(absensi.jam_keluar,"%H:%i") as jam_keluar'),
                DB::raw('case when timediff(absensi.jam_keluar,absensi.jam_masuk) < 0
         then "00:00"
         else TIME_FORMAT(timediff(absensi.jam_keluar, absensi.jam_masuk) ,"%H:%i")
         end as totjam'),
                'absensi.keterangan as keterangan'
            )
            ->where('tanggal', '=', $tanggal)
            ->where('karyawan.id', '=', $id)->first();
        $datas = array(
            'id' => null,
            'nama' =>  null,
            'nik' => null,
            'telp' => null,
            'jam_masuk' => "--:--",
            'jam_keluar' => "--:--",
            'keterangan' => null,
            'tanggal' => "----/--/--"
        );
        if ($data != null) {
            $response     = [
                'statusCode' => 200,
                'message' => 'Berhasil Menampilkan Data',
                'Data'    => $data
            ];
            return response()->json(['result' => $response], 200);
        } else {
            $response     = [
                'statusCode' => 200,
                'message' => 'Anda Belum Melakukan Absen',
                'Data'    => $datas
            ];
            return response()->json(['result' => $response], 200);
        }
    }
}
