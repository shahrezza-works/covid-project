<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('location', function (Blueprint $table) {
            $table->string('nama_bangunan', 255)->nullable()->change();
            $table->string('no_jalan', 255)->nullable()->change();
            $table->string('nama_jalan', 255)->nullable()->change();
        });
    }

}
