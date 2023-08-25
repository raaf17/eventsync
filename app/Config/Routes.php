<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->get('create-db', function() {
    $forge = \Config\Database::forge();
    if ($forge->createDatabase('yuknikah')) {
        echo 'Database created!';
    }
});


$routes->get('login', 'Auth::login');
$routes->post('auth/loginProcess', 'Auth::loginProcess');
$routes->get('auth/logout', 'Auth::logout');
// $routes->get('/', 'Home::index');
$routes->addRedirect('/', 'home');
$routes->get('home', 'Home::index');

$routes->get('gawe', 'Gawe::index');
$routes->get('gawe/add', 'Gawe::create');
$routes->post('gawe', 'Gawe::store');
$routes->get('gawe/edit/(:num)', 'Gawe::edit/$1');
$routes->put('gawe/(:any)', 'Gawe::update/$1');
$routes->delete('gawe/(:segment)', 'Gawe::destroy/$1');

$routes->get('groups/trash', 'Groups::trash');
$routes->get('groups/restore/(:any)', 'Groups::restore/$1');
$routes->get('groups/restore', 'Groups::restore');
// $routes->delete('groups/delete2/(:any)', 'Groups::delete/$1');
// $routes->delete('groups/delete2/', 'Groups::delete2');
$routes->post('groups/delete2/(:num)', 'Groups::delete2/$1');
$routes->post('groups/delete2', 'Groups::delete2');


$routes->presenter('groups', ['filter' => 'isLoggedIn']);

$routes->get('contacts/export', 'Contacts::export', ['filter' => 'isLoggedIn']);
$routes->post('contacts/import', 'Contacts::import', ['filter' => 'isLoggedIn']);
$routes->resource('contacts', ['filter' => 'isLoggedIn']);

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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
