<?php

namespace App\Http\Controllers\Admin;

use App\{Booking, Cabang, Purchase, InOut, Komisi, Payment, RincianKomisi, RincianPembayaran, Supplier, User};
use App\Exports\AppoinmentExport;
use App\Exports\PasienExport;
use App\Exports\PaymentExport;
use Carbon\Carbon;
use Excel;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
 
    public function barang()
    {
        $barangs = [];
        $from = '';
        $to = '';

        if (request('from') && request('to')) {

            $from = Carbon::createFromFormat('d/m/Y', request('from'))->format('Y-m-d');
            $to = Carbon::createFromFormat('d/m/Y', request('to'))->format('Y-m-d');

            $barangs = Purchase::whereBetween('created_at', [$from, $to])->get();
        } else {
            $barangs = Purchase::get();
        }

        return view('admin.report.barang.index', compact('barangs', 'from', 'to'));
    }
}
