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

    public function updateViewsCount(int $postId): void
    {
        $stmt = $this->pdo->prepare("
            UPDATE posts
            SET views = views + 1
            WHERE id = :id;
        ");
        $stmt->execute(['id' => $postId]);
    }

    public function findPostByIdWithSimilar(int $id): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT p.title, p.description, p.content, p.image, p.published_at,
                   c.name AS category_title, c.id as category_id
            FROM posts p
            LEFT JOIN post_category pc ON p.id = pc.post_id
            LEFT JOIN categories c ON c.id = pc.category_id
            WHERE p.id = :id
        ");
        $stmt->execute(['id' => $id]);
        $rawResult = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (!$rawResult) {
            return null;
        }

        $result = [];

        foreach ($rawResult as $rawResultItem) {
            if (!isset($result['title'])) {
                $result['title'] = $rawResultItem['title'];
                $result['description'] = $rawResultItem['description'];
                $result['content'] = $rawResultItem['content'];
                $result['image'] = $rawResultItem['image'];
                $result['published_at'] = $rawResultItem['published_at'];
            }

            $result['categories'][] = [
                'id' => $rawResultItem['category_id'],
                'title' => $rawResultItem['category_title'],
            ];
        }

        $ids = implode(",", array_column(  $result['categories'], 'id'));

        $stmt = $this->pdo->prepare("
            SELECT p.id, p.title, LEFT(p.content, 120) AS short_description, p.published_at, p.image
            FROM posts p
            LEFT JOIN post_category pc ON p.id = pc.post_id            
            WHERE category_id IN ($ids) AND p.id != :id
            ORDER BY p.published_at DESC
            LIMIT 3
        ");

        $stmt->execute(['id' => $id]);
        $rawSimilarResult = $stmt->fetchALL(\PDO::FETCH_ASSOC);

        foreach ($rawSimilarResult as $rawSimilarResultItem) {
            $result['similar'][] = [
                'id' => $rawSimilarResultItem['id'],
                'title' => $rawSimilarResultItem['title'],
                'description' => $rawSimilarResultItem['short_description'],
                'published_at' => $rawSimilarResultItem['published_at'],
                'image' => $rawSimilarResultItem['image'],
            ];
        }

        return $result;
    }

    public function findCategoryById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("
                SELECT c.id, c.name as title, c.description
                FROM categories c
                WHERE c.id = :id
            ");
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getAllPostsByCategory(int $categoryId, int $page = 1, int $perPage = 2, string $sort = 'published_at'): ?array
	{
		if (!in_array($sort, ['views', 'published_at'])) {
			throw new \Exception('Wrong sort');
		}

		$offset = ($page - 1) * $perPage;

		$query = "
			SELECT p.id, p.title, LEFT(p.content, 120) AS description, p.published_at, p.image
			FROM posts p
			JOIN post_category pc ON pc.post_id = p.id AND pc.category_id = :category_id
			ORDER BY p.{$sort} DESC
			LIMIT $offset, $perPage 
		";

		$stmt = $this->pdo->prepare($query);
		$stmt->execute(['category_id' => $categoryId]);
		$posts = $stmt->fetchAll(\PDO::FETCH_ASSOC);

		$query = "
			SELECT COUNT(*) as count
			FROM posts p
			JOIN post_category pc ON pc.post_id = p.id AND pc.category_id = :category_id
		";

		$stmt = $this->pdo->prepare($query);
		$stmt->execute(['category_id' => $categoryId]);
		$count = $stmt->fetch(\PDO::FETCH_ASSOC)['count'] ?? 0;
		$pagesCount = ceil($count / $perPage);

		return [
			'posts' => $posts,
			'pagesCount' => $pagesCount
		];
	}
}