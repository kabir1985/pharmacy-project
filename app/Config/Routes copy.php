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

$routes->get('pos', 'PosController::index');
$routes->post('pos/sale', 'PosController::sale');
$routes->post('pos/hold_sale', 'PosController::hold_sale');
$routes->post('pos/resume_sale/(:num)', 'PosController::resume_sale/$1');
$routes->post('filterProducts', 'PosController::filterProducts');

$routes->post('pos/delete_held_sale/(:num)', 'PosController::delete_held_sale/$1');

$routes->post('pos/update_hold_sale', 'PosController::update_hold_sale');

//$routes->get('product_search', 'PosController::product_call');
$routes->get('product_search', 'PosController::productSearch');

$routes->post('pos/products', 'PosController::products');
$routes->get('invoice/(:num)', 'PdfController::invoice/$1');
$routes->get('salelist', 'salelist::index');
$routes->get('salereturnlist', 'salereturnlist::index');
$routes->post('ReturnController/getProducts', 'ReturnController::getProducts');
$routes->get('salereturnlistshow', 'salereturnlist::saleReturnListShow');
//ReturnController/process
$routes->post('ReturnController/process', 'ReturnController::process');

$routes->get('openingStock', 'ProductController::index');
$routes->post('initial-product-create', 'ProductController::create');
$routes->post('initial-product-update', 'ProductController::update');
$routes->post('initial-product-delete', 'ProductController::delete');

$routes->get('barcodegenerate', 'BarcodeGenerateController::index');
$routes->post('barcodeprint', 'BarcodeGenerateController::barcodeprint');

$routes->get('productcategoryView', 'ProductCategoryController::index');
$routes->post('productcategoryAdd', 'ProductCategoryController::create');
$routes->post('productcategoryUpdate', 'ProductCategoryController::update');
$routes->post('productcategoryDelete', 'ProductCategoryController::delete');
$routes->post('category-create-ajax', 'ProductCategoryController::categoryCreateAjax');
$routes->get('get-category-list', 'ProductCategoryController::getCategoryList');


$routes->get('productbrandView', 'ProductBrandController::index');
$routes->post('productbrandAdd', 'ProductBrandController::create');
$routes->post('productbrandUpdate', 'ProductBrandController::update');
$routes->post('productbrandDelete', 'ProductBrandController::delete');
$routes->post('brand-create-ajax', 'ProductBrandController::brandCreateAjax');
$routes->post('initial-product-brand', 'ProductBrandController::brand_call');

$routes->get('Group', 'ProductGroupController::index');
$routes->post('groupAdd', 'ProductGroupController::create');
$routes->post('groupUpdate', 'ProductGroupController::update');
$routes->post('groupDelete', 'ProductGroupController::delete');
$routes->post('group-create-ajax', 'ProductGroupController::groupCreateAjax');



$routes->get('Unit', 'ProductUnitController::index');
$routes->post('unitAdd', 'ProductUnitController::create');
$routes->post('unitUpdate', 'ProductUnitController::update');
$routes->post('unitDelete', 'ProductUnitController::delete');
$routes->post('unit-create-ajax', 'ProductUnitController::unitCreateAjax');

$routes->get('purchase', 'PurchaseController::index');
$routes->post('purchase-product', 'PurchaseController::purchase_product');

$routes->post('strengthCreateAjax', 'ProductStrengthController::strengthCreateAjax');


$routes->get('Expensecategory', 'ExpenseCategoryController::index');
$routes->POST('ExpensecategoryAdd', 'ExpenseCategoryController::create');
$routes->POST('ExpensecategoryDelete', 'ExpenseCategoryController::delete');
$routes->POST('ExpensecategoryUpdate', 'ExpenseCategoryController::update');

$routes->get('stockAdjustment', 'StockAdjustmentController::stockAdjustmentForm');
$routes->POST('createStockAdjustment', 'StockAdjustmentController::createStockAdjustment');

$routes->get('stockAdjustmentView/(:num)', 'StockAdjustmentController::view/$1');
$routes->get('stockAdjustmentEdit/(:num)', 'StockAdjustmentController::edit/$1');
//$routes->post('stockAdjustmentUpdate/(:num)', 'Pos::update/$1');
//$routes->get('stockAdjustmentDelete/(:num)', 'Pos::delete/$1');

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

