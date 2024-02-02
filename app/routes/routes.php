<?php

use app\controllers\WeatherController;

$app->get('/weather', WeatherController::class . ':index');