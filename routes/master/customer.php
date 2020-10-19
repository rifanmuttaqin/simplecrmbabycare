<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$router->group(['prefix' => ''], function () use ($router) {
    $router->get('/',  ['as'=>'customer','uses' => 'CustomerController@index']);
    $router->post('/store',  ['as'=>'customer-store','uses' => 'CustomerController@store']);
    $router->post('/update',  ['as'=>'customer-update','uses' => 'CustomerController@update']);
    $router->post('/destroy',  ['as'=>'customer-delete','uses' => 'CustomerController@destroy']);
});