<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test1 User',
            'email' => 'test1@example.com',
        ]);

        Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Admin']);
        $productManager = Role::create(['name' => 'Product Manager']);
        $user = Role::create(['name' => 'User']);
    }
}