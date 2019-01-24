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

/*
 * GUI
 */

$router->group(
    ['prefix' => 'gui','middleware' => 'BasicAuth'],
    function() use ($router) {
        $router->get('/', 'GuiController@index');
        $router->get('json', 'GuiController@json');
    });




/*
 * login
 */
$router->post(
    'auth/login',
    [
        'uses' => 'AuthController@authenticate'
    ]
);


$router->group(
    ['middleware' => 'jwt.auth'],
    function() use ($router) {
        $router->post('customer', 'CustomersController@add');
    });

/**
 * Routes for resource transaction
 */
$router->group(
    ['prefix' => 'transaction','middleware' => 'jwt.auth'],
    function() use ($router) {
        $router->get('{customerId}/{transactionId}', 'TransactionsController@get');
        $router->get('/', 'TransactionsController@getFilter');
        $router->post('/', 'TransactionsController@add');
        //change whole (or create) PUT
        //change only one field PATCH  (can be not safe)
        $router->patch('{transactionId}', 'TransactionsController@updateAmount');
        $router->delete('{transactionId}', 'TransactionsController@remove');
    });


