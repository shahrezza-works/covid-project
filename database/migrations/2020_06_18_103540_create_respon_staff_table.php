<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResponStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respon_staff', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('form_id');
            $table->string('nama', 255);
            $table->string('no_pekerja', 50);
            $table->string('jabatan', 50);
            $table->smallInteger('demam');
            $table->smallInteger('selsema');
            $table->smallInteger('batuk');
            $table->smallInteger('sesak_nafas');
            $table->smallInteger('sakit_sendi');
            $table->smallInteger('deria_rasa');
            $table->smallInteger('deklarasi_1');
            $table->smallInteger('deklarasi_2');
            $table->smallInteger('deklarasi_3');
            $table->smallInteger('agree');
            $table->decimal('suhu', 20, 2);
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
        Schema::dropIfExists('respon_staff');
    }
}
