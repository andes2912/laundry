<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{LaundrySetting,User};
class LaundrySettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('auth','Admin')->first();

        $set = LaundrySetting::create([
          'user_id' => $user->id,
          'target_day'  => 0,
          'target_month'  => 0,
          'target_year'  => 0,
        ]);
    }
}
