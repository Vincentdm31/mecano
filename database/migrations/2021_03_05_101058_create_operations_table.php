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
        Schema::create('operations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->enum('state',  ['doing', 'pause', 'finish'])->default('doing');
            $table->text('op_comment')->nullable();
            $table->datetime('start_operation_time')->nullable();
            $table->datetime('end_operation_time')->nullable();

            $table->bigInteger('intervention_id')->unsigned()->nullable();
            $table->foreign('intervention_id')->references('id')->on('interventions')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('operation_id')->unsigned()->nullable();
            $table->foreign('operation_id')->references('id')->on('operation_lists')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')
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
