<?php

session_start();
require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Router::get('', 'DefaultController@index');
Router::post('login', 'SecurityController@login');
Router::post('register', 'SecurityController@register');
Router::post('task_add', 'TaskController@addTask');
Router::get('task_list', 'TaskController@listTasks');
Router::post('task_edit', 'TaskController@editTask');

Router::run($path);