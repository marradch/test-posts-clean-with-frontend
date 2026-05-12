<?php

namespace Database\Seeders;

use PDO;

abstract class Seeder
{
    public function __construct(
        protected PDO $pdo
    ) {}

    abstract public function run(): void;
}