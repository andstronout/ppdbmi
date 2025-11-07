<?php

namespace Database\Factories;

use App\Models\Murid;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MuridFactory extends Factory
{
  protected $namaDepanLaki = [
    'Muhammad',
    'Ahmad',
    'Faisal',
    'Rizky',
    'Adam',
    'Zaki',
    'Akbar',
    'Fahmi',
    'Ghazi',
    'Hasan',
    'Rasyid',
    'Rafif',
    'Fikri',
    'Zulfan',
    'Yahya',
    'Daffa',
    'Shiddiq',
    'Iqbal',
    'Nabil',
    'Haikal',
    'Luqman',
    'Hafizh',
    'Irfan',
    'Jafar',
    'Naufal',
    'Sulaiman',
    'Thariq',
    'Yasin',
    'Arif',
    'Malik'
  ];

  /**
   * @var array<int, string>
   */
  protected $namaDepanPerempuan = [
    'Aisyah',
    'Fatimah',
    'Siti',
    'Khadijah',
    'Zahra',
    'Nurul',
    'Salma',
    'Rania',
    'Laila',
    'Husna',
    'Maryam',
    'Aulia',
    'Kamila',
    'Sakinah',
    'Juwairiyah',
    'Yumna',
    'Salsabila',
    'Qanita',
    'Halimah',
    'Azizah',
    'Shafira',
    'Muthia',
    'Rasyida',
    'Zulaikha',
    'Humaira',
    'Khansa',
    'Adiba',
    'Asma',
    'Sofi',
    'Balqis'
  ];

  /**
   * @var array<int, string>
   */
  protected $namaBelakang = [
    'Ramadhan',
    'Hidayat',
    'Al-Fatih',
    'Yusuf',
    'Iman',
    'Khalid',
    'Jannah',
    'Aditya',
    'Pratama',
    'Zulkarnain',
    'Nur',
    'Saputra',
    'Dewi',
    'Kurniawan',
    'Permana',
    'Wijaya',
    'Bastian',
    'Firmansyah',
    'Amin',
    'Putri'
  ];


  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $jenisKelamin = fake()->randomElement(['Laki-laki', 'Perempuan']);
    if ($jenisKelamin == 'Laki-laki') {
      $firstName = fake()->randomElement($this->namaDepanLaki);
    } else {
      $firstName = fake()->randomElement($this->namaDepanPerempuan);
    }
    $lastName = fake()->randomElement($this->namaBelakang);
    $fullName = $firstName . ' ' . $lastName;
    $namaAyah = fake()->name('male');
    $namaIbu = fake()->name('female');
    return [
      'user_id' => User::factory(),
      'nama_lengkap' => $fullName,
      'nik' => fake()->unique()->numerify('1###############'),
      'tempat_lahir' => fake()->city(),
      'tanggal_lahir' => fake()->dateTimeBetween('-10 years', '-6 years')->format('Y-m-d'),
      'jenis_kelamin' => $jenisKelamin,
      'npsn' => null,
      'nama_ayah' => $namaAyah,
      'nama_ibu' => $namaIbu,
      'no_whatsapp' => '08' . fake()->numerify('##########'), 
      'kartu_keluarga' => null,
      'akte' => null,
      'tahun_masuk' => date('Y'),
      'status' => 'Checking',
      'catatan' => null,
    ];
  }
}
