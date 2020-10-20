<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Layanan Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$router->group(['prefix' => ''], function () use ($router) {
    $router->get('/',  ['as'=>'layanan','uses' => 'LayananController@index']);
    $router->post('/store',  ['as'=>'layanan-store','uses' => 'LayananController@store']);
    $router->post('/update',  ['as'=>'layanan-update','uses' => 'LayananController@update']);
    $router->post('/destroy',  ['as'=>'layanan-delete','uses' => 'LayananController@destroy']);
});