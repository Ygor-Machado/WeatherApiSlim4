<?php

namespace app\controllers;

use Psr\Http\Message\ResponseInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class WeatherController extends Controller
{
    /**
     * Exibe o tempo de uma cidade especifica.
     *
     * Este método recebe uma solicitação e uma resposta, obtém os dados da previsão do tempo usando a classe ApiController,
     * formata os dados e os passa para a visualização Twig para renderização.
     *
     * @param mixed $request O objeto de solicitação (ServerRequestInterface).
     * @param mixed $response O objeto de resposta (ResponseInterface).
     *
     * @throws RuntimeError Em caso de erro durante a execução do Twig.
     * @throws SyntaxError Em caso de erro de sintaxe durante a execução do Twig.
     * @throws LoaderError Se o carregador do Twig encontrar um erro ao carregar modelos.
     *
     * @return ReponseInterface Retorna o conteúdo renderizado da visualização.
     */
    public function index($request, $response): ResponseInterface
    {

        // Pega o valor de city, ou Franca ou qualquer outra cidade que colocar aqui como padrão
        $city = $_GET['city'] ?? 'Franca';

        // Definir o padrão de dias para a previsão do tempo
        $days = 5;

        // Chama o método get da classe ApiController para obter os dados
        $results = (new ApiController)->get($city, $days);

        // Veficar o erro na chamada da API
        if($results['status'] === 'error') {
            echo $results['message'];
            exit;
        }

        // Decodifica os dados da API
        $data = json_decode($results['data'], true);

        // Cria um array com os dados da localização
        $location = [];
        $location['name'] = $data['location']['name'];
        $location['region'] = $data['location']['region'];
        $location['country'] = $data['location']['country'];
        $location['current_time'] = $data['location']['localtime'];

        // Cria um array com os dados do clima atual
        $current = [];
        $current['info'] = 'Agora:';
        $current['temperature'] = $data['current']['temp_c'];
        $current['condition'] = $data['current']['condition']['text'];
        $current['condition_icon'] = $data['current']['condition']['icon'];
        $current['humidity']    = $data['current']['humidity'];

        // Cria um array com os dados da previsão do tempo
        $forecast = array_map(function ($day) {
            return [
                'info'           => null,
                'date'           => $day['date'],
                'condition'      => $day['day']['condition']['text'],
                'condition_icon' => $day['day']['condition']['icon'],
                'max_temp'       => $day['day']['maxtemp_c'],
                'min_temp'       => $day['day']['mintemp_c'],
                'max_wind'       => $day['day']['maxwind_kph'],
                'humidity'       => $day['day']['avghumidity'],
            ];
        }, $data['forecast']['forecastday']);

        // Renderiza a view passando os dados para ela
        return $this->getTwig()->render($response, $this->setView('api/index'), [
            'location' => $location,
            'current'  => $current,
            'forecast' => $forecast,
            'days'     => $days,
        ]);

    }
}