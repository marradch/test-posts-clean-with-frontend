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

            //echo '<pre>'; var_dump($categoriesData); die;
            $html = $this->smarty->fetch('home.tpl', ['categoriesData' => $categoriesData]);

            return new HtmlResponse($html, 200);

        } catch (\Throwable $e) {
            return new HtmlResponse(
                '<h1>Error</h1><p>' . htmlspecialchars($e->getMessage()) . '</p>',
                500
            );
        }
    }
}
