<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKetOdontogramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ket_odontograms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id');
            $table->string('occlusi')->nullable();
            $table->string('t_palatinus')->nullable();
            $table->string('t_mandibularis')->nullable();
            $table->string('palatum')->nullable();
            $table->string('diastema')->nullable();
            $table->string('anomali')->nullable();
            $table->string('lain')->nullable();
            $table->string('d')->nullable();
            $table->string('m')->nullable();
            $table->string('f')->nullable();
            $table->string('ket_occlusi')->nullable();
            $table->string('ket_tp')->nullable();
            $table->string('ket_tm')->nullable();
            $table->string('ket_palatum')->nullable();
            $table->string('ket_diastema')->nullable();
            $table->string('ket_anomali')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ket_odontograms');
    }
}
