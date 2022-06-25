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

// $router->get('file', [
//     'as' => '/file', 'uses' => 'FileController@readFile'
// ]);
$router->get('/file','FileController@readFile');
// $Route::get('/file/{filename}', 'FileController@writeFile');

$router->post('/register','AuthController@register');
$router->post('/login','AuthController@login');
$router->get('/showalldatauser','CrudUserController@ShowAllUser');
$router->get('/showdetailuser/{id}','CrudUserController@ShowDetailUser');
$router->put('/updateuser/{id}','CrudUserController@updateUser');
$router->delete('/deleteuser/{id}','CrudUserController@DeleteUser');

$router->post('/TambahObat','productObatController@InsertObat');
$router->get('/showalldataobat','productObatController@ShowAllDataObat');
$router->get('/detailobat/{id}','productObatController@DetailObat');
$router->put('/updateobat/{id}','productObatController@UpdateObat');
$router->delete('/deleteobat/{id}','productObatController@DeleteObat');