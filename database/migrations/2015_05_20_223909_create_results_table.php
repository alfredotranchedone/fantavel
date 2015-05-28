<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('results', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('giornata');
            $table->integer('stagione_id')->unsigned()->default(0);
            $table->integer('teams_id')->unsigned()->default(0);
            $table->float('result',2)->nullable();
            $table->integer('modulo_id')->unsigned()->default(0);
            $table->integer('goal')->nullable();
			$table->timestamps();
            $table->softDeletes();

            $table->dropForeign('results_stagione_id_foreign');
            $table->foreign('stagione_id')
                ->references('id')
                ->on('stagioni')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->dropForeign('results_teams_id_foreign');
            $table->foreign('teams_id')
                ->references('id')
                ->on('team')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->dropForeign('results_modulo_id_foreign');
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
		Schema::drop('results');
	}

}
