<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterResponStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('respon_staff', function (Blueprint $table) {
            $table->decimal('suhu', 20, 2)->nullable()->change();
        });
    }

}
