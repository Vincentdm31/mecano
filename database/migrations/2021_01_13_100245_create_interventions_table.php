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
        Schema::create('interventions', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_moving')->nullable();
            $table->float('distance_km_interv')->nullable();
            $table->date('start_intervention_time')->nullable();
            $table->date('end_intervention_time')->nullable();
            $table->float('prix')->nullable();
            $table->float('km_vehicule')->nullable();
            $table->enum('state', ['doing', 'pause', 'finish'])->nullable();
            $table->text('observations')->nullable();
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
        Schema::dropIfExists('interventions');
    }
}
