<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('in_outs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id');
            $table->foreignId('supplier_id');
            $table->foreignId('customer_id');
            $table->foreignId('user_id');
            $table->integer('in')->default(0);
            $table->integer('out')->default(0);
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
        Schema::dropIfExists('in_outs');
    }
}
