<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterventionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::dropIfExists('interventions');
        Schema::create('interventions', function (Blueprint $table) {
            $table->id();
            $table->datetime('start_deplacement')->nullable();
            $table->datetime('end_deplacement')->nullable();
            $table->datetime('start_intervention_time')->nullable();
            $table->datetime('end_intervention_time')->nullable();
            $table->string('totalTime')->nullable();
            $table->float('prix')->nullable();
            $table->enum('state', ['doing', 'pause', 'finish'])->nullable();
            $table->text('observations')->nullable();
            $table->timestamps();
            $table->string('km_vehicule')->nullable();
            $table->bigInteger('vehicule_id')->unsigned()->nullable();
            $table->foreign('vehicule_id')->references('id')->on('vehicules')
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
        Schema::dropIfExists('interventions');
    }
}
