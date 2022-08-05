<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCabangIdToInOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('in_outs', function (Blueprint $table) {
            $table->char('invoice')->after('id');
            $table->integer('last_stok')->after('out');
            $table->foreignId('cabang_id')->after('customer_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('in_outs', function (Blueprint $table) {
            $table->dropColumn('invoice');
            $table->dropColumn('cabang_id');
        });
    }
}
