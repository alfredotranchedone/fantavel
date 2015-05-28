<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayersTable extends Migration {

    public function up()
    {
        Schema::create('players',function(Blueprint $table){

            $table->increments('id');
            $table->string('nominativo',150);
            $table->string('ruolo',10);
            $table->string('codice',10);
            $table->integer('teams_id')->default(0);
            $table->timestamps();

            $table->index('nominativo');
            $table->index('codice');

            $table->foreign('teams_id')
                ->references('id')
                ->on('teams')
                ->onUpdate('cascade');

        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('players');
    }

}
