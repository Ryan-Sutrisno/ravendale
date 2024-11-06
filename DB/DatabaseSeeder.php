<?php

require "./vendor/autoload.php";

class DatabaseSeeder extends Database
{

    public function __construct()
    {
        $this->run(2);
        // $this->drop();
    }

    public function run(int $amount)
    {
        $faker = Faker\Factory::create();
        $data = [];
        for ($i = 0; $i < $amount; $i++) {
            $data[] = [
                'name' => $faker->word,
                'description' => $faker->paragraph,
            ];
        }

        $this->seedTable('categories', ['name', 'description'], $data);
    }

    public function drop()
    {
        $this->dropTable('categories');
    }
}

new DatabaseSeeder;