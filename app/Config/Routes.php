<?php
use CodeIgniter\Router\RouteCollection;
/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'LoginController::index');
$routes->get('login', 'LoginController::index');
$routes->post('login/auth', 'LoginController::auth');



$routes->group('', ['filter' => 'auth'], function ($routes) {

    $routes->get('logout', 'LoginController::logout');

    $routes->get('dashboard', 'DashboardController::index');

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
    
    
    $routes->group('return', function ($routes) {
        $routes->get('/', 'SaleReturnListController::index');
        $routes->get('sale-return', 'SaleReturnListController::saleReturnListShow');
        $routes->post('products', 'ReturnController::getProducts'); // From View/return/sales_return_list.php
        $routes->post('process', 'ReturnController::process');// From View/return/sales_return_list.php
    });
    
    $routes->group('products', function ($routes) {
        $routes->get('opening-stock', 'ProductController::index');
        $routes->post('create', 'ProductController::create');
        $routes->post('update', 'ProductController::update');
        $routes->post('delete', 'ProductController::delete');
        //$routes->get('search', 'PosController::productSearch');
    });
    
    $routes->group('ajax', function ($routes) {
    
        $routes->post('strength', 'ProductStrengthController::strengthCreateAjax');
    
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
        $routes->post('product', 'PurchaseController::purchase_product');
    
    });
    
    
    $routes->group('expense', function ($routes) {
        $routes->get('/', 'ExpenseController::index');
        $routes->post('create', 'ExpenseController::create');
        $routes->post('update', 'ExpenseController::update');
        $routes->post('delete', 'ExpenseController::delete');
        $routes->post('getSubCategory', 'ExpenseController::getSubCategory'); //From Views/expense/expense_add.php
    
    });
    
    $routes->group('expense-category', function ($routes) {
    
        $routes->get('/', 'ExpenseCategoryController::index');
        $routes->post('create', 'ExpenseCategoryController::create');
        $routes->post('update', 'ExpenseCategoryController::update');
        $routes->post('delete', 'ExpenseCategoryController::delete');
    });
    
    $routes->group('expense-subcategory', function ($routes) {
    
        $routes->get('/', 'ExpenseSubCategoryController::index');
        $routes->post('create', 'ExpenseSubCategoryController::create');
        $routes->post('update', 'ExpenseSubCategoryController::update');
        $routes->post('delete', 'ExpenseSubCategoryController::delete');
    });
    
    $routes->group('customer', function ($routes) {
    
        $routes->get('/', 'CustomerController::index');
        $routes->post('create', 'CustomerController::create');
        $routes->post('update', 'CustomerController::update');
        $routes->post('delete', 'CustomerController::delete');
    });
    
    $routes->group('customer-group', function ($routes) {
    
        $routes->get('/', 'CustomerGroupController::index');
        $routes->post('create', 'CustomerGroupController::create');
        $routes->post('update', 'CustomerGroupController::update');
        $routes->post('delete', 'CustomerGroupController::delete');
    });
    
    $routes->group('supplier', function ($routes) {
    
        $routes->get('/', 'SupplierController::index');
        $routes->post('create', 'SupplierController::create');
        $routes->post('update', 'SupplierController::update');
        $routes->post('delete', 'SupplierController::delete');
    });
    
    $routes->group('stock-adjustment', function ($routes) {
    
        $routes->get('/', 'StockAdjustmentController::index');
        $routes->post('create', 'StockAdjustmentController::createStockAdjustment');
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
        $routes->get('/', 'RoleController::index');
        $routes->post('create', 'RoleController::create');
        $routes->post('update', 'RoleController::updateUserRole');
    });
    
    $routes->group('reports', function ($routes) {
    
        $routes->get('stock', 'StockReportController::index');
        $routes->get('sales-summary', 'SaleSummaryReportController::index');
        $routes->get('profit-loss', 'ProfitLossController::index');
        $routes->get('expense', 'ExpenseReportController::index');
        $routes->get('customer', 'CustomerReportController::index');
        $routes->get('purchase-list', 'StockReportController::index');
        $routes->post('PLReport', 'ProfitLossController::profitlosspdfcreate'); // From report/profitloss_report.php
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
        $routes->post('vatTax-create-ajax', 'TaxController::vatTaxCreateAjax'); //From Views/product/NewProductAdd.php
    });
    
    $routes->get('salelist', 'SaleListController::index');
    
    $routes->get('database-backup', 'BackupController::databaseBackup');
    
    $routes->get('help-support', 'HelpSupportController::index');
    $routes->get('help-support/pdf', 'HelpSupportController::pdf');
    
});






