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

$routes->group('pos', function ($routes) {
    $routes->get('/', 'PosController::index');
    $routes->post('sale', 'PosController::sale');
    $routes->post('hold-sale', 'PosController::hold_sale');
    $routes->post('resume-sale/(:num)', 'PosController::resume_sale/$1');
    $routes->post('delete-held-sale/(:num)', 'PosController::delete_held_sale/$1');
    $routes->post('update-hold-sale', 'PosController::update_hold_sale');
    //$routes->post('products', 'PosController::products');
    $routes->post('filterProducts', 'PosController::filterProducts');
    $routes->get('product-search', 'PosController::productSearch');

});

$routes->get('invoice/(:num)', 'PdfController::invoice/$1');
$routes->get('salelist', 'salelist::index');
$routes->get('salereturnlist', 'salereturnlist::index');
$routes->post('ReturnController/getProducts', 'ReturnController::getProducts');
$routes->get('salereturnlistshow', 'salereturnlist::saleReturnListShow');
//ReturnController/process
$routes->post('ReturnController/process', 'ReturnController::process');

$routes->group('products', function ($routes) {
    $routes->get('opening-stock', 'ProductController::index');
    $routes->post('create', 'ProductController::create');
    $routes->post('update', 'ProductController::update');
    $routes->post('delete', 'ProductController::delete');
    $routes->get('search', 'PosController::productSearch');
});

$routes->group('barcode', function ($routes) {
    $routes->get('/', 'BarcodeGenerateController::index');
    $routes->post('print', 'BarcodeGenerateController::barcodeprint');
});

$routes->group('categories', function ($routes) {

    $routes->get('/', 'ProductCategoryController::index');
    $routes->post('create', 'ProductCategoryController::create');
    $routes->post('update', 'ProductCategoryController::update');
    $routes->post('delete', 'ProductCategoryController::delete');
    $routes->post('category-create-ajax', 'ProductCategoryController::categoryCreateAjax'); // From view/product/NewProductAdd.php
    $routes->get('get-category-list', 'ProductCategoryController::getCategoryList'); // From view/product/NewProductAdd.php

});

$routes->group('brands', function ($routes) {
    $routes->get('/', 'ProductBrandController::index');
    $routes->post('create', 'ProductBrandController::create');
    $routes->post('update', 'ProductBrandController::update');
    $routes->post('delete', 'ProductBrandController::delete');
    $routes->post('brand-create-ajax', 'ProductBrandController::brandCreateAjax'); //From Views/product/NewProductAdd.php
    $routes->post('initial-product-brand', 'ProductBrandController::brand_call'); //From Views/product/NewProductAdd.php

});

$routes->group('groups', function ($routes) {
    $routes->get('/', 'ProductGroupController::index');
    $routes->post('create', 'ProductGroupController::create');
    $routes->post('update', 'ProductGroupController::update');
    $routes->post('delete', 'ProductGroupController::delete');
    $routes->post('group-create-ajax', 'ProductGroupController::groupCreateAjax'); //From Views/product/NewProductAdd.php

});

$routes->group('units', function ($routes) {
    $routes->get('/', 'ProductUnitController::index');
    $routes->post('create', 'ProductUnitController::create');
    $routes->post('update', 'ProductUnitController::update');
    $routes->post('delete', 'ProductUnitController::delete');
    $routes->post('unit-create-ajax', 'ProductUnitController::unitCreateAjax'); //From Views/product/NewProductAdd.php

});

$routes->group('purchase', function ($routes) {
    $routes->get('/', 'PurchaseController::index');
    $routes->post('purchase-product', 'PurchaseController::purchase_product');

});

$routes->post('strengthCreateAjax', 'ProductStrengthController::strengthCreateAjax');

$routes->group('expense', function ($routes) {
    $routes->get('/', 'ExpenseController::index');
    $routes->POST('create', 'ExpenseController::create');
    $routes->POST('update', 'ExpenseController::update');
    $routes->POST('delete', 'ExpenseController::delete');
    $routes->POST('getSubCategory', 'ExpenseController::getSubCategory'); //From Views/expense/expense_add.php

});

