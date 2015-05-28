<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePunteggiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('punteggi', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('players_codice')->default(0)->unsigned();
			$table->integer('giornata')->default(0);
			$table->integer('stagione_id')->default(0)->unsigned();

			$table->float('voto')->nullable();
			$table->float('quotazione')->nullable();
			$table->float('stato')->nullable();
			$table->float('magic_punti')->nullable();
			$table->float('gol')->nullable();
			$table->float('ammonizione')->nullable();
			$table->float('espulsione')->nullable();
			$table->float('rigori')->nullable();
			$table->float('autogol')->nullable();
			$table->float('assist')->nullable();

			$table->timestamps();

            $table->foreign('players_codice')
                ->references('id')
                ->on('players')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('stagione_id')
                ->references('id')
                ->on('players')
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
		Schema::drop('punteggi');
	}

}
