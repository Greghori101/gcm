<?php

namespace Database\Seeders;

use App\Enums\Roles;
use App\Models\User;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Control which seeders to run
        $runDatabaseSeeder = true;
        $runPlansSeeder = true;
        $runQueueSeeder = true;
        $runMedicinesSeeder = true;

        if ($runPlansSeeder) {
            $this->call(DefaultPlansSeeder::class);
        }
        if ($runQueueSeeder) {
            $this->call(QueueSeeder::class);
        }
        if ($runMedicinesSeeder) {
            $this->call(MedicinesSeeder::class);
        }

        if (!$runDatabaseSeeder) {
            return;
        }

        $adminRole = Role::firstOrCreate(['name' => Roles::ADMIN->value]);

        // Create a default admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'firstname' => 'Default',
                'lastname' => 'Admin',
                'password' => Hash::make('password'),
                'phone_number' => '[1234567899]',
                'blood_type' => 'a+',
                'gender' => 'male',
                'birthdate' => '2001-12-11',
                'email_verified_at' => Carbon::now(),
            ]
        );

        // Assign the admin role to the user
        if (!$admin->hasRole(Roles::ADMIN->value)) {
            $admin->assignRole($adminRole);
        }

        $superAdminRole = Role::firstOrCreate(['name' => Roles::SUPER_ADMIN->value]);

        // Create a default admin user
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@admin.com'],
            [
                'firstname' => 'Super',
                'lastname' => 'Admin',
                'password' => Hash::make('password'),
                'phone_number' => '[1234567890]',
                'blood_type' => 'a+',
                'gender' => 'male',
                'birthdate' => '2001-12-11',
                'email_verified_at' => Carbon::now(),
            ]
        );

        // Assign the admin role to the user
        if (!$superAdmin->hasRole(Roles::SUPER_ADMIN->value)) {
            $superAdmin->assignRole($superAdminRole);
        }
    }
}
