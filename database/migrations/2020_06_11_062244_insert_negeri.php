<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertNegeri extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('negeri')->insert([
            ['name'=>'SELANGOR'],
            ['name'=>'WILAYAH PERSEKUTUAN'],
            ['name'=>'WP LABUAN'],
            ['name'=>'WP PUTRAJAYA'],
            ['name'=>'JOHOR'],
            ['name'=>'KEDAH'],
            ['name'=>'KELANTAN'],
            ['name'=>'MELAKA'],
            ['name'=>'NEGERI SEMBILAN'],
            ['name'=>'PAHANG'],
            ['name'=>'PERAK'],
            ['name'=>'PERLIS'],
            ['name'=>'PULAU PINANG'],
            ['name'=>'SABAH'],
            ['name'=>'SARAWAK'],
            ['name'=>'TERENGGANU']
        ]);
    }

}
