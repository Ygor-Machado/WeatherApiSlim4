<?php

namespace app\controllers;

use Slim\Views\Twig;

/**
 * Classe abstrata base para os controllers da aplicação.
 */
abstract class Controller
{

    /**
     * Obtém uma instância do Twig para renderização de visualizações.
     *
     * @return \Slim\Views\Twig Instância do Twig para renderização de visualizações.
     */
    public function getTwig()
    {
        try {
            // Criar uma instância do Twig
            return Twig::create(DIR_VIEWS);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Configura o nome da visualização adicionando a extensão de visualização.
     *
     * @param string $name Nome da visualização.
     *
     * @return string Nome da visualização com a extensão de visualização.
     */
    // Configurar  o nome da visualização
    public function setView($name)
    {
        return $name . EXT_VIEWS;
    }
}