<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nama' => "Denice",
            "email" => "filbertumbawa@gmail.com",
            "password" => Hash::make("123456"),
            "salt" => Hash::make("123456"),
            "id_level" => "",
            "hp" => "085233534605",
            "photo" => "a.jpg",
            "token" => "",
            "last_logged_in" =>  date('Y-m-d H:i:s', strtotime("2024-04-25 12:03:53")),
            "status" => "aktif",
            "create_user" => "Admin",
            "modified_user" => "Admin",
        ]);
    }
}
