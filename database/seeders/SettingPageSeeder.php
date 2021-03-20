<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSettings;

class SettingPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $setpage = PageSettings::create([
        'judul'   => 'E-Laundry'
      ]);
    }
}
