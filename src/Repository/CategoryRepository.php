<?php

namespace App\Repository;

use PDO;
use App\Entity\Category;

class CategoryRepository
{
    public function __construct(private PDO $pdo) {}

    public function getAllWithActualPosts(): array
    {
        $query = "
            WITH ranked_posts AS (
                SELECT
                    c.id AS category_id,
                    c.name AS category_title,
                    p.id AS post_id,
                    p.title,
                    p.published_at,
                    p.image,
                    LEFT(p.content, 120) AS short_description,
                    ROW_NUMBER() OVER (
                        PARTITION BY c.id
                        ORDER BY p.published_at DESC
                    ) AS rn
                FROM categories c
                JOIN post_category pc ON pc.category_id = c.id
                JOIN posts p ON p.id = pc.post_id
            )
            SELECT *
            FROM ranked_posts
            WHERE rn <= 3
            ORDER BY category_title, published_at DESC;
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        $raw_result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $result = [];

        foreach ($raw_result as $raw_item) {
            if (!isset($result[$raw_item['category_id']])) {
                $result[$raw_item['category_id']] = [
                    'title' => $raw_item['category_title'],
                    'posts' => []
                ];
            }

            $result[$raw_item['category_id']]['posts'][] = [
                'id' => $raw_item['post_id'],
                'title' => $raw_item['title'],
                'published_at' => $raw_item['published_at'],
                'description' => $raw_item['short_description'],
                'image' => $raw_item['image'],
            ];
        }

        return $result;
    }
}