<?php

namespace App\Exports;

use App\Customer;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PasienExport implements FromView
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }


    public function view(): View
    {
        return view('report.pasien.table', [
            'pasien' => $this->data
        ]);
    }
}
