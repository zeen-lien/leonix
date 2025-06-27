<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            RoleSeeder::class,
        ]);

        // Create a default user
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );
        $user->assignRole('user');

        // Create the main admin user
        $admin = User::firstOrCreate(
            ['email' => 'leonixadmin@gmail.com'],
            [
                'name' => 'leon',
                'password' => bcrypt('leonix123'),
            ]
        );
        $admin->assignRole('admin');
    }
}
