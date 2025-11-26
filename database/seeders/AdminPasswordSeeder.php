<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminPasswordSeeder extends Seeder
{
    public function run()
    {
        $admin = User::where('email', 'admin@example.com')->first();
        if ($admin) {
            $admin->password = Hash::make('12345678'); // password baru
            $admin->save();
            echo "Password admin berhasil direset.\n";
        }
    }
}

