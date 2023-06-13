<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\LaundrySetting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Models\notifications_setting;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Buat Pengguna Dengan Role Administrator';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $admin['name']                  = $this->ask("Nama untuk Administrator");
        $admin['email']                 = $this->ask("Email untuk Administrator");
        $admin['status']                = 'Active';
        $admin['auth']                  = 'Admin';
        $admin['password']              = $this->secret("Password untuk Administrator");
        $admin['password_confirmation'] = $this->secret("Konfirmasi Password untuk Administrator");

        $cekUser = User::where('email', $admin['email'])->where('auth','Admin')->first();
        if($cekUser) {
            $this->error("User Administrator sudah dibuat!");
            return -1;
        }

        $validator = Validator::make($admin,[
            'name'      => ['required','string','max:255'],
            'email'     => ['required','string','email','max:255','unique:'.User::class],
            'password'  => ['required','confirmed',Password::defaults()]
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return -1;
        }
        DB::transaction(function() use($admin, $cekUser){
            $role = Role::firstOrNew(['name' => 'Admin']);
            $role->name = 'Admin';
            $role->save();

            $admin['password']  = bcrypt($admin['password']);
            $newAdmin = User::create($admin);
            $newAdmin->assignRole('Admin');

            $getIdAdmin = User::where('auth','Admin')->first();

            $setting = new LaundrySetting;
            $setting->user_id       = $getIdAdmin->id;
            $setting->target_day    = 0;
            $setting->target_month  = 0;
            $setting->target_year   = 0;
            $setting->save();

            $notif = new notifications_setting;
            $notif->user_id = $setting->user_id;
            $notif->telegram_order_masuk    = 0;
            $notif->telegram_order_selesai  = 0;
            $notif->email                   = 0;
            $notif->save();
        });

        $this->info("User " .$admin['email']. " Berhasil dibuat :)");
    }
}
