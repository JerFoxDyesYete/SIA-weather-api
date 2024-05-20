<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//predefined location value = philippines

$router->get('/weather', 'WeatherController@getCurrentWeather'); //get the current weather specified location
$router->get('/weather-forecast', 'WeatherController@getForecast'); //get 3 day forecast weather specified location
$router->get('weather-history', 'WeatherController@getHistory'); // get weather history specified location




