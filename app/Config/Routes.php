<?php
use CodeIgniter\Router\RouteCollection;
/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->get('login', 'Login::index');
$routes->post('login/auth', 'Login::auth');
$routes->get('logout', 'Login::logout');
$routes->get('dashboard', 'Dashboard::index');

$routes->get('pos', 'Pos::index');
$routes->post('pos/sale', 'Pos::sale');
$routes->post('pos/hold_sale', 'Pos::hold_sale');
$routes->get('pos/resume_sale/(:num)', 'Pos::resume_sale/$1');

$routes->get('pos/product_call', 'Pos::product_call');
$routes->post('pos/products', 'Pos::products');
$routes->get('invoice/(:num)', 'PdfController::invoice/$1');
$routes->get('salelist', 'salelist::index');
$routes->get('salereturnlist', 'salereturnlist::index');
$routes->get('ReturnController/getProducts', 'ReturnController::getProducts');
$routes->get('salereturnlistshow', 'salereturnlist::saleReturnListShow');

$routes->get('product', 'Product::index');
$routes->get('barcodegenerate', 'barcodegenerate::index');
$routes->post('barcodeprint', 'barcodegenerate::barcodeprint');
$routes->get('productcategoryView', 'Category::index');
$routes->post('productcategoryAdd', 'Category::create');
$routes->post('productcategoryUpdate', 'Category::update');
$routes->post('productcategoryDelete', 'Category::delete');

$routes->get('productbrandView', 'Brand::index');
$routes->post('productbrandAdd', 'Brand::create');
$routes->post('productbrandUpdate', 'Brand::update');
$routes->post('productbrandDelete', 'Brand::delete');

$routes->get('Group', 'Group::index');
$routes->post('groupAdd', 'Group::create');
$routes->post('groupUpdate', 'Group::update');
$routes->post('groupDelete', 'Group::delete');

$routes->get('Unit', 'Unit::index');
$routes->post('unitAdd', 'Unit::create');
$routes->post('unitUpdate', 'Unit::update');
$routes->post('unitDelete', 'Unit::delete');



$routes->get('purchase', 'Purchase::index');

$routes->get('user', 'User::index');
$routes->post('userCreate', 'User::create');

$routes->get('role', 'Role::index');
$routes->post('roleCreate', 'Role::create');
$routes->post('roleUpdate', 'Role::updateUserRole');
