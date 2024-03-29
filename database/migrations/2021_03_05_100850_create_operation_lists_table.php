<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperationListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operation_lists', function (Blueprint $table) {
            $table->id();
            $table->string('ref')->unique();
            $table->string('name')->unique();
            $table->float('price');
            $table->boolean('isPackage')->default(false);
            $table->float('duration')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operation_lists');
    }
}
