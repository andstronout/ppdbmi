<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Murid;
use App\Models\User; // Import model User

class MuridSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  // ...
  public function run(): void
  {
    $users = User::where('role', 'user')->get();

    foreach ($users as $user) {
      if (!Murid::where('user_id', $user->id)->exists()) {
        Murid::factory()->create([
          'user_id' => $user->id,
          'nama_lengkap' => $user->name, 
        ]);
      }
    }
  }
  // ...
}
