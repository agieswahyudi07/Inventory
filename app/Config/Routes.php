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
$routes->setDefaultController('Dashboard');
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
$routes->get('/', 'Item\Item::index');
$routes->get('/Item/Item', 'Item\Item::index');
$routes->get('/Category/Category', 'Category\Category::index');
$routes->get('/Brand/Brand', 'Brand\Brand::index');
$routes->get('/Type/Type', 'Type\Type::index');

// Add user form
$routes->get('Item/add', 'Item\Item::add');
$routes->post('Item/saveAdd', 'Item\Item::save');
$routes->get('Category/add', 'Category\Category::add');
$routes->post('Category/saveAdd', 'Category\Category::save');
$routes->get('Brand/add', 'Brand\Brand::add');
$routes->post('Brand/saveAdd', 'Brand\Brand::save');
$routes->get('Type/add', 'Type\Type::add');
$routes->post('Type/saveAdd', 'Type\Type::save');

// Edit user form
$routes->get('Item/edit/(:num)', 'Item\Item::edit/$1');
$routes->post('Item/edit/saveEdit/(:num)', 'Item\Item::update/$1');
$routes->post('saveEdit/(:num)', 'Item\Item::update/$1');
$routes->get('Category/edit/(:num)', 'Category\Category::edit/$1');
$routes->post('Category/edit/saveEdit/(:num)', 'Category\Category::update/$1');
$routes->get('Brand/edit/(:num)', 'Brand\Brand::edit/$1');
$routes->post('Brand/edit/saveEdit/(:num)', 'Brand\Brand::update/$1');
$routes->get('Type/edit/(:num)', 'Type\Type::edit/$1');
$routes->post('Type/edit/saveEdit/(:num)', 'Type\Type::update/$1');

// Delete user
$routes->get('Item/delete/(:num)', 'Item\Item::delete/$1');
$routes->get('Category/delete/(:num)', 'Category\Category::delete/$1');
$routes->get('Brand/delete/(:num)', 'Brand\Brand::delete/$1');
$routes->get('Type/delete/(:num)', 'Type\Type::delete/$1');

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
