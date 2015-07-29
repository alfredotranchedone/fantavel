<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('formations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('teams_id')->unsigned()->default(0);
			$table->integer('players_codice')->unsigned()->default(0);
			$table->integer('numero_maglia');
			$table->integer('giornata_id')->default(0);
			$table->timestamps();

            $table->dropIndex('formations_giornata_id_index');
            $table->index('giornata_id');

            $table->dropForeign('formations_teams_id_foreign');
            $table->foreign('teams_id')
                ->references('id')
                ->on('teams')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->dropForeign('formations_players_codice_foreign');
            $table->foreign('players_codice')
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
		Schema::drop('formations');
	}

}
