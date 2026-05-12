<?php

namespace Database\Seeders;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $this->pdo->exec('SET FOREIGN_KEY_CHECKS=0');
        $this->pdo->exec('TRUNCATE TABLE post_category');
        $this->pdo->exec('TRUNCATE TABLE posts');
        $this->pdo->exec('SET FOREIGN_KEY_CHECKS=1');

        $stmt = $this->pdo->prepare("
            INSERT INTO posts
            (image, title, description, content, views, published_at)
            VALUES
            (:image, :title, :description, :content, :views, :published_at)
        ");

        $pivot = $this->pdo->prepare("
            INSERT INTO post_category
            (post_id, category_id)
            VALUES
            (:post_id, :category_id)
        ");

        function random_date($from = '-2 years', $to = 'now'): string {
            return date('Y-m-d', rand(strtotime($from), strtotime($to)));
        }

        $posts = [

            [
                'image' => '/img/lion.jpeg',
                'title' => 'The Life of Lions',
                'description' => 'How lions survive in the wild',
                'content' => 'Lions live in prides and are among the most social big cats...',
                'views' => 320,
                'categories' => [1, 4],
                'published_at' => random_date(),
            ],

            [
                'image' => '/img/dolphin.jpeg',
                'title' => 'Dolphins and Their Intelligence',
                'description' => 'Amazing facts about dolphins',
                'content' => 'Dolphins are highly intelligent marine mammals...',
                'views' => 410,
                'categories' => [1, 3],
                'published_at' => random_date(),
            ],

            [
                'image' => '/img/eagle.jpeg',
                'title' => 'Eagles: Kings of the Sky',
                'description' => 'Birds of prey and their hunting skills',
                'content' => 'Eagles have exceptional eyesight and powerful talons...',
                'views' => 275,
                'categories' => [2, 4],
                'published_at' => random_date(),
            ],

            [
                'image' => '/img/parrot.jpeg',
                'title' => 'Parrots as Pets',
                'description' => 'How to care for parrots',
                'content' => 'Parrots require mental stimulation and social interaction...',
                'views' => 190,
                'categories' => [2, 5],
                'published_at' => random_date(),
            ],

            [
                'image' => '/img/shark.jpg',
                'title' => 'Sharks of the Deep Ocean',
                'description' => 'Understanding marine predators',
                'content' => 'Sharks have existed for over 400 million years...',
                'views' => 520,
                'categories' => [3, 4],
                'published_at' => random_date(),
            ],

            [
                'image' => '/img/dog.jpeg',
                'title' => 'Why Dogs Are Loyal',
                'description' => 'The bond between humans and dogs',
                'content' => 'Dogs evolved alongside humans for thousands of years...',
                'views' => 610,
                'categories' => [5, 1],
                'published_at' => random_date(),
            ]
        ];

        foreach ($posts as $post) {
            $stmt->execute([
                'image' => $post['image'],
                'title' => $post['title'],
                'description' => $post['description'],
                'content' => $post['content'],
                'views' => $post['views'],
                'published_at' => $post['published_at']
            ]);

            $postId = $this->pdo->lastInsertId();

            foreach ($post['categories'] as $categoryId) {
                $pivot->execute([
                    'post_id' => $postId,
                    'category_id' => $categoryId
                ]);
            }
        }
    }
}