<?php

namespace App\Exports;

use App\{Kepengurusan, Jabatan};
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

class PengurusPAC extends DefaultValueBinder implements WithCustomValueBinder, FromView
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
    public function __construct(Kepengurusan $kepengurusan, $id)
    {
        $this->Kepengurusan = $kepengurusan;
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
        $kepengurusan = Kepengurusan::where('id_daerah', $this->id)
        ->whereNull('deleted_at')
        ->leftJoin('jabatans','kepengurusan.jabatan','=','jabatans.kode')
        ->selectRaw('jabatans.nama as nama_jabatan, kepengurusan.*')
        ->get();
        return view('dpp.kepengurusan.kecamatan.ExcelPengurus', [
            'kepengurusan' =>$kepengurusan
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