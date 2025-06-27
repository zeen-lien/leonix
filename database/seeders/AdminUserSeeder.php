<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin role if it doesn't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'adminleonix@gmail.com'],
            [
                'name' => 'Zeen - Lien',
                'email' => 'adminleonix@gmail.com',
                'password' => bcrypt('zeenlien12'),
                'email_verified_at' => now(),
            ]
        );

        // Assign admin role to the user
        $admin->assignRole($adminRole);

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: adminleonix@gmail.com');
        $this->command->info('Password: zeenlien12');
        $this->command->info('Role: Admin');
    }
}
