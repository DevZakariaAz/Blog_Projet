<?php

namespace Modules\Blog\Database\Seeders;

use Modules\Blog\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeederBlog extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $user = User::create([
            'name'=>'admin1',
            'email'=>'admin1@gmail.com',
            'password'=>bcrypt('admin1')
        ]);
        $user->assignRole('admin');
        // Call other seeders
        $this->call([
            CategorySeeder::class,  // Add CategorySeeder
            TagSeeder::class,       // Add TagSeeder
            ArticleSeeder::class,   // Add ArticleSeeder
            ArticleTagSeeder::class,// Add ArticleTagSeeder
        ]);
    }
}

