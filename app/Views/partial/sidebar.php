<?php
// Safe function to check privileges
if (!function_exists('hasAnyPrivilege')) {
    function hasAnyPrivilege(array $needles, array $haystack): bool {
        return (bool) array_intersect($needles, $haystack);
    }
}

// User privileges
$allowedMenus = array_map('strtolower', session()->get('allowedMenus') ?? []);
$current_menu = strtolower(current_url(true)->getSegment(1) ?? '');

// Define menu structure
$menuSections = [
    [
        'label' => 'Dashboard',
        'icon'  => 'fa fa-dashboard',
        'url'   => 'dashboard',
        'privileges' => [], // No privilege needed
        'children' => []
    ],
    [
        'label' => 'Sales Section',
        'icon'  => 'fa fa-shopping-cart',
        'url'   => '#',
        'privileges' => ['pos_sale','general_sale','sale_list','sale_return','sale_return_list'],
        'children' => [
            ['label'=>'POS/Genarel Sale','url'=>'pos','privileges'=>['pos_sale'] ],
            ['label'=>'Sales List','url'=>'salelist','privileges'=>['sale_list']],
            ['label'=>'Sales Return','url'=>'salereturnlist','privileges'=>['sale_return']],
            ['label'=>'Sales Return List','url'=>'salereturnlistshow','privileges'=>['sale_return_list']],
        ]
    ],
    [
        'label' => 'Product Section',
        'icon'  => 'fa fa-cubes',
        'url'   => '#',
        'privileges' => ['initial_product','barcode_generate','product_category','product_brand','product_group','product_unit'],
        'children' => [
            ['label'=>'Initial Product','url'=>'product','privileges'=>['initial_product']],
            ['label'=>'Barcode Generate','url'=>'barcodegenerate','privileges'=>['barcode_generate']],
            ['label'=>'Product Category','url'=>'productcategoryView','privileges'=>['product_category']],
            ['label'=>'Product Brand','url'=>'productbrandView','privileges'=>['product_brand']],
            ['label'=>'Product Group','url'=>'Group','privileges'=>['product_group']],
            ['label'=>'Product Unit','url'=>'Unit','privileges'=>['product_unit']],
        ]
    ],
    [
        'label'=>'Purchase Section',
        'icon'=>'fa fa-laptop',
        'url'=>'#',
        'privileges'=>['purchase_product'],
        'children'=>[
            ['label'=>'Purchase Product','url'=>'purchase','privileges'=>['purchase_product']]
        ]
    ],
    [
        'label'=>'Expenses Section',
        'icon'=>'fa fa-credit-card',
        'url'=>'#',
        'privileges'=>['expense_add','expense_category','expense_sub_category'],
        'children'=>[
            ['label'=>'Expense Category','url'=>'Expensecategory','privileges'=>['expense_category']],
            ['label'=>'Expense Sub Category','url'=>'Expensesubcategory','privileges'=>['expense_sub_category']],
            ['label'=>'Expense Add','url'=>'Expense','privileges'=>['expense_add']],
        ]
    ],
    [
        'label'=>'People Section',
        'icon'=>'fa fa-user-o',
        'url'=>'#',
        'privileges'=>['customer_group','customer_add','supplier_add','user_creation','user_role_set'],
        'children'=>[
            ['label'=>'Customer Group','url'=>'customergroup','privileges'=>['customer_group']],
            ['label'=>'Customer Add','url'=>'customer','privileges'=>['customer_add']],
            ['label'=>'Supplier Add','url'=>'supplier','privileges'=>['supplier_add']],
            ['label'=>'User Creation','url'=>'user','privileges'=>['user_creation']],
            ['label'=>'User Role Set','url'=>'role','privileges'=>['user_role_set']],
        ]
    ],
    [
        'label'=>'Reports Section',
        'icon'=>'fa fa-bar-chart',
        'url'=>'#',
        'privileges'=>['stock_report','sale_report','profit_loss','expense_report','customer_report'],
        'children'=>[
            ['label'=>'Stock Report','url'=>'stockreport','privileges'=>['stock_report']  ],
            ['label'=>'Sales Report','url'=>'salesummeryreport','privileges'=>['sale_report']],
            ['label'=>'Profit & Loss','url'=>'profitloss','privileges'=>['profit_loss']],
            ['label'=>'Expense Report','url'=>'expensereport','privileges'=>['expense_report']],
            ['label'=>'Customer Report','url'=>'customerreport','privileges'=>['customer_report']],
        ]
    ],
    [
        'label'=>'Payment Section',
        'icon'=>'fa fa-money',
        'url'=>'#',
        'privileges'=>['receive_customer'],
        'children'=>[
            ['label'=>'Receive Customer','url'=>'fromcustomer','privileges'=>['receive_customer']],
        ]
    ],
    [
        'label'=>'Settings Section',
        'icon'=>'fa fa-cog',
        'url'=>'#',
        'privileges'=>['general_settings','currency_settings','tax_setup'],
        'children'=>[
            ['label'=>'General Settings','url'=>'generalsettings','privileges'=>['general_settings']],
            ['label'=>'Currency Settings','url'=>'currency','privileges'=>['currency_settings']],
            ['label'=>'% Tax Setup','url'=>'tax','privileges'=>['tax_setup']],
        ]
    ],
    [
        'label'=>'Logout',
        'icon'=>'fa fa-sign-out',
        'url'=>'logout',
        'privileges'=>[],
        'children'=>[]
    ]
];
?>


