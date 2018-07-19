<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('films', 'FilmAPIController', [
    'names' => [
        'index'   => 'film-api-index',
        'store'   => 'film-api-store',
        'create'  => 'film-api-create',
        'show'    => 'film-api-show',
        'edit'    => 'film-api-edit',
        'update'  => 'film-api-update',
        'destroy' => 'film-api-destroy'
    ]
]);
