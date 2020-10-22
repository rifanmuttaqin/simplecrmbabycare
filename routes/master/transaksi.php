<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Transaksi Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$router->group(['prefix' => ''], function () use ($router) {
    $router->get('/',  ['as'=>'transaksi','uses' => 'TransaksiController@index']);
    $router->post('/store',  ['as'=>'transaksi-store','uses' => 'TransaksiController@store']);
});