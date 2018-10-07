<?php

use core\Route;
use core\Routers;

$routers = new Routers();

$routers->add(Route::get('/', 'Auth\AuthController@loginPage'));

$routers->add(Route::post('/login', 'Auth\AuthController@login'));

$routers->add(Route::get('/logout', 'Auth\AuthController@logout'));

$routers->add(Route::get('/password-reset', 'Auth\AuthController@passwordReset'));

$routers->add(Route::post('/password-reset/put', 'Auth\AuthController@passwordResetPut'));

$routers->add(Route::get('/admin/users/overzicht', 'Admin\UserController@overview'));

$routers->add(Route::get('/admin/users/create', 'Admin\UserController@create'));

$routers->add(Route::post('/admin/users/store', 'Admin\UserController@store'));

$routers->add(Route::get('/admin/users/{id}/edit', 'Admin\UserController@edit'));

$routers->add(Route::post('/admin/users/{id}/put', 'Admin\UserController@put'));

$routers->add(Route::get('/admin/users/{id}/delete', 'Admin\UserController@delete'));

$routers->add(Route::post('/admin/users/{id}/destroy', 'Admin\UserController@destroy'));

$routers->add(Route::post('/admin/users/active-toggle', 'Admin\UserController@activeToggle'));

$routers->add(Route::get('/account', 'Account\AccountController@index'));

$routers->add(Route::get('/account/edit', 'Account\AccountController@edit'));

$routers->add(Route::post('/account/put', 'Account\AccountController@put'));

$routers->resolve();
