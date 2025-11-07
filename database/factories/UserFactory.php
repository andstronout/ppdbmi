<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
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
     */
    public function definition(): array
    {
        $isMale = fake()->boolean();

        if ($isMale) {
            $firstName = fake()->randomElement($this->namaDepanLaki);
        } else {
            $firstName = fake()->randomElement($this->namaDepanPerempuan);
        }

        $lastName = fake()->randomElement($this->namaBelakang);
        $fullName = $firstName . ' ' . $lastName;

        return [
            'name' => $fullName,
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('asd'),
            'role' => 'user',
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
