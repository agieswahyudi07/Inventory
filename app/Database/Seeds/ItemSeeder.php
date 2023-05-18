<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class ItemSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i <= 150; $i++) {

            $faker = \Faker\Factory::create();

            $data = [
                'item_name' => $faker->words(2, true),
                'item_code'    => $faker->regexify('[A-Z]{2}[0-9]{3}'),
                'item_price'    => $faker->randomNumber(5, true),
                'created_at'    => Time::now(),
                'updated_at'    => Time::now(),
            ];

            // Simple Queries
            // $this->db->query('INSERT INTO users (username, email) VALUES(:username:, :email:)', $data);

            // Using Query Builder
            $this->db->table('ms_item')->insert($data);
        }
    }
}
