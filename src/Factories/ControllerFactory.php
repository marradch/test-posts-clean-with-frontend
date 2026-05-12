<?php

namespace App\Factories;

use App\Controller\IndexController;
//use App\Repository\{ProductRepository,CategoryRepository};

class ControllerFactory
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(string $class)
    {
        return match ($class) {
            IndexController::class => new IndexController(
                /*new ProductRepository($this->pdo),
                new CategoryRepository($this->pdo),*/
            ),
            default => throw new \RuntimeException("Unknown controller $class"),
        };
    }
}
