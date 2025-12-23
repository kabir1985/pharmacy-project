<!-- Sidebar menu-->
<?php $allowedMenus = session()->get('allowedMenus') ?? []; ?>
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
  <?php
  $path = current_url(true);
  $uri = new \CodeIgniter\HTTP\URI($path);
  $current_menu = strtolower($uri->getSegment(2));
  ?>

  <ul class="app-menu">
    <li><a class="app-menu__item active" href="<?php echo site_url('dashboard'); ?>">
        <i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
    <?php
    $active = in_array($current_menu, ['pos', 'generalsale', 'salelist', 'salereturnlist']);

    // Check if user has at least one Sales privilege
    $salesPrivileges = ['pos_sale', 'general_sale', 'sale_list', 'sale_return', 'sale_return_list'];
    $hasSalesPrivilege = false;

    foreach ($salesPrivileges as $priv) {
      if (in_array($priv, $allowedMenus)) {
        $hasSalesPrivilege = true;
        break;
      }
    }
    ?>

    <?php if ($hasSalesPrivilege): ?>
      <li class="treeview <?= $active ? 'is-expanded' : '' ?>">
        <a class="app-menu__item" href="#" data-toggle="treeview">
          <i class="app-menu__icon fa fa-shopping-cart text-aqua"></i>
          <span class="app-menu__label">Sales Section</span>
          <i class="treeview-indicator fa fa-angle-right"></i>
        </a>
        <ul class="treeview-menu">
          <?php if (in_array('pos_sale', $allowedMenus)): ?>
            <li><a class="treeview-item" href="<?= site_url('pos'); ?>">
                <i class="fa fa-barcode"></i>&nbsp; POS Sale
              </a></li>
          <?php endif; ?>

          <!-- <?php //if (in_array('general_sale', $allowedMenus)): ?>
            <li><a class="treeview-item" href="<?//= site_url('generalsale'); ?>">
                <i class="icon fa fa-plus-square" aria-hidden="true"></i>&nbsp; General Sale
              </a></li>
          <?php //endif; ?> -->

          <?php if (in_array('sale_list', $allowedMenus)): ?>
            <li><a class="treeview-item" href="<?= site_url('salelist'); ?>">
                <i class="fa fa-list" aria-hidden="true"></i>&nbsp; Sales List
              </a></li>
          <?php endif; ?>

          <?php if (in_array('sale_return', $allowedMenus)): ?>
            <li><a class="treeview-item" href="<?= site_url('salereturnlist'); ?>">
                <i class="icon fa fa-plus-square" aria-hidden="true"></i> &nbsp;Sales Return
              </a></li>
          <?php endif; ?>

          <?php if (in_array('sale_return_list', $allowedMenus)): ?>
            <li><a class="treeview-item" href="<?= site_url('salereturnlistshow'); ?>">
                <i class="fa fa-list" aria-hidden="true"></i>&nbsp; Sales Return List
              </a></li>
          <?php endif; ?>
        </ul>
      </li>
    <?php endif; ?>



    <?php
    // Determine if current menu matches Product Section
    $active = in_array($current_menu, ['product', 'barcodegenerate', 'productcategoryView', 'brand', 'group', 'unit']);

    // List of privileges for Product Section
    $productPrivileges = ['initial_product', 'barcode_generate', 'product_category', 'product_brand', 'product_group', 'product_unit'];

    // Check if user has at least one privilege in this section
    $hasProductPrivilege = false;
    foreach ($productPrivileges as $priv) {
      if (in_array($priv, $allowedMenus)) {
        $hasProductPrivilege = true;
        break;
      }
    }
    ?>

    <?php if ($hasProductPrivilege): ?>
      <li class="treeview <?= $active ? 'is-expanded' : '' ?>">
        <a class="app-menu__item" href="#" data-toggle="treeview">
          <i class="app-menu__icon fa fa-product-hunt"></i>
          <span class="app-menu__label">Product Section</span>
          <i class="treeview-indicator fa fa-angle-right" aria-hidden="true"></i>
        </a>
        <ul class="treeview-menu">

          <?php if (in_array('initial_product', $allowedMenus)): ?>
            <li>
              <a class="treeview-item" href="<?= site_url('product'); ?>">
                <i class="icon fa fa-plus-square-o"></i> Initial Product
              </a>
            </li>
          <?php endif; ?>

          <?php if (in_array('barcode_generate', $allowedMenus)): ?>
            <li>
              <a class="treeview-item" href="<?= site_url('barcodegenerate'); ?>">
                <i class="icon fa fa-plus-square-o"></i> BarCode Generate
              </a>
            </li>
          <?php endif; ?>

          <?php if (in_array('product_category', $allowedMenus)): ?>
            <li>
              <a class="treeview-item" href="<?= site_url('productcategoryView'); ?>">
                <i class="icon fa fa-plus-square-o"></i> Product Category
              </a>
            </li>
          <?php endif; ?>

          <?php if (in_array('product_brand', $allowedMenus)): ?>
            <li>
              <a class="treeview-item" href="<?= site_url('productbrandView'); ?>">
                <i class="icon fa fa-plus-square-o"></i> Product Brand
              </a>
            </li>
          <?php endif; ?>

          <?php if (in_array('product_group', $allowedMenus)): ?>
            <li>
              <a class="treeview-item" href="<?= site_url('Group'); ?>">
                <i class="icon fa fa-plus-square-o"></i> Product Group
              </a>
            </li>
          <?php endif; ?>

          <?php if (in_array('product_unit', $allowedMenus)): ?>
            <li>
              <a class="treeview-item" href="<?= site_url('Unit'); ?>">
                <i class="icon fa fa-plus-square-o blue-color"></i> Product Unit
              </a>
            </li>
          <?php endif; ?>

        </ul>
      </li>
    <?php endif; ?>



    <?php
    // Determine if active
    $active = ($current_menu === 'Purchase');

    // Define privileges for Purchase Section
    $purchasePrivileges = ['purchase_product'];

    // Check if user has any Purchase privilege
    $hasPurchasePrivilege = false;
    foreach ($purchasePrivileges as $priv) {
      if (in_array($priv, $allowedMenus)) {
        $hasPurchasePrivilege = true;
        break;
      }
    }
    ?>
    <?php if ($hasPurchasePrivilege): ?>
      <li class="treeview <?= $active ? 'is-expanded' : '' ?>">
        <a class="app-menu__item" href="#" data-toggle="treeview">
          <i class="app-menu__icon fa fa-laptop" aria-hidden="true"></i>
          <span class="app-menu__label">Purchase Section</span>
          <i class="treeview-indicator fa fa-angle-right"></i>
        </a>
        <ul class="treeview-menu">

          <?php if (in_array('purchase_product', $allowedMenus)): ?>
            <li>
              <a class="treeview-item" href="<?= site_url('purchase'); ?>">
                <i class="icon fa fa-circle-o"></i> Purchase Product
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </li>
    <?php endif; ?>



    <?php
    $active = in_array($current_menu, ['expense', 'expensecategory', 'expensesubcategory']);
    // Check if user has at least one Sales privilege
    $expensePrivileges = ['expense_add', 'expense_category', 'expense_sub_category'];
    $hasExpensePrivilege = false;

    foreach ($expensePrivileges as $priv) {
      if (in_array($priv, $allowedMenus)) {
        $hasExpensePrivilege = true;
        break;
      }
    }
    ?>

    <?php if ($hasExpensePrivilege): ?>

      <li class="treeview <?php echo ($active) ? "is-expanded" : "" ?>">
        <a class="app-menu__item" href="#" data-toggle="treeview">
          <i class="app-menu__icon fa fa-credit-card" aria-hidden="true"></i>
          <span class="app-menu__label">Expenses Section</span>
          <i class="treeview-indicator fa fa-angle-right"></i>
        </a>
        <ul class="treeview-menu">
          <?php if (in_array('expense_category', $allowedMenus)): ?>
            <li><a class="treeview-item" href="<?php echo site_url('Expensecategory'); ?>">
                <i class="icon fa fa-plus-square" aria-hidden="true"></i> Expense Category</a></li>
          <?php endif; ?>
          <?php if (in_array('expense_sub_category', $allowedMenus)): ?>
            <li><a class="treeview-item" href="<?php echo site_url('Expensesubcategory'); ?>">
                <i class="icon fa fa-plus-square" aria-hidden="true"></i> Expense Sub-Category</a></li>
          <?php endif; ?>
          <?php if (in_array('expense_add', $allowedMenus)): ?>
            <li><a class="treeview-item" href="<?php echo site_url('Expense'); ?>">
                <i class="icon fa fa-plus-square" aria-hidden="true"></i> Expense Add</a></li>
          <?php endif; ?>
        </ul>
      </li>
    <?php endif; ?>



  <?php
    $active = in_array($current_menu, ['customergroup', 'customer', 'supplier', 'user', 'role']);
    // Check if user has at least one Sales privilege
    $peoplePrivileges = ['customer_group', 'customer_add', 'supplier_add','user_creation','user_role_set'];
    $hasPeoplePrivilege = false;

    foreach ($peoplePrivileges as $priv) {
      if (in_array($priv, $allowedMenus)) {
        $hasPeoplePrivilege = true;
        break;
      }
    }
    ?>

    <?php if ($hasPeoplePrivilege): ?>
    <li class="treeview <?php echo ($active) ? "is-expanded" : "" ?>">
      <a class="app-menu__item" href="#" data-toggle="treeview">
        <i class="app-menu__icon fa fa-user-o" aria-hidden="true"></i>
        <span class="app-menu__label">People Section</span>
        <i class="treeview-indicator fa fa-angle-right"></i>
      </a>
      <ul class="treeview-menu">
        <?php if (in_array('customer_group', $allowedMenus)): ?>
          <li><a class="treeview-item" href="<?php echo site_url('customergroup'); ?>">
              <i class="icon fa fa-circle-o"></i> Customer Group</a></li>
        <?php endif; ?>
        <?php if (in_array('customer_add', $allowedMenus)): ?>
          <li><a class="treeview-item" href="<?php echo site_url('customer'); ?>">
              <i class="icon fa fa-user-circle-o" aria-hidden="true"></i> Customer Add</a></li>
        <?php endif; ?>
        <?php if (in_array('supplier_add', $allowedMenus)): ?>
          <li><a class="treeview-item" href="<?php echo site_url('supplier'); ?>">
              <i class="icon fa fa-circle-o"></i> Supplier Add</a></li>
        <?php endif; ?>
        <?php if (in_array('user_creation', $allowedMenus)): ?>
          <li><a class="treeview-item" href="<?php echo site_url('user'); ?>">
              <i class="icon fa fa-user-plus"></i> User Creation</a></li>
        <?php endif; ?>
        <?php if (in_array('user_role_set', $allowedMenus)): ?>
          <li><a class="treeview-item" href="<?php echo site_url('role'); ?>" rel="noopener">
              <i class="icon fa fa-circle-o"></i> User Role Set</a></li>
        <?php endif; ?>
      </ul>
    </li>
