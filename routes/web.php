<?php

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

/** @var $router vai ser passado para ser utilizado dentro da função */

use App\Http\Controllers\EpisodiosController;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

# Criando um grupo de rotas, para utilização do prefix '/api'
$router->group([ "prefix" => "/api" ], function () use ($router) {

    $router->group( ['prefix' => '/series'], function () use ($router) {
        # As rotas do grupo listada abaixo
        // Inserindo o Controller SeriesController com o method index
        $router->get('', 'SeriesController@index');
        // Criando uma rota para cadastro de series
        $router->post('', 'SeriesController@store');
        // Buscando apenas 1 registro pelo seu id
        $router->get('{id}', 'SeriesController@show');
        // Atualizar uma Serie atraves do ID
        $router->put('{id}', 'SeriesController@update');
        // Remover uma Serie pelo ID
        $router->delete('{id}', 'SeriesController@destroy');

        // Busca de Episodios por serie
        $router->get('{id}/episodios', 'EpisodiosController@buscaPorSerie');
    });

    $router->group( ['prefix' => '/episodios'], function () use ($router) {
        # As rotas do grupo listada abaixo
        // Inserindo o Controller EpisodiosController com o method index
        $router->get('', 'EpisodiosController@index');
        // Criando uma rota para cadastro de Episodios
        $router->post('', 'EpisodiosController@store');
        // Buscando apenas 1 registro pelo seu id
        $router->get('{id}', 'EpisodiosController@show');
        // Atualizar uma Serie atraves do ID
        $router->put('{id}', 'EpisodiosController@update');
        // Remover uma Serie pelo ID
        $router->delete('{id}', 'EpisodiosController@destroy');
    });

});

// Criar fora do middleware de auth
$router->post('/api/login', 'TokenController@gerarToken');

// Teste simples de rota
// $router->get('/series', function () {
//     return [
//         "Gray's Anatomy",
//         "Lost"
//     ];
// });