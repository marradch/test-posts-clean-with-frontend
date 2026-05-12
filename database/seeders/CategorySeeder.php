<?php

namespace Database\Seeders;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
		$this->pdo->exec('SET FOREIGN_KEY_CHECKS=0');
        $this->pdo->exec('TRUNCATE TABLE categories');
		$this->pdo->exec('TRUNCATE TABLE post_category');
		$this->pdo->exec('TRUNCATE TABLE categories');

		$this->pdo->exec('SET FOREIGN_KEY_CHECKS=1');

        $stmt = $this->pdo->prepare("
            INSERT INTO categories (name, description)
            VALUES (:name, :description)
        ");

        $categories = [
            ['Mammals', 'Articles about mammals and their behavior'],
            ['Birds', 'Interesting facts about birds and their habitats'],
            ['Marine Life', 'Stories from the underwater animal world'],
            ['Wild Predators', 'Information about predators in nature'],
            ['Pets', 'Care tips and guides for domestic animals'],
        ];

        foreach ($categories as [$name, $description]) {
            $stmt->execute([
                'name' => $name,
                'description' => $description
            ]);
        }
    }
}