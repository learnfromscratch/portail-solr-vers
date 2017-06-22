<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(['cin' => 'R0252052', 'name' => 'Oxdata Admin', 'email' => 'admin@oxdata.ma',
        	'password' => bcrypt('oxdata'), 'role' => 'admin', 'tel' => '0604135679', 'address' => 'Hassan, Rabat', 'created_at' => Carbon::now()
        	]);
        DB::table('users')->insert(['cin' => '123456', 'name' => 'Mailtrap', 'email' => 'ibarry-b54e2f@inbox.mailtrap.io', 'role' => 'admin',
            'password' => bcrypt('itelsys'), 'tel' => '123456', 'address' => 'Hassan, Rabat', 'created_at' => Carbon::now()
            ]);
    }
}
