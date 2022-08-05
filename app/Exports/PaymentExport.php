<?php

namespace App\Exports;

use App\RincianPembayaran;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PaymentExport implements FromView
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }


    public function view(): View
    {
        return view('report.payment.table', [
            'payments' => $this->data
        ]);
    }
}
