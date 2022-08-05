<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('kode_voucher');
            $table->date('tgl_mulai');
            $table->date('tgl_akhir');
            $table->bigInteger('min_transaksi')->nullable();
            $table->bigInteger('nominal');
            $table->enum('type', ['Per', 'Min']);
            $table->integer('persentase');
            $table->integer('kuota');
            $table->integer('is_active')->default();
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
        Schema::dropIfExists('vouchers');
    }
}
