<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Kecamatan;
use App\Exports\PACExport;
use ZipArchive;

class XlsReplace implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $id = 0;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function handle()
    {
        $kecamatan = Kecamatan::where('id_kec', $this->id)->first();
        
        $zip = new \ZipArchive();
        $zipName = '/www/wwwroot/siap.partaihanura.or.id/uploads/kta-ktp-zip/' . $kecamatan->id_kec . '_' . strtoupper($kecamatan->name) . '.zip';
        if ($zip->open($zipName, \ZipArchive::CREATE) !== TRUE) {
            echo 'Could not open ZIP file.';
            return;
        }
        
        $id = $this->id;
        $exporter = app()->makeWith(PACExport::class, compact('id'));

        $exporter->store("Kecamatan_" . $kecamatan->name . ".xls", 'excel_store');
        $zip->addFile('/www/wwwroot/siap.partaihanura.or.id/uploads/kta/' . "Kecamatan_" . $kecamatan->name . ".xls", "Kecamatan_" . $kecamatan->name . ".xls");
        $zip->close();
    }
}
