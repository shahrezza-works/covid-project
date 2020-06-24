<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterResponKontraktorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('respon_kontraktor', function (Blueprint $table) {
            $table->smallInteger('verify')->nullable()->after('deklarasi_3');
        });
    }
}
