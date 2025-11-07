<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    User::create([
      'name' => 'Admin Utama',
      'email' => 'admin@asd.com',
      'password' => Hash::make('asd'), 
      'role' => 'admin', 
    ]);
    User::create([
      'name' => 'Ketua Yayasan',
      'email' => 'ketua@asd.com',
      'password' => Hash::make('asd'), 
      'role' => 'ketua_yayasan', 
    ]);

    User::factory()->count(15)->create();
  }
}
