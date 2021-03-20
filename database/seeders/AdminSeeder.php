<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

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
        	'status' => 'Active',
          'auth' => 'Admin',
          'password' => bcrypt('123456')
        ]);
    }
}
