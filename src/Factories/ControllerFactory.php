<?php

namespace App\Factories;

use App\Controller\IndexController;
use App\Repository\CategoryRepository;
use Smarty\Smarty;

class ControllerFactory
{
    private \PDO $pdo;
    private Smarty $smarty;

    public function __construct(\PDO $pdo, Smarty $smarty)
    {
        $this->pdo = $pdo;
        $this->smarty = $smarty;
    }

    public function create(string $class)
    {
        return match ($class) {
            IndexController::class => new IndexController(
                $this->smarty,
                new CategoryRepository($this->pdo)
            ),
            default => throw new \RuntimeException("Unknown controller $class"),
        };
    }
}
