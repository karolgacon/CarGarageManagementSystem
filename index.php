<?php

session_start();
require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Router::get('', 'DefaultController@index');
Router::post('login', 'SecurityController@login');
Router::post('register', 'SecurityController@register');
Router::get('mainview', 'MainController@index');
Router::get('inventory', 'InventoryController@index');
Router::get('inventory_add', 'InventoryController@add');
Router::post('inventory_add', 'InventoryController@add');
Router::get('inventory_edit', 'InventoryController@edit');
Router::post('inventory_edit', 'InventoryController@edit');
Router::get('inventory_delete', 'InventoryController@delete');
Router::get('getCalendarEvents', 'MainController@getCalendarEvents');
Router::get('users', 'UserController@index');
Router::get('users_add', 'UserController@add');
Router::post('users_add', 'UserController@add');
Router::get('users_edit', 'UserController@edit');
Router::post('users_edit', 'UserController@edit');
Router::get('users_delete', 'UserController@delete');
Router::get('logout', 'SecurityController@logout');
Router::get('profile', 'UserController@profile');



Router::run($path);