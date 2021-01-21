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
            $table->string('distance_km_interv')->nullable();
            $table->date('start_intervention_time')->nullable();
            $table->date('end_intervention_time')->nullable();
            $table->string('totalTime')->nullable();
            $table->float('prix')->nullable();
            $table->enum('state', ['doing', 'pause', 'finish'])->nullable();
            $table->text('observations')->nullable();
            $table->timestamps();
            
            $table->bigInteger('vehicule_id')->unsigned();
            $table->foreign('vehicule_id')->references('id')->on('vehicules')
                        ->onDelete('cascade');
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
