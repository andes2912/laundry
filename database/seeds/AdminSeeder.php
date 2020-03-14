<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // insert data ke table pegawai
        DB::table('users')->insert([
        	'name' => 'Administrator',
        	'email' => 'admin@laundry.com',
        	'status' => 'Aktif',
            'auth' => 'Admin',
            'password' => bcrypt('123456')
        ]);
    }
}
