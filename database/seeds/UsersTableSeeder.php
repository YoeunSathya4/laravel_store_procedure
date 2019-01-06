<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
	{
	     DB::table('users')->insert(
            [
                
                [ 
                    'position_id' => 1,
                    'name' => "System",
                    'avatar' => 'public/cp/img/ppl.png',
                    'email' => 'system@camcyber.com',
                    'phone' => '012998877',
                    'status'=>1,
                    'visible'=>0,
                    'password' => bcrypt('xxxxxx')
                ],
                
                [   
                   'position_id' => 1,
                    'name' => "Admin",
                    'avatar' => 'public/cp/img/ppl.png',
                    'email' => 'admin@camcyber.com',
                    'phone' => '096778899',
                    'status'=>1,
                    'visible'=>1,
                    'password' => bcrypt('123456')
                ],
                
                [   'position_id' => 2,
                    'name' => "User",
                    'avatar' => 'public/cp/img/ppl.png',
                    'email' => 'user@camcyber.com',
                    'phone' => '098445566',
                    'status'=>1,
                    'visible'=>1,
                    'password' => bcrypt('123456')],
            ]);
	}
}
