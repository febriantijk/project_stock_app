<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use faker\Factory as faker;
use Illuminate\Support\Facades\DB;

class pelangganseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $data = [];

        for ($i = 1; $i <= 10; $i++) {
            $data[] = [
                'nama_pelanggan' => $faker->name,
                'telp' => $faker->numerify($faker->randomElement([
                    '08##########',
                    '08###########',
                    '08############',

                ])),

                'jenis_kelamin' => $faker->randomElement([
                    'Laki-laki',
                    'Perempuan',

                ]),
                'alamat' => $faker->address,
                'kota' => $faker->city,
                'provinsi' => $faker->state,
            ];
    }
    DB::table('pelanggans')->insert($data);
}
}
