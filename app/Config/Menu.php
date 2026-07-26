<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * --------------------------------------------------------------------------
 * Application Menu Configuration
 * --------------------------------------------------------------------------
 *
 * All sidebar menu items are defined here.
 *
 * Each menu supports:
 *
 * label       => Display text
 * icon        => FontAwesome icon
 * url         => Route URL
 * privileges  => Required permission(s)
 * roles       => Optional role restriction
 * children    => Sub menu items
 *
 * --------------------------------------------------------------------------
 * Example
 * --------------------------------------------------------------------------
 *
 * [
 *      'label' => 'Dashboard',
 *      'icon'  => 'fa fa-dashboard',
 *      'url'   => 'dashboard',
 *      'roles' => ['Admin'],
 *      'privileges' => ['dashboard_view'],
 *      'children' => []
 * ]
 *
 */

class Menu extends BaseConfig
{
    public array $items = [

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        [
            'label'      => 'Dashboard',
            'icon'       => 'fa fa-dashboard',
            'url'        => 'dashboard',
            'privileges' => [],
            'children'   => []
        ],

        /*
        |--------------------------------------------------------------------------
        | Sales Section
        |--------------------------------------------------------------------------
        */

        [
            'label' => 'Sales Section',
            'icon'  => 'fa fa-shopping-cart',
            'url'   => '#',

            'privileges' => [
                'pos_sale',
                'general_sale',
                'sale_list',
                'sale_return',
                'sale_return_list'
            ],

            'children' => [

                [
                    'label'      => 'POS / General Sale',
                    'url'        => 'pos',
                    'privileges' => ['pos_sale']
                ],

                [
                    'label'      => 'Sales List',
                    'url'        => 'salelist',
                    'privileges' => ['sale_list']
                ],

                [
                    'label'      => 'Sales Return',
                    'url'        => 'return',
                    'privileges' => ['sale_return']
                ],

                [
                    'label'      => 'Sales Return List',
                    'url'        => 'return/sale-return',
                    'privileges' => ['sale_return_list']
                ],

            ]
        ],

        /*
        |--------------------------------------------------------------------------
        | Product Section
        |--------------------------------------------------------------------------
        */

        [
            'label' => 'Product Section',
            'icon'  => 'fa fa-cubes',
            'url'   => '#',

            'privileges' => [
                'barcode_generate',
                'product_category',
                'product_brand',
                'product_group',
                'product_unit'
            ],

            'children' => [

                [
                    'label'      => 'Barcode Generate',
                    'url'        => 'barcode',
                    'privileges' => ['barcode_generate']
                ],

                [
                    'label'      => 'Category / Dosage Form',
                    'url'        => 'categories',
                    'privileges' => ['product_category']
                ],

                [
                    'label'      => 'Product Brand',
                    'url'        => 'brands',
                    'privileges' => ['product_brand']
                ],

                [
                    'label'      => 'Group / Generic Name',
                    'url'        => 'groups',
                    'privileges' => ['product_group']
                ],

                [
                    'label'      => 'Product Unit',
                    'url'        => 'units',
                    'privileges' => ['product_unit']
                ],

            ]
        ],

        /*
        |--------------------------------------------------------------------------
        | Stock Section
        |--------------------------------------------------------------------------
        */

        [
            'label' => 'Stock Section',
            'icon'  => 'fa fa-cubes',
            'url'   => '#',

            'privileges' => [
                'initial_product',
                'product_unit'
            ],

            'children' => [

                [
                    'label'      => 'Opening Stock',
                    'url'        => 'products/opening-stock',
                    'privileges' => ['initial_product']
                ],

                [
                    'label'      => 'Stock Adjustment',
                    'url'        => 'stock-adjustment',
                    'privileges' => ['product_unit']
                ],

            ]
        ],

        /*
        |--------------------------------------------------------------------------
        | Purchase Section
        |--------------------------------------------------------------------------
        */

        [
            'label' => 'Purchase Section',
            'icon'  => 'fa fa-laptop',
            'url'   => '#',

            'privileges' => [
                'purchase_product'
            ],

            'children' => [

                [
                    'label'      => 'Purchase Product',
                    'url'        => 'purchase',
                    'privileges' => ['purchase_product']
                ],

                [
                    'label'      => 'Purchase List',
                    'url'        => 'reports/purchase-list',
                    'privileges' => ['stock_report']
                ]

            ]
        ],

        /*
        |--------------------------------------------------------------------------
        | Expense Section
        |--------------------------------------------------------------------------
        */

        [
            'label' => 'Expenses Section',
            'icon'  => 'fa fa-credit-card',
            'url'   => '#',

            'privileges' => [
                'expense_add',
                'expense_category',
                'expense_sub_category'
            ],

            'children' => [

                [
                    'label'      => 'Expense Category',
                    'url'        => 'expense-category',
                    'privileges' => ['expense_category']
                ],

                [
                    'label'      => 'Expense Sub Category',
                    'url'        => 'expense-subcategory',
                    'privileges' => ['expense_sub_category']
                ],

                [
                    'label'      => 'Expense Add',
                    'url'        => 'expense',
                    'privileges' => ['expense_add']
                ]

            ]
        ],

        /*
        |--------------------------------------------------------------------------
        | People Section
        |--------------------------------------------------------------------------
        */

        [
            'label' => 'People Section',
            'icon'  => 'fa fa-user-o',
            'url'   => '#',

            'privileges' => [
                'customer_group',
                'customer_add',
                'supplier_add',
                'user_creation',
                'user_role_set'
            ],

            'children' => [

                [
                    'label'      => 'Customer Group',
                    'url'        => 'customer-group',
                    'privileges' => ['customer_group']
                ],

                [
                    'label'      => 'Customer Add',
                    'url'        => 'customer',
                    'privileges' => ['customer_add']
                ],

                [
                    'label'      => 'Supplier Add',
                    'url'        => 'supplier',
                    'privileges' => ['supplier_add']
                ],

                [
                    'label'      => 'User Creation',
                    'url'        => 'user',
                    'privileges' => ['user_creation']
                ],

                [
                    'label'      => 'User Role Set',
                    'url'        => 'role',
                    'privileges' => ['user_role_set']
                ],

            ]
        ],

        /*
        |--------------------------------------------------------------------------
        | Reports Section
        |--------------------------------------------------------------------------
        */

        [
            'label' => 'Reports Section',
            'icon'  => 'fa fa-bar-chart',
            'url'   => '#',

            'privileges' => [
                'stock_report',
                'sale_report',
                'profit_loss',
                'expense_report',
                'customer_report'
            ],

            'children' => [

                [
                    'label'      => 'Stock / Purchase',
                    'url'        => 'reports/stock',
                    'privileges' => ['stock_report']
                ],

                [
                    'label'      => 'Sales Report',
                    'url'        => 'reports/sales-summary',
                    'privileges' => ['sale_report']
                ],

                [
                    'label'      => 'Profit & Loss',
                    'url'        => 'reports/profit-loss',
                    'privileges' => ['profit_loss']
                ],

                [
                    'label'      => 'Expense Report',
                    'url'        => 'reports/expense',
                    'privileges' => ['expense_report']
                ],

                [
                    'label'      => 'Customer Report',
                    'url'        => 'reports/customer',
                    'privileges' => ['customer_report']
                ]

            ]
        ],

        /*
        |--------------------------------------------------------------------------
        | Payment Section
        |--------------------------------------------------------------------------
        */

        [
            'label' => 'Payment Section',
            'icon'  => 'fa fa-money',
            'url'   => '#',

            'privileges' => [
                'due_collection'
            ],

            'children' => [

                [
                    'label'      => 'Due Collection',
                    'url'        => 'payment/due-collection',
                    'privileges' => ['due_collection']
                ]

            ]
        ],

        /*
        |--------------------------------------------------------------------------
        | Settings Section
        |--------------------------------------------------------------------------
        */

        [
            'label' => 'Settings Section',
            'icon'  => 'fa fa-cog',
            'url'   => '#',

            'privileges' => [
                'general_settings',
                'currency_settings',
                'tax_setup'
            ],

            'children' => [

                [
                    'label'      => 'General Settings',
                    'url'        => 'settings',
                    'privileges' => ['general_settings']
                ],

                [
                    'label'      => 'Currency Settings',
                    'url'        => 'currency',
                    'privileges' => ['currency_settings']
                ],

                [
                    'label'      => '% Tax Setup',
                    'url'        => 'tax',
                    'privileges' => ['tax_setup']
                ]

            ]
        ],

        /*
        |--------------------------------------------------------------------------
        | System
        |--------------------------------------------------------------------------
        */

        [
            'label'      => 'Backup Database',
            'icon'       => 'fa fa-download',
            'url'        => 'database-backup',
           // 'roles'      => ['Administrator'],
            'privileges' => [],
            'children'   => []
        ],

        [
            'label'      => 'Help & Support',
            'icon'       => 'fa fa-life-ring',
            'url'        => 'help-support',
            'privileges' => [],
            'children'   => []
        ],

        [
            'label'      => 'Logout',
            'icon'       => 'fa fa-sign-out',
            'url'        => 'logout',
            'privileges' => [],
            'children'   => []
        ]

    ];
}