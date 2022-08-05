<?php

namespace App\Exports;

use App\{Kabupaten, DetailUsers};
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use Illuminate\Support\Facades\DB;

class KabupatenExport extends DefaultValueBinder implements WithCustomValueBinder, FromView
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
     public function view(): View
    {
         $detail = DetailUsers::leftJoin('users','detail_users.userid','=','users.id')
        ->leftJoin('jenis_kelamin','detail_users.gender','=','jenis_kelamin.id')
        ->leftJoin('jobs','detail_users.pekerjaan','=','jobs.id')
        ->leftJoin('kelurahans','kelurahans.id_kel','=','detail_users.kelurahan_domisili')
        ->leftJoin('status_pernikahans','detail_users.status_kawin','=','status_pernikahans.id')
        ->where('detail_users.status_kta',1)
        ->where('detail_users.status_kpu',2)
         ->where(DB::raw('LENGTH(detail_users.no_member)'),'>',[18,20])
        ->where('detail_users.kabupaten_domisili', $this->id)
         ->orderBy('detail_users.kelurahan_domisili','asc')
         ->groupBy('detail_users.nik')
        ->select('detail_users.no_member','detail_users.created_by as pegawai','detail_users.kabupaten_domisili','detail_users.nickname','detail_users.nik','jenis_kelamin.name as gender',
        'detail_users.birth_place','detail_users.tgl_lahir','status_pernikahans.nama','jobs.name','detail_users.alamat','detail_users.kelurahan_domisili','kelurahans.id_kpu')->get();
   
        return view('dpp.kabupaten.pemilu', [
            'details' =>$detail
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