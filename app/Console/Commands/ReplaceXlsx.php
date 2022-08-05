<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\XlsReplace;
use App\Kecamatan;
use DB;

class ReplaceXlsx extends Command
{
    protected $signature = 'xls:replace';
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $data = Kecamatan::selectRaw('kecamatans.id_kec, user.jml')
            ->leftJoin(DB::raw("
                (
                    SELECT DISTINCT
                        COUNT(id) as jml,
                        kecamatan_domisili as kec
                    FROM
                        detail_users
                    WHERE
                        deleted_at IS NULL AND
                        status_kta = 1 AND
                        status_kpu = 2
                    GROUP BY
                        kecamatan_domisili
                ) as user
            "), 'user.kec', '=', 'kecamatans.id_kec')
            ->get();
            
        foreach ($data as $val) {
            if($val->jml > 0) {
                XlsReplace::dispatch($val->id_kec);
            }
        }
        
        return 0;
    }
}
