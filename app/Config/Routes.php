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
$routes->post('pos/resume_sale/(:num)', 'Pos::resume_sale/$1');

$routes->get('pos/product_call', 'Pos::product_call');
$routes->post('pos/products', 'Pos::products');
$routes->get('invoice/(:num)', 'PdfController::invoice/$1');
$routes->get('salelist', 'salelist::index');
$routes->get('salereturnlist', 'salereturnlist::index');
$routes->post('ReturnController/getProducts', 'ReturnController::getProducts');
$routes->get('salereturnlistshow', 'salereturnlist::saleReturnListShow');
//ReturnController/process
$routes->post('ReturnController/process', 'ReturnController::process');

$routes->get('product', 'Product::index');
$routes->post('initial-product-create', 'Product::create');
$routes->post('initial-product-update', 'Product::update');
$routes->post('initial-product-delete', 'Product::delete');
$routes->post('initial-product-brand', 'Product::brand_call');

$routes->post('category-create-ajax', 'Product::categoryCreateAjax');
$routes->get('get-category-list', 'Product::getCategoryList');
//brand-create-ajax
$routes->post('brand-create-ajax', 'Product::brandCreateAjax');
$routes->post('group-create-ajax', 'Product::groupCreateAjax');
$routes->post('unit-create-ajax', 'Product::unitCreateAjax');



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
$routes->post('purchase-product', 'Purchase::purchase_product');

$routes->get('Expensecategory', 'Expensecategory::index');
$routes->POST('ExpensecategoryAdd', 'Expensecategory::create');
$routes->POST('ExpensecategoryDelete', 'Expensecategory::delete');
$routes->POST('ExpensecategoryUpdate', 'Expensecategory::update');

$routes->get('Expensesubcategory', 'Expensesubcategory::index');
$routes->POST('ExpensesubcategoryAdd', 'Expensesubcategory::create');
$routes->POST('ExpensesubcategoryUpdate', 'Expensesubcategory::update');
$routes->POST('ExpensesubcategoryDelete', 'Expensesubcategory::delete');

$routes->get('Expense', 'Expense::index');
$routes->POST('ExpenseAdd', 'Expense::create');
$routes->POST('ExpenseUpdate', 'Expense::update');
$routes->POST('ExpenseDelete', 'Expense::delete');

$routes->post('expense/getSubCategory', 'Expense::getSubCategory');

$routes->get('customergroup', 'customergroup::index');
$routes->POST('customergroupAdd', 'customergroup::create');
$routes->POST('customergroupUpdate', 'customergroup::update');
$routes->POST('customergroupDelete', 'customergroup::delete');

$routes->get('customer', 'customer::index');
$routes->POST('customerAdd', 'customer::create');
$routes->POST('customerUpdate', 'customer::update');
$routes->POST('customerDelete', 'customer::delete');

$routes->get('supplier', 'supplier::index');
$routes->POST('supplierAdd', 'supplier::create');
$routes->POST('supplierUpdate', 'supplier::update');
$routes->POST('supplierDelete', 'supplier::delete');


$routes->get('user', 'User::index');
$routes->post('userCreate', 'User::create');
$routes->post('userDelete', 'user::delete');
$routes->post('userUpdate', 'user::update');
//update

$routes->get('role', 'Role::index');
$routes->post('roleCreate', 'Role::create');
$routes->post('roleUpdate', 'Role::updateUserRole');

$routes->get('stockreport', 'Stockreport::index');
$routes->get('purchaseList', 'Stockreport::index');

$routes->get('salesummeryreport', 'SaleSummeryReport::index');
$routes->get('profitloss', 'profitloss::index');
//expensereport
$routes->get('expensereport', 'expensereport::index');
$routes->post('PLReport', 'profitloss::profitlosspdfcreate');

$routes->get('customerreport', 'customerreport::index');

$routes->get('fromcustomer', 'fromcustomer::index');
//generalsettings
$routes->post('customer_received', 'fromcustomer::create');

$routes->get('generalsettings', 'generalsettings::index');
$routes->post('generalsettingsAdd', 'generalsettings::create');
$routes->post('generalsettingsUpdate', 'generalsettings::update');
$routes->post('generalsettingsDelete', 'generalsettings::delete');

$routes->get('currency', 'currency::index');
$routes->post('currencyAdd', 'currency::create');
$routes->post('currencyUpdate', 'currency::update');
$routes->post('currencyDelete', 'currency::delete');

$routes->get('tax', 'tax::index');
$routes->post('taxAdd', 'tax::create');
$routes->post('taxUpdate', 'tax::update');
$routes->post('taxDelete', 'tax::delete');

