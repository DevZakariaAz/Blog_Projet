<?php

namespace Database\Seeders;

use Modules\Blog\Models\User;
use Illuminate\Database\Seeder;
use Modules\Blog\Database\Seeders\DatabaseSeederBlog;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed the default user
        if (User::where('email', 'user@example.com')->doesntExist()) {
            User::create([
                'name' => 'User',
                'email' => 'user@example.com',
                'password' => bcrypt('password'), 
            ]);
        }

        $user = User::create([
            'name'=>'admin',
            'email'=>'admin@gmail.com',
            'password'=>bcrypt('admin')
        ]);

        $zakariaAdmin = User::create([
            'name' => 'Zakaria',
            'email' => 'zakaria@gmail.com',
            'password' => bcrypt('zakaria'), 
        ]);

        // Call other seeders
        $this->call([
            RolePermissionSeeder::class,
            DatabaseSeederBlog::class,
        ]);
        $user->assignRole('admin');
        $zakariaAdmin->assignRole('admin');
    }
}

