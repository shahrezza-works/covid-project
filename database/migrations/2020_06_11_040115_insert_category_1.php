<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertCategory1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('category_1')->insert([
            ['description'=>'Accommodation'],
            ['description'=>'Association/Union'],
            ['description'=>'Consumer Shopping'],
            ['description'=>'Contruction Site'],
            ['description'=>'Education'],
            ['description'=>'Entertainment'],
            ['description'=>'Ficial Services'],
            ['description'=>'Food and Beverages'],
            ['description'=>'Government Services'],
            ['description'=>'Hentian Bas dan Teksi'],
            ['description'=>'Legal Services'],
            ['description'=>'Manufacturing Facility'],
            ['description'=>'Media'],
            ['description'=>'Medical Services'],
            ['description'=>'Places to Visit/Tourist Spot'],
            ['description'=>'Places/Area/Building/Landmark'],
            ['description'=>'Private Services'],
            ['description'=>'Public Facility'],
            ['description'=>'Real Estate'],
            ['description'=>'Trading Company'],
            ['description'=>'Transportation'],
            ['description'=>'Utilities']
        ]);
    }

}
