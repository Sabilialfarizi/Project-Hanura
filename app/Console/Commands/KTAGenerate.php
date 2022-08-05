<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\GenerateKTA;
use Illuminate\Support\Facades\DB;

class KTAGenerate extends Command
{
    protected $signature = 'kta:generate';
    protected $description = 'Generating KTA with PDF extension';

    public function handle()
    {
        // $user = DB::table('detail_users')->selectRaw('userid')
        //     ->where(function ($query) {
        //         $query->whereRaw('`updated_at` > `kta_generated_at`')
        //             ->orWhereNull('kta_generated_at');
        //     })
        //     ->whereNotNull('kabupaten_domisili')
        //     ->whereNotNull('kecamatan_domisili')
        //     ->whereNull('deleted_at')
        //     ->where('status_kta', 1)
        //     ->where('status_kpu', 2)
        //     ->get();

        // foreach ($user as $key => $value) {
        //     GenerateKTA::dispatch($value->userid);
        // }

        // return 0;
    }
}
