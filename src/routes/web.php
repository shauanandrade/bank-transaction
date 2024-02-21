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


$router->get('users',['uses'=>'UsersController@findAll']);
$router->get('users/{cpf_cnpj}',['uses'=>'UsersController@findByCpfOrCnpj']);
$router->post('users/common',['uses'=>'UsersController@createCommonUser']);
$router->post('users/shopkeeper',['uses'=>'UsersController@createShopkeeperUser']);
$router->post('transaction',['uses'=>'TransactionsController@transaction']);
$router->get('transaction/extract/{id}',['uses'=>'TransactionsController@extract']);
