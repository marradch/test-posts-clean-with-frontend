<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Smarty\Smarty;

class IndexController
{
    public function __construct(
        private Smarty $smarty,
        private CategoryRepository $categoryRepository
    ) {
    }

    public function index(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $categoriesData = $this->categoryRepository->getAllWithActualPosts();

            $html = $this->smarty->fetch('home.tpl', ['categoriesData' => $categoriesData]);

            return new HtmlResponse($html, 200);

        } catch (\Throwable $e) {
            return new HtmlResponse(
                '<h1>Error</h1><p>' . htmlspecialchars($e->getMessage()) . '</p>',
                500
            );
        }
    }

    public function showPost(ServerRequestInterface $request, array $route_vars = []): ResponseInterface
    {
        try {
            $id = (int) $route_vars['id'];

            if ($id <= 0) {
                return new HtmlResponse(
                    '<h1>Error</h1><p>Not Found</p>',
                    404
                );
            }

            $this->categoryRepository->updateViewsCount($id);
            $postData = $this->categoryRepository->findPostByIdWithSimilar($id);
            if (empty($postData)) {
                return new HtmlResponse(
                    '<h1>Error</h1><p>Not Found</p>',
                    404
                );
            }
            $html = $this->smarty->fetch('post.tpl', ['postData' => $postData]);

            return new HtmlResponse($html, 200);

        } catch (\Throwable $e) {
            return new HtmlResponse(
                '<h1>Error</h1><p>' . htmlspecialchars($e->getMessage()) . '</p>',
                500
            );
        }
    }

    public function showCategory(ServerRequestInterface $request, array $route_vars = []): ResponseInterface
    {
        try {
            $id = (int) $route_vars['id'];

            if ($id <= 0) {
                return new HtmlResponse(
                    '<h1>Error</h1><p>Not Found</p>',
                    404
                );
            }

            $page = (int)($request->getQueryParams()['page'] ?? 1);
            $sort = ($request->getQueryParams()['sort'] ?? 'published_at');
            $perPage = 2;

            $category = $this->categoryRepository->findCategoryById($id);
            $postsData = $this->categoryRepository->getAllPostsByCategory($id, $page, $perPage, $sort);

            $html = $this->smarty->fetch('category.tpl', ['category' => $category, 'posts' => $postsData['posts'], 'pagesCount' => $postsData['pagesCount'], 'currentPage' => $page]);

            return new HtmlResponse($html, 200);

        } catch (\Throwable $e) {
            return new HtmlResponse(
                '<h1>Error</h1><p>' . htmlspecialchars($e->getMessage()) . '</p>',
                500
            );
        }
    }
}
