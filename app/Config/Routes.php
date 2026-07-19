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

$routes->get('purchase', 'Purchase::index');
$routes->post('purchase-product', 'Purchase::purchase_product');

$routes->post('strengthCreateAjax', 'ProductStrengthController::strengthCreateAjax');


$routes->get('Expensecategory', 'Expensecategory::index');
$routes->POST('ExpensecategoryAdd', 'Expensecategory::create');
$routes->POST('ExpensecategoryDelete', 'Expensecategory::delete');
$routes->POST('ExpensecategoryUpdate', 'Expensecategory::update');

$routes->get('stockAdjustment', 'StockAdjustmentController::stockAdjustmentForm');
$routes->POST('createStockAdjustment', 'Pos::createStockAdjustment');

$routes->get('stockAdjustmentView/(:num)', 'Pos::view/$1');
$routes->get('stockAdjustmentEdit/(:num)', 'Pos::edit/$1');
$routes->post('stockAdjustmentUpdate/(:num)', 'Pos::update/$1');
$routes->get('stockAdjustmentDelete/(:num)', 'Pos::delete/$1');

$routes->get('Expensesubcategory', 'Expensesubcategory::index');
$routes->POST('ExpensesubcategoryAdd', 'Expensesubcategory::create');
$routes->POST('ExpensesubcategoryUpdate', 'Expensesubcategory::update');
$routes->POST('ExpensesubcategoryDelete', 'Expensesubcategory::delete');

$routes->get('Expense', 'Expense::index');
$routes->POST('ExpenseAdd', 'Expense::create');
$routes->POST('ExpenseUpdate', 'Expense::update');
$routes->POST('ExpenseDelete', 'Expense::delete');

$routes->POST('expense/getSubCategory', 'Expense::getSubCategory');

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

$routes->get('tax', 'TaxController::index');
$routes->post('taxAdd', 'TaxController::create');
$routes->post('taxUpdate', 'TaxController::update');
$routes->post('taxDelete', 'TaxController::delete');
$routes->post('vatTax-create-ajax', 'TaxController::vatTaxCreateAjax');

$routes->get('database-backup', 'BackupController::databaseBackup');

$routes->get('help-support', 'HelpSupportController::index');
$routes->get('help-support/pdf', 'HelpSupportController::pdf');

