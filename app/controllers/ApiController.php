<?php

namespace app\controllers;

class ApiController extends Controller
{
    /**
     * @param string $city A cidade para a qual deseja obter a previsão do tempo
     * @param int $days Quantidade de dias para a previsão do tempo
     * @return array Retorna um array com os dados da previsão do tempo.
     */
    public  function get($city, $days = 1): array
    {
        // Inicializa uma sessão cURL
        $curl = curl_init();

        // Configura as opções do cURL
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.weatherapi.com/v1/forecast.json?key=" .API_KEY. "&q=" . $city. "&days=" . $days,
            CURLOPT_RETURNTRANSFER => true, // Retorna o resultado como string
            CURLOPT_CUSTOMREQUEST => 'GET', // Método de requisição
            CURLOPT_SSL_VERIFYPEER => false, // Não verificar o SSL, não usar em produção
        ));

        // Executa o cURL e armazena na variavel
        $response = curl_exec($curl);

        // Verifica os erros e armazena na variavel
        $err = curl_error($curl);

        // Fecha a sessão cURL
        curl_close($curl);

        // Retorna um array com os dados
        return [
            'status'  => $err ? 'error' : 'success',
            'message' => $err,
            'data'    => $err ? null : $response,
        ];
    }
}