<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResponKontraktorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respon_kontraktor', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('form_id');
            $table->string('nama', 255);
            $table->string('no_tel', 50);
            $table->string('nama_syarikat', 255);
            $table->smallInteger('demam')->nullable();
            $table->smallInteger('selsema')->nullable();
            $table->smallInteger('batuk')->nullable();
            $table->smallInteger('sesak_nafas')->nullable();
            $table->smallInteger('sakit_sendi')->nullable();
            $table->smallInteger('deria_rasa')->nullable();
            $table->smallInteger('deklarasi_1')->nullable();
            $table->smallInteger('deklarasi_2')->nullable();
            $table->smallInteger('deklarasi_3')->nullable();
            $table->smallInteger('agree')->nullable();
            $table->decimal('suhu', 20, 2)->nullable();
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
        Schema::dropIfExists('respon_kontraktor');
    }
}
