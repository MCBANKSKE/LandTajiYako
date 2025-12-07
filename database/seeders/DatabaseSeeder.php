<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles and permissions first
        $this->call([
            RoleSeeder::class,
            CountySeeder::class,
            SubCountySeeder::class,
        ]);

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'mcbankske@gmail.com'],
            [
                'name' => 'MARK CLINTON',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_superadmin' => true,
            ]
        );
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }
    }
}
