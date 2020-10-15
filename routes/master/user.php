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
	$router->get('/',  ['as'=>'index-user','uses' => 'UserController@index']);
    $router->post('/get-detail',  ['as'=>'user-detail','uses' => 'UserController@show']);
    $router->post('/list-user',  ['as'=>'list-user','uses' => 'UserController@listUser']);
    $router->post('/update',  ['as'=>'update-user','uses' => 'UserController@update']);
    $router->post('/store',  ['as'=>'store-user','uses' => 'UserController@store']);
    $router->get('/create',  ['as'=>'create-user','uses' => 'UserController@create']);
    $router->post('/update-password',  ['as'=>'update-password-user','uses' => 'UserController@updatePassword']);
    $router->post('/delete',  ['as'=>'delete-user','uses' => 'UserController@destroy']);
});