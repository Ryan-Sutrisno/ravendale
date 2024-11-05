<?php

require "./vendor/autoload.php";

class DatabaseSeeder extends Database
{
    public function seedCategories()
    {
        $faker = Faker\Factory::create();
        $categories = [];
        for ($i = 0; $i < 10; $i++) {
            $categories[] = [
                'name' => $faker->word,
                'description' => $faker->paragraph,
            ];
        }

        $this->seedTable('categories', ['name', 'description'], $categories);
    }
}

$seeder = new DatabaseSeeder();
$seeder->seedCategories();