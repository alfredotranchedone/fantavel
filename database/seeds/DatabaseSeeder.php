<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call('UsersTableSeeder');
        $this->command->info('Users table seeded!');

        $this->call('LevelsTableSeeder');
        $this->command->info('Levels table seeded!');
	}

}
