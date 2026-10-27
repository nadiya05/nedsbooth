<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $name = config('admin.name');
        $email = config('admin.email');
        $password = config('admin.password');

        if (! $email || ! $password) {
            throw new RuntimeException('Set ADMIN_EMAIL and ADMIN_PASSWORD in .env before running the admin seeder.');
        }

        User::updateOrCreate(
            ['email' => $email],
            ['name' => $name ?: 'Administrator', 'password' => Hash::make($password), 'role' => 'admin']
        );

        $this->command?->info("Admin account ready: {$email}");
    }
}
