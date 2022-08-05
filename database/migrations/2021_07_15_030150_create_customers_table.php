<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('cabang_id');
            $table->string('nama');
            $table->string('no_telp', 15);
            $table->string('telp_st', 15);
            $table->string('telp_nd', 15);
            $table->string('no_rek', 25);
            $table->string('nik_ktp', 25);
            $table->string('email');
            $table->string('tempat_lahir');
            $table->date('tgl_lahir');
            $table->enum('jk', ['Laki-Laki', 'Perempuan']);
            $table->string('suku');
            $table->text('alamat');
            $table->string('pekerjaan');
            $table->string('pict');
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
        Schema::dropIfExists('customers');
    }
}
