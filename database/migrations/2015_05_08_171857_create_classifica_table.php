<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassificaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('classifica', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('team_id')->default(0)->unsigned();
            $table->integer('vinte')->default(0);
            $table->integer('nulle')->default(0);
            $table->integer('perse')->default(0);
            $table->integer('gf')->default(0);
            $table->integer('gs')->default(0);
            $table->integer('giornata')->default(0);
            $table->integer('stagione_id')->default(0)->unsigned();;
            $table->float('fp')->default(0);
			$table->timestamps();
            $table->softDeletes();

            $table->dropForeign('classifica_team_id_foreign');
            $table->foreign('team_id')
                ->references('id')
                ->on('teams')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->dropForeign('classifica_stagione_id_foreign');
            $table->foreign('stagione_id')
                ->references('id')
                ->on('stagioni')
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
		Schema::drop('classifica');
	}

}
