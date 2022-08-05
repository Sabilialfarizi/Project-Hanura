<?php

namespace App\Exports;

use App\{Kabupaten, DetailUsers, Kecamatan, Kelurahan, Provinsi};
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use Illuminate\Support\Facades\DB;

class PACExport_hp extends DefaultValueBinder implements WithCustomValueBinder, FromView
{
    public function bindValue(Cell $cell, $value)
    {
        
        if (is_numeric($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }

    use Exportable;
    protected $kabupaten;
    protected $id;
    public function __construct(Kabupaten $kabupaten, $id)
    {
        $this->Kabupaten = $kabupaten;
        $this->id = $id; 
    }
    /**
    * @return \Illuminate\Support\Collection
    // */
    //   public function query()
    // {
    //     $detail =DetailUsers::query()
    //     ->leftJoin('users','detail_users.userid','=','users.id')
    //     ->leftJoin('jenis_kelamin','detail_users.gender','=','jenis_kelamin.id')
    //     ->leftJoin('jobs','detail_users.pekerjaan','=','jobs.id')
    //     ->leftJoin('status_pernikahans','detail_users.status_kawin','=','status_pernikahans.id')
    //     ->where('detail_users.kabupaten_domisili', $this->id)
    //     ->groupBy('detail_users.id')
    //     ->select('detail_users.no_member','detail_users.created_by as pegawai','detail_users.nickname','detail_users.nik','jenis_kelamin.name as gender',
    //     'detail_users.birth_place','detail_users.tgl_lahir','status_pernikahans.nama','jobs.name','detail_users.alamat','detail_users.kelurahan_domisili');
    //   return   $detail;
   
 
    // }
    //   public function columnFormats(): array
    // {
    //     return [
    //         'A' => NumberFormat::FORMAT_GENERAL,
    //         'B' => NumberFormat::FORMAT_TEXT,
    //         'C' => NumberFormat::FORMAT_GENERAL,
    //         'D' => NumberFormat::FORMAT_GENERAL,
    //         'E' => NumberFormat::FORMAT_TEXT,
    //         'F' => NumberFormat::FORMAT_GENERAL,
    //         'G' => NumberFormat::FORMAT_GENERAL,
    //         'H' => NumberFormat::FORMAT_TEXT,
    //         'I' => NumberFormat::FORMAT_GENERAL,
    //         'J' => NumberFormat::FORMAT_GENERAL,
    //         'K' => NumberFormat::FORMAT_GENERAL,
    //         'L' => NumberFormat::FORMAT_GENERAL,
    //     ];
    // }
    public function view(): View
    {
        
    
        $kecamatan = Kecamatan::where('id_kec',$this->id)->first();
    
        $kabupaten = Kabupaten::where('id_kab', $kecamatan->id_kab)->first();
       
        $provinsi = Provinsi::where('id_prov', $kabupaten->id_prov)->first();
    
        $detail = DetailUsers::leftJoin('users','detail_users.userid','=','users.id')
        ->leftJoin('jenis_kelamin','detail_users.gender','=','jenis_kelamin.id')
        ->leftJoin('kelurahans','kelurahans.id_kel','=','detail_users.kelurahan_domisili')
        ->leftJoin('jobs','detail_users.pekerjaan','=','jobs.id')
        ->leftJoin('status_pernikahans','detail_users.status_kawin','=','status_pernikahans.id')
        ->where('detail_users.status_kta',1)
        ->whereIn('detail_users.status_kpu',array(2,5))
        ->where(DB::raw('LENGTH(detail_users.no_member)'),'>',[18,20])
        ->where('detail_users.kecamatan_domisili', $this->id)
        ->orderBy('detail_users.kelurahan_domisili','asc')
         ->groupBy('detail_users.nik')
        ->select('detail_users.no_member','detail_users.created_by as pegawai','detail_users.kabupaten_domisili','detail_users.nickname','detail_users.nik','jenis_kelamin.name as gender',
        'detail_users.birth_place','detail_users.tgl_lahir','status_pernikahans.nama','jobs.name','detail_users.alamat','detail_users.kelurahan_domisili','kelurahans.id_kpu')->get();
    

        return view('dpp.kecamatan.pemilu', [
            'details' =>$detail,
            'kecamatan' => $kecamatan,
            'kabupaten' => $kabupaten,
            'provinsi'  => $provinsi,
        ]);
    }   
    
    
    // public function headings() : array
    // {
    //     return[
    //     'No. KTA',
    //     'Penerbit KTA',
    //     'Nama',
    //     'NIK',
    //     'Jenis Kelamin',
    //     'Tempat Lahir',
    //     'Tanggal Lahir',
    //     'Status Perkawinan',
    //     'Status Pekerjaan',
    //     'Alamat',
    //     'Keluarahan KPU'
    //     ];
    // }
}