$routes->group('expenseCategory', function ($routes) {

    $routes->get('/', 'ExpenseCategoryController::index');
    $routes->POST('create', 'ExpenseCategoryController::create');
    $routes->POST('update', 'ExpenseCategoryController::update');
    $routes->POST('delete', 'ExpenseCategoryController::delete');
});

$routes->group('Expensesubcategory', function ($routes) {

    $routes->get('/', 'ExpenseSubCategoryController::index');
    $routes->POST('create', 'ExpenseSubCategoryController::create');
    $routes->POST('update', 'ExpenseSubCategoryController::update');
    $routes->POST('delete', 'ExpenseSubCategoryController::delete');
});


$routes->group('customer', function ($routes) {

    $routes->get('/', 'CustomerController::index');
    $routes->POST('create', 'CustomerController::create');
    $routes->POST('update', 'CustomerController::update');
    $routes->POST('delete', 'CustomerController::delete');
});


$routes->group('customergroup', function ($routes) {

    $routes->get('/', 'CustomerGroupController::index');
    $routes->POST('create', 'CustomerGroupController::create');
    $routes->POST('update', 'CustomerGroupController::update');
    $routes->POST('delete', 'CustomerGroupController::delete');
});

$routes->group('supplier', function ($routes) {

    $routes->get('/', 'SupplierController::index');
    $routes->POST('create', 'SupplierController::create');
    $routes->POST('update', 'SupplierController::update');
    $routes->POST('delete', 'SupplierController::delete');
});

$routes->group('stockAdjustment', function ($routes) {

    $routes->get('/', 'StockAdjustmentController::index');
    $routes->POST('create', 'StockAdjustmentController::createStockAdjustment');
    $routes->get('view/(:num)', 'StockAdjustmentController::view/$1');
    $routes->get('edit/(:num)', 'StockAdjustmentController::edit/$1');
});


$routes->group('user', function ($routes) {
    $routes->get('/', 'UserController::index');
    $routes->post('create', 'UserController::create');
    $routes->post('delete', 'UserController::delete');
    $routes->post('update', 'UserController::update');
});


$routes->group('role', function ($routes) {
    $routes->get('/', 'Role::index');
    $routes->post('create', 'RoleController::create');
    $routes->post('update', 'RoleController::updateUserRole');
});


$routes->group('reports', function ($routes) {

    $routes->get('stock', 'Stockreport::index');
    $routes->get('sales-summary', 'SaleSummeryReport::index');
    $routes->get('profit-loss', 'profitloss::index');
    $routes->get('expense', 'expensereport::index');
    $routes->get('customer', 'customerreport::index');
    $routes->get('purchaseList', 'Stockreport::index');
    $routes->post('PLReport', 'profitloss::profitlosspdfcreate'); // From report/profitloss_report.php
});

$routes->group('receive', function ($routes) {
    $routes->get('/', 'ReceiveFromCustomerController::index');
    $routes->post('create', 'ReceiveFromCustomerController::create');

});

$routes->group('settings', function ($routes) {
    $routes->get('/', 'GeneralSettingsController::index');
    $routes->post('create', 'GeneralSettingsController::create');
    $routes->post('update', 'GeneralSettingsController::update');
    $routes->post('delete', 'GeneralSettingsController::delete');

});

$routes->group('currency', function ($routes) {
    $routes->get('/', 'CurrencyController::index');
    $routes->post('create', 'CurrencyController::create');
    $routes->post('update', 'CurrencyController::update');
    $routes->post('delete', 'CurrencyController::delete');
});


$routes->group('tax', function ($routes) {
    $routes->get('/', 'TaxController::index');
    $routes->post('create', 'TaxController::create');
    $routes->post('update', 'TaxController::update');
    $routes->post('delete', 'TaxController::delete');
    $routes->post('vatTax-create-ajax', 'TaxController::vatTaxCreateAjax');//From Views/product/NewProductAdd.php
});


$routes->get('database-backup', 'BackupController::databaseBackup');

$routes->get('help-support', 'HelpSupportController::index');
$routes->get('help-support/pdf', 'HelpSupportController::pdf');
