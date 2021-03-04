<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategorieInterventionPieceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorie_intervention_piece', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('observations')->nullable();
            $table->bigInteger('categorie_id')->unsigned();
            $table->bigInteger('piece_id')->unsigned();

            $table->foreign('categorie_id')->references('id')->on('categorie_intervention')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('piece_id')->references('id')->on('pieces')
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
        Schema::dropIfExists('categorie_intervention_piece');
    }
}
