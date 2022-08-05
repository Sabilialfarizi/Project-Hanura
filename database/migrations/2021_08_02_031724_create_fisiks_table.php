<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFisiksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fisiks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id');
            $table->string('gol_darah')->nullable();
            $table->string('tekanan_darah')->nullable();
            $table->string('pny_jantung')->default('Tidak Ada');
            $table->string('diabetes')->default('Tidak Ada');
            $table->string('haemopilia')->default('Tidak Ada');
            $table->string('hepatitis')->default('Tidak Ada');
            $table->string('gastring')->default('Tidak Ada');
            $table->string('pny_lainnya')->default('Tidak Ada');
            $table->string('alergi_obat')->default('Tidak Ada');
            $table->string('alergi_makanan')->default('Tidak Ada');
            $table->string('ket_lainnya')->nullable();
            $table->string('ket_tekanan')->nullable();
            $table->string('ket_obat')->nullable();
            $table->string('ket_makanan')->nullable();
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
        Schema::dropIfExists('fisiks');
    }
}
