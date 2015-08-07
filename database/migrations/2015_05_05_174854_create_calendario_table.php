<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendarioTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('calendario', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('giornata')->default(0);
            $table->integer('stagione_id')->default(0);
            $table->string('dataGiornata')->default(0);
            $table->string('dataConsegna')->default(0);
            $table->integer('team_1_id');
            $table->integer('team_2_id');
            $table->integer('modulo_1_id')->default(0);
            $table->integer('modulo_2_id')->default(0);
            $table->float('result_team_1_id')->nullable();
            $table->float('result_team_2_id')->nullable();
            $table->integer('fattore_campo')->default(0);
            $table->integer('group_id')->default(0);
			$table->timestamps();
            $table->softDeletes();

            $table->foreign('team_1_id')
                ->references('id')
                ->on('teams')
                ->onUpdate('cascade');

            $table->foreign('team_2_id')
                ->references('id')
                ->on('teams')
                ->onUpdate('cascade');

            $table->foreign('modulo_1_id')
                ->references('id')
                ->on('moduli')
                ->onUpdate('cascade');

            $table->foreign('modulo_2_id')
                ->references('id')
                ->on('moduli')
                ->onUpdate('cascade');

            $table->foreign('stagione_id')
                ->references('id')
                ->on('stagioni')
                ->onUpdate('cascade');

            $table->foreign('group_id')
                ->references('id')
                ->on('groups')
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
		Schema::drop('calendario');
	}

}
