<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ubah default kolom theme jadi 1 (dark) untuk user baru.
        Schema::table('users', function (Blueprint $table) {
            $table->enum('theme', [0, 1])->default(1)->change();
        });

        // Set semua user existing yang masih NULL ke dark.
        DB::table('users')->whereNull('theme')->update(['theme' => 1]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('theme', [0, 1])->default(0)->change();
        });
    }
};
