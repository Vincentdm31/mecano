<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterventionPieceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intervention_piece', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('intervention_id')->unsigned();
            $table->bigInteger('piece_id')->unsigned();

            $table->foreign('intervention_id')->references('id')->on('interventions')
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
        Schema::dropIfExists('intervention_piece');
    }
}
