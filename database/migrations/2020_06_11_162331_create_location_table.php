<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('nama_premis');
            $table->integer('kategori_1');
            $table->integer('kategori_2');
            $table->string('tel_premis',50);
            $table->text('nama_bangunan');
            $table->text('no_jalan');
            $table->text('nama_jalan');
            $table->string('poskod',50);
            $table->text('kawasan');
            $table->text('bandar');
            $table->string('negeri',50);
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
        Schema::dropIfExists('location');
    }
}
