<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('teams',function(Blueprint $table){

            $table->increments('id');
            $table->string('name',150);
            $table->integer('user_id')->unsigned()->default(0);
            $table->integer('modulo_id')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('modulo_id')
                ->references('id')
                ->on('moduli')
                ->onUpdate('cascade')
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
        Schema::dropIfExists('teams');
	}

}
