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


$router->get('user',['uses'=>'UsersController@findAll']);
$router->get('user/{cpf_cnpj}',['uses'=>'UsersController@findByCpfOrCnpj']);
$router->post('user',['uses'=>'UsersController@createCommonUser']);
$router->post('user/shopkeeper',['uses'=>'UsersController@createShopkeeperUser']);
$router->post('transaction',['uses'=>'TransactionsController@transaction']);
$router->get('transaction/extract/{id}',['uses'=>'TransactionsController@extract']);
