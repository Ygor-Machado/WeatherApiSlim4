<?php

namespace app\controllers;

use Slim\Views\Twig;

abstract class Controller
{

    public function getTwig()
    {
        try {
            // Criar uma instância do Twig
            return Twig::create(DIR_VIEWS);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    // Configurar  o nome da visualização
    public function setView($name)
    {
        return $name . EXT_VIEWS;
    }
}