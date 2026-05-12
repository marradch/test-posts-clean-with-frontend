<?php

namespace App\Controller;

//use App\Repository\{CategoryRepository,ProductRepository};
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Smarty\Smarty;

class IndexController
{
    public function __construct(
        /*private ProductRepository $repository,
        private CategoryRepository $categoryRepository,*/
        private Smarty $smarty
    ) {
    }

    public function index(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $this->smarty->assign('title', 'Мой сайт');
            $this->smarty->assign('name', 'Марина');

            $html = $this->smarty->fetch('home.tpl');

            return new HtmlResponse($html, 200);

        } catch (\Throwable $e) {
            return new HtmlResponse(
                '<h1>Error</h1><p>' . htmlspecialchars($e->getMessage()) . '</p>',
                500
            );
        }
    }
}
