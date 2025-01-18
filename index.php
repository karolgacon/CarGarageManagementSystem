<?php

session_start();
date_default_timezone_set('Europe/Warsaw');
require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

// Routing configuration
Router::get('', 'DefaultController@index');
Router::get('mainview', 'MainController@index');
Router::get('getCalendarEvents', 'MainController@getCalendarEvents');


// Security routes
Router::get('login', 'SecurityController@login');
Router::post('login', 'SecurityController@login');
Router::get('logout', 'SecurityController@logout');
Router::get('register', 'SecurityController@register');
Router::post('register', 'SecurityController@register');

// User management
Router::get('users', 'UserController@index');
Router::get('users_add', 'UserController@add');
Router::post('users_add', 'UserController@add');
Router::get('users_edit', 'UserController@edit');
Router::post('users_edit', 'UserController@edit');
Router::get('users_delete', 'UserController@delete');

// Inventory management
Router::get('inventory', 'InventoryController@index');
Router::get('inventory_add', 'InventoryController@add');
Router::post('inventory_add', 'InventoryController@add');
Router::get('inventory_edit', 'InventoryController@edit');
Router::post('inventory_edit', 'InventoryController@edit');
Router::get('inventory_delete', 'InventoryController@delete');

// Vehicle management
Router::get('vehicles', 'VehicleController@index');
Router::get('vehicle_add', 'VehicleController@add');
Router::post('vehicle_add', 'VehicleController@add');
Router::get('vehicle_edit', 'VehicleController@edit');
Router::post('vehicle_edit', 'VehicleController@edit');
Router::get('vehicle_delete', 'VehicleController@delete');
Router::get('vehicle_history', 'VehicleController@history');


//Service management
Router::get('services', 'ServiceController@index');
Router::get('service_add', 'ServiceController@add');
Router::post('service_add', 'ServiceController@add');
Router::get('service_edit', 'ServiceController@edit');
Router::post('service_edit', 'ServiceController@edit');
Router::get('service_delete', 'ServiceController@delete');
Router::get('service_mark_completed', 'ServiceController@complete');


Router::get('profile', 'UserController@profile');

//Invoices
Router::get('invoices', 'InvoiceController@index');
Router::post('invoice_generate', 'InvoiceController@generateInvoice');
Router::get('invoice_delete', 'InvoiceController@delete');
Router::get('invoice_mark_paid', 'InvoiceController@markAsPaid');
Router::get('invoice_details', 'InvoiceController@details');
Router::get('invoice_export', 'InvoiceController@exportToPDF');





Router::run($path);