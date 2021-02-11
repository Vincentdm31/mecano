<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategorieInterventionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorie_intervention', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('observations')->nullable();
            $table->bigInteger('categorie_id')->unsigned();
            $table->bigInteger('intervention_id')->unsigned();

            $table->foreign('categorie_id')->references('id')->on('categories')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('intervention_id')->references('id')->on('interventions')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categorie_intervention');
    }
}
