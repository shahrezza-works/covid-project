<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJabatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jabatan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->smallInteger('remove')->default(0);
        });

        DB::table('jabatan')->insert([
            ['name'=>'SDI'],
            ['name'=>'AMTEC'],
            ['name'=>'BTC'],
            ['name'=>'LMTC'],
            ['name'=>'FINANCE'],
            ['name'=>'OS'],
            ['name'=>'LDAC'],
            ['name'=>'SMD'],
            ['name'=>'BDM'],
            ['name'=>'ICG'],
            ['name'=>'MALIM NAWAR'],
            ['name'=>'KULAI'],
            ['name'=>'MD OFFICE'],
            ['name'=>'Others - TNB Staff']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jabatan');
    }
}
