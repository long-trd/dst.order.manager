<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prizes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('img')->nullable();
            $table->string('text')->nullable();
            $table->string('unit')->nullable();
            $table->integer('number')->nullable();
            $table->integer('percentage')->nullable();
            $table->integer('wheel_event_id')->unsigned();
            $table->foreign('wheel_event_id')->references('id')->on('wheel_events')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('prizes');
    }
}
