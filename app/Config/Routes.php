<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers\Web');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override('App\Controllers\Errors');
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

/*
 * --------------------------------------------------------------------
 * Web Endpoints
 * --------------------------------------------------------------------
 */

$routes->get('/', 'Auth/Login::index', ['filter' => 'done']);
$routes->get('dashboard', 'Dashboard::index');
$routes->get('users', 'Users::index');
$routes->get('categories', 'Categories::index');
$routes->get('products', 'Products::index');
$routes->get('units', 'Units::index');
$routes->get('clients', 'Clients::index');
$routes->get('purchases', 'Purchases::index');
$routes->get('settings', 'Settings::index');


/*
 * --------------------------------------------------------------------
 * API Endpoints
 * --------------------------------------------------------------------
 */

$routes->group('api', ['namespace' => 'App\Controllers\Api'], function ($routes) {
	$routes->group('auth', function ($routes) {
		$routes->post('signup', 'Auth::signup');
		$routes->post('login', 'Auth::login');
	});

	$routes->group('settings', ['namespace' => 'App\Controllers\Api'], function ($routes) {
		$routes->get('/', 'Settings::index');
		$routes->get('delete/(:num)', 'Settings::delete/$1');
		$routes->get('edit/(:num)', 'Settings::edit/$1');
		$routes->post('/', 'Settings::create');
		$routes->post('update/(:num)', 'Settings::update/$1');
	});

	$routes->group('me', ['namespace' => 'App\Controllers\Api'], function ($routes) {
		$routes->get('/', 'Users::profile');
		$routes->get('logout', 'Auth::logout');
	});

	$routes->group('users', ['namespace' => 'App\Controllers\Api'], function ($routes) {
		$routes->get('/', 'Users::index');
		$routes->get('delete/(:num)', 'Users::delete/$1');
		$routes->get('edit/(:num)', 'Users::edit/$1');
		$routes->post('/', 'Users::create');
		$routes->post('update/(:num)', 'Users::update/$1');
		$routes->post('state/(:num)', 'Users::state/$1');
	});

	$routes->group('rols', ['namespace' => 'App\Controllers\Api'], function ($routes) {
		$routes->get('/', 'Rols::index');
	});

	$routes->group('units', ['namespace' => 'App\Controllers\Api'], function ($routes) {
		$routes->get('/', 'Units::index');
		$routes->get('delete/(:num)', 'Units::delete/$1');
		$routes->get('edit/(:num)', 'Units::edit/$1');
		$routes->post('/', 'Units::create');
		$routes->post('update/(:num)', 'Units::update/$1');
	});

	$routes->group('categories', ['namespace' => 'App\Controllers\Api'], function ($routes) {
		$routes->get('/', 'Categories::index');
		$routes->get('delete/(:num)', 'Categories::delete/$1');
		$routes->get('edit/(:num)', 'Categories::edit/$1');
		$routes->post('/', 'Categories::create');
		$routes->post('update/(:num)', 'Categories::update/$1');
	});

	$routes->group('products', ['namespace' => 'App\Controllers\Api'], function ($routes) {
		$routes->get('/', 'Products::index');
		$routes->get('delete/(:num)', 'Products::delete/$1');
		$routes->get('edit/(:num)', 'Products::edit/$1');
		$routes->post('/', 'Products::create');
		$routes->post('update/(:num)', 'Products::update/$1');
	});

	$routes->group('clients', ['namespace' => 'App\Controllers\Api'], function ($routes) {
		$routes->get('/', 'Clients::index');
		$routes->get('delete/(:num)', 'Clients::delete/$1');
		$routes->get('edit/(:num)', 'Clients::edit/$1');
		$routes->post('/', 'Clients::create');
		$routes->post('update/(:num)', 'Clients::update/$1');
	});

	$routes->group('purchases', ['namespace' => 'App\Controllers\Api'], function ($routes) {
		$routes->get('/', 'Purchases::index');
		$routes->get('delete/(:num)', 'Purchases::delete/$1');
		$routes->get('edit/(:num)', 'Purchases::edit/$1');
		$routes->post('/', 'Purchases::create');
		$routes->post('update/(:num)', 'Purchases::update/$1');
	});

	
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
