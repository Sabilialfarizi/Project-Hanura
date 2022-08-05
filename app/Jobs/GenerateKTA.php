<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\DetailUsers;
use App\Kecamatan;
use App\Kantor;
use App\Kepengurusan;
use App\Exports\PACExport;
use ZipArchive;
use PDF;

class GenerateKTA implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $id = 0;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function handle()
    {
        $detail = DetailUsers::leftJoin('users', 'detail_users.userid', '=', 'users.id')
            ->where('detail_users.userid', $this->id)
            ->first();

        $ketua = Kepengurusan::where('id_daerah', $detail->kabupaten_domisili)->where('jabatan', 3001)->first();
        $sekre = Kepengurusan::where('id_daerah', $detail->kabupaten_domisili)->where('jabatan', 3002)->first();
        $kantor = Kantor::where('id_daerah', $detail->kabupaten_domisili)->first();
        $kecamatan = Kecamatan::where('id_kec', $detail->kecamatan_domisili)->first();

        $zip = new \ZipArchive();
        $zipName = '/www/wwwroot/siap.partaihanura.or.id/uploads/ktp-kta-zip/' . $detail->provinsi_domisili . '_' . $detail->kabupaten_domisili . '_' . $kecamatan->id_kec . '_' . strtoupper($kecamatan->name) . '.zip';
        if ($zip->open($zipName, \ZipArchive::CREATE) !== TRUE) {
            echo 'Could not open ZIP file.';
            return;
        }

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ])->loadview('dpc.member.cetaks', ['kantor' => $kantor, 'detail' => $detail, 'ketua' => $ketua, 'kecamatan' => $kecamatan, 'sekre' => $sekre])
            ->setPaper([0, 0, 550, 245], 'potrait');
        $pdf->getDomPDF()->setHttpContext(
            stream_context_create([
                'ssl' => [
                    'allow_self_signed' => TRUE,
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                ]
            ])
        );

        $pdf->save('/www/wwwroot/siap.partaihanura.or.id/uploads/kta/' . $detail->nik . '.pdf');
        $zip->addFile('/www/wwwroot/siap.partaihanura.or.id/uploads/kta/' . $detail->nik . '.pdf', 'KTP+KTA/' . $detail->nik . '.pdf');

        $id = $detail->kecamatan_domisili;
        $exporter = app()->makeWith(PACExport::class, compact('id'));

        $exporter->store("Kecamatan_" . $kecamatan->name . ".xls", 'excel_store');
        $zip->addFile('/www/wwwroot/siap.partaihanura.or.id/uploads/kta/' . "Kecamatan_" . $kecamatan->name . ".xls", "Kecamatan_" . $kecamatan->name . ".xls");
        $zip->close();

        unlink('/www/wwwroot/siap.partaihanura.or.id/uploads/kta/' . $detail->nik . '.pdf');
        $user = DetailUsers::where('userid', $this->id)->update([
                'kta_generated_at' => date('Y-m-d H:i:s')
            ]);
    }
}
