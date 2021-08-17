<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

$routes->group('stok', ['filter' => 'role:Admin'], function ($routes) {
	$routes->get('index', 'stok::index');
	$routes->get('/', 'stok::index');
	$routes->get('create', 'stok::create');
	$routes->get('edit/(:segment)', 'stok::edit/$1');
	$routes->delete('delete', 'stok::delete');
});

$routes->group('masuk', function ($routes) {
	$routes->get('index', 'masuk::index');
	$routes->get('/', 'masuk::index');
	$routes->get('create', 'masuk::create');
	$routes->get('edit/(:num)', 'masuk::edit/$1');
	$routes->delete('delete', 'masuk::delete');
});

$routes->group('users', ['filter' => 'role:Admin'], function ($routes) {
	$routes->get('index', 'users::index');
	$routes->get('/', 'users::index');
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
