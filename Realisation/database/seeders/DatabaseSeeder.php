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
        if (User::where('email', 'test@example.com')->doesntExist()) {
            User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'), // Or any password you want
            ]);
        }

        $user = User::create([
            'name'=>'admin',
            'email'=>'admin@gmail.com',
            'password'=>bcrypt('admin')
        ]);
        // Call other seeders
        $this->call([
            RolePermissionSeeder::class,// Add Role & permission
            DatabaseSeederBlog::class
        ]);
        $user->assignRole('admin');
    }
}

