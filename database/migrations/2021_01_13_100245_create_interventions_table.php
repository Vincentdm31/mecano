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
            $table->boolean('is_moving');
            $table->float('distance_km_interv');
            $table->date('start_intervention_time');
            $table->date('end_intervention_time');
            $table->float('prix');
            $table->float('km_vehicule');
            $table->enum('state', ['doing', 'pause', 'finish']);
            $table->text('observations');
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
