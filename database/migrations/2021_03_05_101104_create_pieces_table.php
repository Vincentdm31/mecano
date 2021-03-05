<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePiecesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('pieces');
        Schema::create('pieces', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('qte');

            $table->bigInteger('piece_id')->unsigned()->nullable();
            $table->foreign('piece_id')->references('id')->on('piece_lists')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('operation_id')->unsigned()->nullable();
            $table->foreign('operation_id')->references('id')->on('operations')
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
        Schema::dropIfExists('pieces');
    }
}
