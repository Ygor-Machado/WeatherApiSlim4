<?php

// Carrega o autoload do composer
require __DIR__ . '/../vendor/autoload.php';

// Instanciar o slim
use Slim\Factory\AppFactory;

$app = AppFactory::create();

// Configurações e rotas
require __DIR__ . '/../app/helpers/config.php';
require __DIR__ . '/../app/routes/routes.php';

// Executa o slim
$app->run();