<?php

/**
 * --------------------------------------------------------------------------
 * Pharmacy Management System
 * --------------------------------------------------------------------------
 * Dynamic Sidebar Navigation
 * --------------------------------------------------------------------------
 *
 * Sidebar visibility is controlled by:
 *
 * 1. User Role
 * 2. User Privileges
 * 3. Current Route
 *
 * Menu definitions:
 *      app/Config/Menu.php
 *
 * Helper functions:
 *      app/Helpers/menu_helper.php
 *
 * --------------------------------------------------------------------------
 * @package   Pharmacy Management System
 * @author    Kabir Hossain
 * @version   1.0
 * --------------------------------------------------------------------------
 */

helper('menu'); // Load menu_helper.php from app/Helpers/menu_helper.php

/*
|--------------------------------------------------------------------------
| Load Menu Configuration
|--------------------------------------------------------------------------
*/
$menuSections = config('Menu')->items; //Load menu items from app/config/Menu.php

/*
|--------------------------------------------------------------------------
| Logged-in User Information
|--------------------------------------------------------------------------
*/
$session = session();

$allowedMenus = array_map(
    'strtolower',
    $session->get('allowedMenus') ?? []
);

$currentMenu = strtolower(trim(uri_string(), '/'));

$userRole = $session->get('user_role');

?>

<div class="app-sidebar__overlay" data-toggle="sidebar"></div>

<aside class="app-sidebar">

    <ul class="app-menu">

        <?php foreach ($menuSections as $section): ?>

            <?php

            /*
            |--------------------------------------------------------------------------
            | Role Permission
            |--------------------------------------------------------------------------
            */

            if (!empty($section['roles']) &&
                !in_array($userRole, $section['roles'], true)
            ) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Menu Permission
            |--------------------------------------------------------------------------
            */

            if (
                !empty($section['privileges']) &&
                !hasAnyPrivilege($section['privileges'], $allowedMenus)
            ) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Parent Active Detection
            |--------------------------------------------------------------------------
            */

            $isExpanded = false;

            if (!empty($section['children'])) {

                foreach ($section['children'] as $child) {

                    if (
                        strtolower(trim($child['url'], '/')) === $currentMenu
                    ) {
                        $isExpanded = true;
                        break;
                    }
                }

            } else {

                $isExpanded =
                    strtolower(trim($section['url'], '/')) === $currentMenu;
            }

            ?>

            <li class="<?= !empty($section['children']) ? 'treeview' : '' ?> <?= $isExpanded ? 'is-expanded' : '' ?>">

                <a
                    class="app-menu__item"
                    href="<?= esc($section['url'] === '#' ? '#' : site_url($section['url'])) ?>"
                    <?= !empty($section['children']) ? 'data-toggle="treeview"' : '' ?>
                >

                    <i class="app-menu__icon <?= esc($section['icon']) ?>"></i>

                    <span class="app-menu__label">

                        <?= esc($section['label']) ?>

                    </span>

                    <?php if (!empty($section['children'])): ?>

                        <i class="treeview-indicator fa fa-angle-right"></i>

                    <?php endif; ?>

                </a>

                <?php if (!empty($section['children'])): ?>

                    <ul class="treeview-menu">

                        <?php foreach ($section['children'] as $child): ?>

                            <?php

                            if (
                                !hasAnyPrivilege(
                                    $child['privileges'],
                                    $allowedMenus
                                )
                            ) {
                                continue;
                            }

                            $isActive =
                                strtolower(trim($child['url'], '/'))
                                === $currentMenu;

                            ?>

                            <li>

                                <a
                                    class="treeview-item <?= $isActive ? 'active-child' : '' ?>"
                                    href="<?= esc(site_url($child['url'])) ?>"
                                >

                                    <i class="<?= esc($child['icon'] ?? 'fa fa-caret-right') ?>"></i>

                                    <?= esc($child['label']) ?>

                                </a>

                            </li>

                        <?php endforeach; ?>

                    </ul>

                <?php endif; ?>

            </li>

        <?php endforeach; ?>

    </ul>

</aside>