<?php

namespace app\controllers;

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class WeatherController extends Controller
{
    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function index($request, $response)
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