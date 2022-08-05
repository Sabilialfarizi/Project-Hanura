<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCabangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cabangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_cabang')->unique();
            $table->string('nama');
            $table->text('alamat');
            $table->string('telpon');
            $table->string('email');
            $table->string('wa');
            $table->integer('status_pajak')->nullable();
            $table->integer('ppn')->nullable();
            $table->integer('is_active')->default(1);
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
        Schema::dropIfExists('cabangs');
    }
}
