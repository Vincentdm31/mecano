<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('operations');
        Schema::create('operations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();

            $table->bigInteger('intervention_id')->unsigned();
            $table->foreign('intervention_id')->references('id')->on('interventions')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('categorie_id')->unsigned()->nullable();
            $table->foreign('categorie_id')->references('id')->on('categories')
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
        Schema::dropIfExists('operations');
    }
}
