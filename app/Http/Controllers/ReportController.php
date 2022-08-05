<?php

namespace App\Http\Controllers;

use App\{Booking, Cabang, Customer, Komisi, Payment, RincianKomisi, RincianPembayaran, User};
use App\Exports\AppoinmentExport;
use App\Exports\PasienExport;
use App\Exports\PaymentExport;
use Carbon\Carbon;
use Excel;
use Spatie\Permission\Models\Role;

class ReportController extends Controller
{
    public function pasien()
    {
        $cabang = Cabang::all();
        $pasien = [];
        $from = Carbon::parse(request('from'))->format('Y-m-d H:i:s');
        $to = Carbon::parse(request('to'))->format('Y-m-d H:i:s');

        request('cabang') == 'all' ? $pasien = Customer::with('user', 'cabang')->whereBetween('created_at', [$from, $to])->get() : $pasien = Customer::with('user', 'cabang')->where('cabang_id', request('cabang'))->whereBetween('created_at', [$from, $to])->get();

        return view('report.pasien.index', compact('cabang', 'pasien'));
    }

    public function pasienexport($cabang_id)
    {
        if ($cabang_id != 'all') {
            $cabang = Cabang::find($cabang_id);
            $data = Customer::with('user', 'cabang')->where('cabang_id', $cabang_id)->get();

            return Excel::download(new PasienExport($data), 'Laporan Pasien Cabang ' . $cabang->nama . '.xlsx');
        } else {
            $data = Customer::with('user', 'cabang')->get();

            return Excel::download(new PasienExport($data), 'Laporan Pasien Semua Cabang.xlsx');
        }
    }

    public function appoinment()
    {
        $cabang = Cabang::all();
        $appointments = [];

        if (request('cabang') != 'all') {
            $appointments = Booking::with('cabang', 'pasien', 'rincian', 'tindakan')->where('cabang_id', request('cabang'))->get();
        } else {
            $appointments = Booking::with('cabang', 'pasien', 'rincian', 'tindakan')->get();
        }

        return view('report.appoinment.index', compact('cabang', 'appointments'));
    }

    public function appoinmentreport($cabang_id)
    {
        if ($cabang_id != 'all') {
            $cabang = Cabang::find($cabang_id);
            $data = Booking::with('cabang', 'pasien', 'rincian', 'tindakan')->where('cabang_id', $cabang_id)->get();

            return Excel::download(new AppoinmentExport($data), 'Laporan Appoinment Cabang ' . $cabang->nama . '.xlsx');
        } else {
            $data = Booking::with('cabang', 'pasien', 'rincian', 'tindakan')->get();

            return Excel::download(new AppoinmentExport($data), 'Laporan Appoinment Semua Cabang.xlsx');
        }
    }

    public function payment()
    {
        $metode = Payment::all();
        $payments = [];
        $from = Carbon::parse(request('from'))->format('Y-m-d H:i:s');
        $to = Carbon::parse(request('to'))->format('Y-m-d H:i:s');

        if (request('metode') != 'all') {
            $payments = RincianPembayaran::with('payment', 'kasir')->where('payment_id', request('metode'))->whereBetween('tanggal_pembayaran', [$from, $to])->get();
        } else {
            $payments = RincianPembayaran::with('payment', 'kasir')->whereBetween('tanggal_pembayaran', [$from, $to])->get();
        }

        return view('report.payment.index', compact('payments', 'metode'));
    }

    public function paymentreport($payment_id)
    {
        $from = Carbon::parse(request('from'))->format('Y-m-d H:i:s');
        $to = Carbon::parse(request('to'))->format('Y-m-d H:i:s');

        if ($payment_id != 'all') {
            $payment = Payment::find($payment_id);
            $data = RincianPembayaran::with('payment', 'kasir')->where('payment_id', request('metode'))->whereBetween('tanggal_pembayaran', [$from, $to])->get();

            return Excel::download(new PaymentExport($data), 'Laporan Metode Pembayarang Cabang ' . $payment->nama_metode . '.xlsx');
        } else {
            $data = RincianPembayaran::with('payment', 'kasir')->whereBetween('tanggal_pembayaran', [$from, $to])->get();

            return Excel::download(new PaymentExport($data), 'Laporan Metode Pembayaran Semua Cabang.xlsx');
        }
    }

    public function komisi()
    {
        $roles = Role::get();
        $komisi = null;
        $from = Carbon::parse(request('from'))->format('Y-m-d H:i:s');
        $to = Carbon::parse(request('to'))->format('Y-m-d H:i:s');



        return view('report.komisi.index', compact('roles', 'komisi'));
    }
}
