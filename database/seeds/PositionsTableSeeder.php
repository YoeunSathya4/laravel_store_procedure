<?php

use Illuminate\Database\Seeder;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
	{
	   DB::table('positions')->insert(
            [
                [
                    'name'              => 'Admin',
                    'description'       => 'Full Access',
                ],
                [
                    'name'              => 'User',
                    'description'       => '(Full Access for Property Information Entry and Search) But Can not DELETE',
                ]
               
            ]
        );
	}
}
