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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

/**
 * Routes for resource customer
 */
//$router->get('customer/{id}', 'CustomersController@get');
$router->post('customer', 'CustomersController@add');
//$router->put('customer/{id}', 'CustomersController@put');
//$router->delete('customer/{id}', 'CustomersController@remove');

/**
 * Routes for resource transaction
 */
$router->get('transaction/{customerId}/{transactionId}', 'TransactionsController@get');;
//$router->get('transaction/{customerId}/{date}/{offset}/{limit}', 'TransactionsController@getFilter');
$router->post('transaction', 'TransactionsController@add');
$router->put('transaction/{transactionId}', 'TransactionsController@udate');
$router->delete('transaction/{transactionId}', 'TransactionsController@remove');

