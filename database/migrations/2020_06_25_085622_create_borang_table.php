<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBorangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borang', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama', 100)->nullable()->default('text');
            $table->smallInteger('remove')->default(0);
        });

        DB::table('borang')->insert([
            ['nama'=>'Anggota Kerja'],
            ['nama'=>'Pelawat'],
            ['nama'=>'Kontraktor']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('borang');
    }
}
