<?php

namespace app\tests\controllers;

use app\controllers\ApiController;
use PHPUnit\Framework\TestCase;

class ApiControllerTest extends TestCase
{
    public function testApiSuccess()
    {

        // Variaveis do teste
        $apiKey = '487f40f29e744ee685640523240102';
        $city = 'Franca';
        $days = 3;

        // Cria um mock do ApiController
        $apiControllerMock = $this->getMockBuilder(ApiController::class)
            ->onlyMethods(['get'])
            ->getMock();

        // Configura o mock para retornar um valor simulado da API
        $apiControllerMock->expects($this->once())
            ->method('get')
            ->with($apiKey, $city, $days)
            ->willReturn([
                'status' => 'success',
                'message' => 'Requisição bem-sucedida',
                'data' => 'Dados simulados da API',
            ]);

        // Chama o método get do mock
        $result = $apiControllerMock->get($apiKey, $city, $days);

        $this->assertEquals('success', $result['status']);
        $this->assertEquals('Requisição bem-sucedida', $result['message']);
        $this->assertEquals('Dados simulados da API', $result['data']);
    }

    public function testApiError()
    {
        $apiKey = '487f40f29e744ee685640523240102';
        $city = 'ErrorCity';
        $days = 3;

        $apiControllerMock = $this->getMockBuilder(ApiController::class)
            ->onlyMethods(['get'])
            ->getMock();

        $apiControllerMock->expects($this->once())
            ->method('get')
            ->with($apiKey, $city, $days)
            ->willReturn([
                'status' => 'error',
                'message' => 'Erro simulado na requisição',
                'data' => null,
            ]);

        $result = $apiControllerMock->get($apiKey, $city, $days);

        // Assertions
        $this->assertEquals('error', $result['status']);
        $this->assertEquals('Erro simulado na requisição', $result['message']);
        $this->assertNull($result['data']);
    }



}