<?php endif;?>


 <?php
    $active = in_array($current_menu, ['stockreport', 'salesummeryreport', 'profitloss','expensereport','customerreport']);
    // Check if user has at least one Sales privilege
    $reportPrivileges = ['stock_report', 'sale_report', 'profit_loss','expense_report','customer_report'];
    $hasReportPrivilege = false;

    foreach ($reportPrivileges as $priv) {
      if (in_array($priv, $allowedMenus)) {
        $hasReportPrivilege = true;
        break;
      }
    }
    ?>
    <?php if ($hasReportPrivilege): ?>
    <li class="treeview <?php echo ($active) ? "is-expanded" : "" ?>">
      <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-laptop"
          aria-hidden="true">
        </i><span class="app-menu__label">Report Section</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
         <?php if (in_array('stock_report', $allowedMenus)): ?>
        <li><a class="treeview-item" href="<?php echo site_url('stockreport'); ?>"><i class="icon fa fa-circle-o"></i>
            Stock Report</a></li>
            <?php endif;?>
             <?php if (in_array('sale_report', $allowedMenus)): ?>
        <li><a class="treeview-item" href="<?php echo site_url('salesummeryreport'); ?>" rel="noopener"><i
              class="icon fa fa-circle-o"></i>Sale Report</a></li>
              <?php endif;?>
               <?php if (in_array('profit_loss', $allowedMenus)): ?>
        <li><a class="treeview-item" href="<?php echo site_url('profitloss'); ?>" rel="noopener"><i
              class="icon fa fa-circle-o"></i>Profit & Loss</a></li>
              <?php endif;?>
               <?php if (in_array('expense_report', $allowedMenus)): ?>
        <li><a class="treeview-item" href="<?php echo site_url('expensereport'); ?>" rel="noopener"><i class="icon fa fa-circle-o"></i>Expense
            Report</a></li>
            <?php endif;?>
        <!-- <li><a class="treeview-item" href="#" rel="noopener"><i class="icon fa fa-circle-o"></i>Supplier Report</a></li> -->
          <?php if (in_array('expense_report', $allowedMenus)): ?>
        <li><a class="treeview-item" href="<?php echo site_url('customerreport');?>" rel="noopener"><i class="icon fa fa-circle-o"></i>Customer Report</a></li>
       <?php endif;?>
        <li><a class="treeview-item" href="#" rel="noopener"><i class="icon fa fa-circle-o"></i>Vat/Tax Report</a></li>
      </ul>
    </li>
    <?php endif;?>




 <?php
    $active = in_array($current_menu, ['fromcustomer']);
    // Check if user has at least one Sales privilege
    $paymentPrivileges = ['receive_customer'];
    $hasPaymentPrivilege = false;

    foreach ($paymentPrivileges as $priv) {
      if (in_array($priv, $allowedMenus)) {
        $hasPaymentPrivilege = true;
        break;
      }
    }
    ?>
    <?php if ($hasPaymentPrivilege): ?>
    <li class="treeview <?php echo ($active) ? "is-expanded" : "" ?>">
       <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-laptop"
          aria-hidden="true">
        </i><span class="app-menu__label">Payment Section</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <?php if (in_array('receive_customer', $allowedMenus)): ?>
        <li><a class="treeview-item" href="<?php echo site_url('fromcustomer'); ?>"><i
              class="icon fa fa-circle-o"></i>Receive Customer</a></li>
              <?php endif;?>
        <!-- <li><a class="treeview-item" href="<?php echo site_url('#'); ?>" rel="noopener"><i
              class="icon fa fa-circle-o"></i>Supplier Payment</a></li> -->
      </ul>
    </li>
