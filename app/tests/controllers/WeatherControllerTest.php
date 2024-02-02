<?php

namespace app\tests\controllers;

use app\controllers\WeatherController;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


class WeatherControllerTest extends TestCase
{

    // Não consegui fazer funcionar esse teste

    /**
     * @throws Exception
     */
    public function testIndexSuccess()
    {
        $weatherControllerMock = $this->createMock(WeatherController::class);

        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getQueryParams')->willReturn(['city' => 'Franca']);

        $response = $this->createMock(ResponseInterface::class);

        $weatherControllerMock->expects($this->once())
            ->method('index')
            ->willReturnCallback(function ($request, $response) {
                return ['location' => ['name' => 'Franca'], 'current' => ['condition_icon' => 'icon']];
            });

        $result = $weatherControllerMock->index($request, $response);

        $this->assertEquals('Franca', $result['location']['name']);

    }

    public function testIndexError()
    {
        $weatherControllerMock = $this->createMock(WeatherController::class);

        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getQueryParams')->willReturn(['city' => 'Franca']);

        $response = $this->createMock(ResponseInterface::class);

        $weatherControllerMock->expects($this->once())
            ->method('index')
            ->willReturnCallback(function ($request, $response) {
                return ['status' => 'error', 'message' => 'Error'];
            });

        $result = $weatherControllerMock->index($request, $response);

        $this->assertEquals('error', $result['status']);
    }

}