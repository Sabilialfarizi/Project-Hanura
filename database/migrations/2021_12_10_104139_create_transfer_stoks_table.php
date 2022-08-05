<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferStoksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_stoks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asal_id');
            $table->foreignId('tujuan_id');
            $table->foreignId('barang_id');
            $table->foreignId('user_id');
            $table->char('invoice');
            $table->integer('qty');
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
        Schema::dropIfExists('transfer_stoks');
    }
}
