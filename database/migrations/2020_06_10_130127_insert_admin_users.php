<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertAdminUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('users')->insert([
            ['name'=>'Administrator', 'phone'=>'0183727489', 'usertype'=>'-1', 'email'=>'shahrezza.works@gmail.com', 'password'=>'$2y$10$.5yiIpCJee0pihp1tdjqKO4AyfnxE4mGW.zr/ZlbRHsRQrxLLAA9K', 'created_at'=>NOW(), 'updated_at'=>NOW()],
        ]);
    }

}