<?php endif;?>

 <?php
    $active = in_array($current_menu, ['generalsettings','currency','tax']);
    // Check if user has at least one Sales privilege
    $settingsPrivileges = ['general_settings','currency_settings','tax_setup'];
    $hasSettingsPrivilege = false;

    foreach ($settingsPrivileges as $priv) {
      if (in_array($priv, $allowedMenus)) {
        $hasSettingsPrivilege = true;
        break;
      }
    }
    ?>
<?php if ($hasSettingsPrivilege): ?>
    <li class="treeview <?php echo ($active) ? "is-expanded" : "" ?>">
      <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-cog" aria-hidden="true">
        </i><span class="app-menu__label">Settings Section</span><i
          class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <?php if (in_array('general_settings', $allowedMenus)): ?>
        <li><a class="treeview-item" href="<?php echo site_url('generalsettings'); ?>"><i class="icon fa fa-plus-square"
              aria-hidden="true"></i>&nbsp; General Settings</a></li>
              <?php endif;?>
              <?php if (in_array('currency_settings', $allowedMenus)): ?>
        <li><a class="treeview-item" href="<?php echo site_url('currency'); ?>"><i class="icon fa fa-user-circle-o"
              aria-hidden="true"></i> Currency Settings</a></li>
              <?php endif;?>
              <?php if (in_array('tax_setup', $allowedMenus)): ?>
        <li> <a class="treeview-item" href="<?php echo site_url('tax'); ?>"><i class="icon fa fa-circle-o"></i>% Tax
            Setup </a></li>
            <?php endif;?>
        <!-- <li><a class="treeview-item" href="<?php echo site_url('#'); ?>" rel="noopener"><i class="icon fa fa-circle-o"></i> Database Backup</a></li> -->
      </ul>
    </li>
<?php endif;?>





    <!-- 
    <li class="treeview">
      <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-laptop" aria-hidden="true">
        </i><span class="app-menu__label">Return Section</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <li><a class="treeview-item" href="<?php echo site_url('#'); ?>"><i class="icon fa fa-circle-o"></i> Sales Return</a></li>
        <li><a class="treeview-item" href="<?php echo site_url('#'); ?>" rel="noopener"><i class="icon fa fa-circle-o"></i>Purchase Return</a></li>
      </ul>
    </li> -->
    <li><a class="app-menu__item" href="#"><i class="app-menu__icon fa fa-file-code-o"></i><span
          class="app-menu__label">Doc Help</span></a></li>
    <li><a class="app-menu__item" href="<?php echo site_url('logout'); ?>"><i
          class="app-menu__icon fa fa-file-code-o"></i><span class="app-menu__label">Logout</span></a></li>

  </ul>

</aside>