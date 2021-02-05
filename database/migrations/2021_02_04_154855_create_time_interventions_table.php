<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeInterventionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_interventions', function (Blueprint $table) {
            $table->id();
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->timestamps();

            $table->bigInteger('intervention_id')->unsigned()->nullable();
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
        Schema::dropIfExists('time_interventions');
    }
}
