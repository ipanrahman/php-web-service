<?php

require __DIR__ . '/../routes/api.php';

require __DIR__ . '/../config/view.php';

$twigLoader = new Twig\Loader\FilesystemLoader(
    __DIR__ . '/../resources/views'
);

$envPath = __DIR__ . '/../.env';
if (file_exists($envPath)) {
    $dotenv = Dotenv\Dotenv::createImmutable(
        __DIR__ . '/../',
        '.env'
    );
    $dotenv->load();
}

$twig = new Twig\Environment($twigLoader, [
    'cache' => __DIR__ . '/../storage/cache',
]);