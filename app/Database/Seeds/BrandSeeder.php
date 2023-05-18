<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class BrandSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i <= 50; $i++) {

            $faker = \Faker\Factory::create();

            $data = [
                'brand_name' => $faker->company(),
                'brand_code'    => $faker->randomNumber(5, true),
                'created_at'    => Time::now(),
                'updated_at'    => Time::now(),
            ];

            // Simple Queries
            // $this->db->query('INSERT INTO users (username, email) VALUES(:username:, :email:)', $data);

            // Using Query Builder
            $this->db->table('ms_brand')->insert($data);
        }
    }
}
