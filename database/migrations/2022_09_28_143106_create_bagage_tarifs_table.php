<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBagageTarifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bagage_tarifs', function (Blueprint $table) {
            $table->id();
            $table->integer('compagnie_id');
            $table->string('name_bagage');
            $table->string('montant_bagage');
            $table->string('taille')->default('normal')->nullable;
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
        Schema::dropIfExists('bagage_tarifs');
    }
}
