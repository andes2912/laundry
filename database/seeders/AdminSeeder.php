<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{User,notifications_setting};
use Spatie\Permission\Models\Role;

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
        $user = User::create([
        	'name' => 'Administrator',
        	'email' => 'admin@laundry.com',
        	'status' => 'Active',
          'auth' => 'Admin',
          'password' => bcrypt('123456')
        ]);

        // Set role admin
        $role = Role::create(['name' => 'Admin']);
        $user->assignRole('Admin');

        // Set default setting notif
        $notif = notifications_setting::create([
          'user_id'                 => $user->id,
          'telegram_order_masuk'    => 0,
          'telegram_order_selesai'  => 0,
          'email'                   => 0
        ]);
    }
}
