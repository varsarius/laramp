<?php

use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('locations')->insert([
        ['name' => 'Cisinau'],
        ['name' => 'Rezina'],
        ['name' => 'Ialoveni'],
        ['name' => 'Belti']
    ]);
    }
}