<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
<ul class="app-menu">
<?php foreach($menuSections as $section):
    // Skip section if user has no privileges
    if(!empty($section['privileges']) && !hasAnyPrivilege($section['privileges'], $allowedMenus)) continue;

    $isActiveSection = false;
    if(!empty($section['children'])) {
        foreach($section['children'] as $child){
            if(in_array(strtolower($child['url']), [$current_menu])){
                $isActiveSection = true;
                break;
            }
        }
    } else {
        $isActiveSection = ($current_menu === strtolower($section['url']));
    }
?>
<li class="<?= !empty($section['children']) ? 'treeview' : '' ?> <?= $isActiveSection ? 'is-expanded' : '' ?>">
    <a class="app-menu__item" href="<?= $section['url'] !== '#' ? site_url($section['url']) : '#' ?>" <?= !empty($section['children']) ? 'data-toggle="treeview"' : '' ?>>
        <i class="app-menu__icon <?= $section['icon'] ?>"></i>
        <span class="app-menu__label"><?= $section['label'] ?></span>
        <?php if(!empty($section['children'])): ?>
        <i class="treeview-indicator fa fa-angle-right"></i>
        <?php endif; ?>
    </a>
    <?php if(!empty($section['children'])): ?>
    <ul class="treeview-menu">
        <?php foreach($section['children'] as $child):
            if(!hasAnyPrivilege($child['privileges'],$allowedMenus)) continue;
        ?>
       <li>
       <a class="treeview-item <?= strtolower($child['url']) == $current_menu ? 'active-child' : '' ?>" 
   href="<?= site_url($child['url']); ?>">

        <i class="<?= $child['icon'] ?? 'fa fa-caret-right' ?>"></i>
        <?= $child['label'] ?>
    </a>
</li>

        <?php endforeach; ?>
    </ul>
    <?php endif; ?>
</li>
<?php endforeach; ?>
</ul>
</aside>
<style>


.treeview-menu .treeview-item {
    padding-left: 38px !important;
    display: flex;
    align-items: center;
    gap: 8px;
}
/* =========================
   SIMPLE CLEAN SIDEBAR
========================= */

/* Sidebar Base */
.app-sidebar {
    background: #1f2937; /* Clean dark gray */
    border-right: 1px solid #2d3748;
}

/* Main Menu */
.app-menu__item {
    margin: 4px 10px;
    padding: 10px 14px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 500;
    color: #cbd5e1;
    transition: background 0.2s ease;
}

/* Main Hover */
.app-menu__item:hover {
    background: #374151;
    color: #ffffff;
}

/* Active Main */
.treeview.is-expanded > .app-menu__item {
    background: #374151;
    color: #ffffff !important;
    border-left: 3px solid #007065;
}

/* Main Icon */
.app-menu__item i {
    margin-right: 8px;
}


/* =========================
   CHILD MENU
========================= */

.treeview-menu .treeview-item {
    margin: 2px 20px;
    padding: 8px 12px;
    padding-left: 36px !important;
    border-radius: 4px;
    font-size: 13px;
    color: #9ca3af;
    transition: background 0.2s ease;
}

/* Child Hover */
.treeview-menu .treeview-item:hover {
    background: #2d3748;
    color: #ffffff;
}

/* Active Child */
.treeview-menu .treeview-item.active-child {
    background: #2d3748;
    color: #ffffff !important;
    border-left: 3px solid #3b82f6;
}

/* Rotate arrow */
.treeview-indicator {
    transition: 0.2s ease;
}

.treeview.is-expanded .treeview-indicator {
    transform: rotate(90deg);
}

</style>
