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

$routes->get('barcodegenerate', 'BarcodeGenerateController::index');
$routes->post('barcodeprint', 'BarcodeGenerateController::barcodeprint');

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

$routes->get('Expensecategory', 'ExpenseCategoryController::index');
$routes->POST('ExpensecategoryAdd', 'ExpenseCategoryController::create');
$routes->POST('ExpensecategoryDelete', 'ExpenseCategoryController::delete');
$routes->POST('ExpensecategoryUpdate', 'ExpenseCategoryController::update');

$routes->get('stockAdjustment', 'StockAdjustmentController::stockAdjustmentForm');
$routes->POST('createStockAdjustment', 'StockAdjustmentController::createStockAdjustment');

$routes->get('stockAdjustmentView/(:num)', 'StockAdjustmentController::view/$1');
$routes->get('stockAdjustmentEdit/(:num)', 'StockAdjustmentController::edit/$1');

$routes->get('Expensesubcategory', 'ExpenseSubCategoryController::index');
$routes->POST('ExpensesubcategoryAdd', 'ExpenseSubCategoryController::create');
$routes->POST('ExpensesubcategoryUpdate', 'ExpenseSubCategoryController::update');
$routes->POST('ExpensesubcategoryDelete', 'ExpenseSubCategoryController::delete');

$routes->get('Expense', 'ExpenseController::index');
$routes->POST('ExpenseAdd', 'ExpenseController::create');
$routes->POST('ExpenseUpdate', 'ExpenseController::update');
$routes->POST('ExpenseDelete', 'ExpenseController::delete');

$routes->POST('expense/getSubCategory', 'Expense::getSubCategory');

$routes->get('customergroup', 'CustomerGroupController::index');
$routes->POST('customergroupAdd', 'CustomerGroupController::create');
$routes->POST('customergroupUpdate', 'CustomerGroupController::update');
$routes->POST('customergroupDelete', 'CustomerGroupController::delete');

$routes->get('customer', 'CustomerController::index');
$routes->POST('customerAdd', 'CustomerController::create');
$routes->POST('customerUpdate', 'CustomerController::update');
$routes->POST('customerDelete', 'CustomerController::delete');

$routes->get('supplier', 'SupplierController::index');
$routes->POST('supplierAdd', 'SupplierController::create');
$routes->POST('supplierUpdate', 'SupplierController::update');
$routes->POST('supplierDelete', 'SupplierController::delete');

$routes->group('users', function ($routes) {

    $routes->get('/', 'User::index');
    $routes->post('create', 'User::create');
    $routes->post('update', 'User::update');
    $routes->post('delete', 'User::delete');

});

$routes->get('user', 'User::index');
$routes->post('userCreate', 'User::create');
$routes->post('userDelete', 'user::delete');
$routes->post('userUpdate', 'user::update');
//update

$routes->get('role', 'Role::index');
$routes->post('roleCreate', 'Role::create');
$routes->post('roleUpdate', 'Role::updateUserRole');

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

    $routes->get('general', 'generalsettings::index');

    $routes->get('currency', 'CurrencyController::index');
    $routes->get('tax', 'TaxController::index');

});

$routes->get('generalsettings', 'generalsettings::index');
$routes->post('generalsettingsAdd', 'generalsettings::create');
$routes->post('generalsettingsUpdate', 'generalsettings::update');
$routes->post('generalsettingsDelete', 'generalsettings::delete');

$routes->get('currency', 'CurrencyController::index');
$routes->post('currencyAdd', 'CurrencyController::create');
$routes->post('currencyUpdate', 'CurrencyController::update');
$routes->post('currencyDelete', 'CurrencyController::delete');

$routes->get('tax', 'TaxController::index');
$routes->post('taxAdd', 'TaxController::create');
$routes->post('taxUpdate', 'TaxController::update');
$routes->post('taxDelete', 'TaxController::delete');
$routes->post('vatTax-create-ajax', 'TaxController::vatTaxCreateAjax');

$routes->get('database-backup', 'BackupController::databaseBackup');

$routes->get('help-support', 'HelpSupportController::index');
$routes->get('help-support/pdf', 'HelpSupportController::pdf');
