<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$required = [
    'DB_CONNECTION',
    'DB_HOST',
    'DB_PORT',
    'DB_NAME',
    'DB_USER',
    'DB_PASS'
];

foreach ($required as $key) {
    if (empty($_ENV[$key])) {
        die("Missing env: {$key}\n");
    }
}

$pdo = new PDO(
    sprintf(
        '%s:host=%s;port=%s;dbname=%s;charset=utf8mb4',
        $_ENV['DB_CONNECTION'],
        $_ENV['DB_HOST'],
        $_ENV['DB_PORT'],
        $_ENV['DB_NAME']
    ),
    $_ENV['DB_USER'],
    $_ENV['DB_PASS'],
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
);

$seeders = [
    \Database\Seeders\CategorySeeder::class,
    \Database\Seeders\PostSeeder::class,
];

foreach ($seeders as $seeder) {
    echo "Running {$seeder}...\n";

    (new $seeder($pdo))->run();

    echo "Done\n";
}