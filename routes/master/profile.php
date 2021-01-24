<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$router->group(['prefix' => ''], function () use ($router) {
    $router->get('/',  ['as'=>'profile','uses' => 'ProfileController@index']);
    $router->post('/update',  ['as'=>'update-profile','uses' => 'ProfileController@update']);
    $router->post('/update-password',  ['as'=>'update-password','uses' => 'ProfileController@updatePassword']);
    $router->post('/deleteimage',  ['as'=>'deleteimage-profile','uses' => 'ProfileController@deleteimage']);
});