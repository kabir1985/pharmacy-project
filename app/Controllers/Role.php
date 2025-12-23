<?php
namespace App\Controllers;
use App\Models\UserRoleModel;
use CodeIgniter\HTTP\IncomingRequest;
class Role extends BaseController
{
   private $user_role_model_obj;
   private $db;
   public function __construct()
   {
      $this->user_role_model_obj = new UserRoleModel();
      $this->db = db_connect();
   }
   public function index()
   {
      // Fetch roles
      $roles = $this->db->table('user_role')->get()->getResultArray();
      // Fetch menus ordered by menu_id
      $menus = $this->db->table('menu_id')->orderBy('menu_id')->get()->getResultArray();
      // Map of target menus: menu_name => Label
      $targetMenus = [
         'initial_product' => 'Add Product',
         'barcode_generate' => 'Barcode Generate',
         'product_category' => 'Product Category',
         'product_brand' => 'Product Brand',
         'product_group' => 'Product Group',
         'product_unit' => 'Product Unit',
         'pos_sale' => 'Pos Sale',
         'general_sale' => 'General Sale',
         'sale_list' => 'Sale List',
         'sale_return' => 'Sale Return',
         'sale_return_list' => 'Sale Return List',
         'purchase_product' => 'Purchase Product',
         'expense_category' => 'Expense Category',
         'expense_sub_category' => 'Exp Sub-Categoy',
         'expense_add' => 'Expense Add',
         'customer_group' => 'Customer Group',
         'customer_add' => 'Customer Add',
         'supplier_add' => 'Supplier Add',
         'user_creation' => 'User Creation',
         'user_role_set' => 'User Role Set',
         'receive_customer' => 'Receive Customer',
         'supplier_payment' => 'Supplier Payment',
         'general_settings' => 'General Settings',
         'currency_settings' => 'Currency Settings',
         'tax_setup' => 'Tax Setup',
         'stock_report' => 'Stock Report',
         'sale_report' => 'Sale Report',
         'profit_loss' => 'Profit Loss',
         'expense_report' => 'Expense Report',
         'supplier_report' => 'Supplier Report',
         'customer_report' => 'Customer Report',
         'vat_tax_report' => 'Vat-Tax Report'
      ];
      // Map menu_name to index position
      $menuIndexMap = [];
      foreach ($menus as $index => $menu) {
         if (array_key_exists($menu['menu_name'], $targetMenus)) {
            $menuIndexMap[$menu['menu_name']] = $index;
         }
      }
      $data = [];
      foreach ($roles as $role) {
         $privileges = explode(',', $role['user_previlege']);
         $inline = '';

         foreach ($targetMenus as $menuName => $label) {
            $index = $menuIndexMap[$menuName] ?? null;
            $status = ($index !== null && isset($privileges[$index]) && $privileges[$index] != 0) ? '✅' : '❌';
            $inline .= $status . ' ' . $label . ' ';
         }
         $data[] = [
            'role_holder' => $role['role_holder'],
            'user_role_id' => $role['user_role_id'],
            'user_previlege' => $role['user_previlege'],
            'privilege_text' => trim($inline)
         ];
      }
      return view('user/role_add', ['roles' => $data, 'menus' => $menus]);
   }
   //--------------------------------------------------------------------//
   public function create()
   {
      $roleHolderName = $this->request->getPost('role_holder_name');
      $permissions = $this->request->getPost('permissions');

      if (empty($roleHolderName)) {
         return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Role Holder Name is required.'
         ]);
      }

      if (!is_array($permissions)) {
         return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Invalid permissions data.'
         ]);
      }
      // Convert permission array to comma-separated string
      // Example output: 1,2,3,0,0,6,...
      $permissionsString = implode(',', $permissions);

      // Prepare data for insert
      $data = [
         'role_holder' => $roleHolderName,
         'user_previlege' => $permissionsString
      ];
      // Insert into DB
      if ($this->user_role_model_obj->insert($data)) {
         return $this->response->setJSON([
            'status' => 'success',
            'message' => 'User role saved successfully.'
         ]);
      } else {
         return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Failed to save user role.'
         ]);
      }
   }

   //--------------------------------------------------------------------//




public function updateUserRole( $role_id = 0)
{
    $db = \Config\Database::connect();

    $role_id = $this->request->getPost('role_id');
// echo $role_id;
// exit();

    $role_holder_name = $this->request->getPost('role_holder_name');
    $menu_perm = $this->request->getPost('menu_perm'); // Array of selected menu_ids

    $allMenus = $db->table('menu_id')->get()->getResultArray();
    $menu_ids = array_column($allMenus, 'menu_id');

    // Build user_previlege list — keep 0 for unchecked items
    $user_previlege = [];
    foreach ($menu_ids as $id) {
        $user_previlege[] = in_array($id, $menu_perm ?? []) ? $id : 0;
    }

    $privilege_text = implode(',', $user_previlege); // E.g., "1,0,3,0,0,6"

    $db->table('user_role')->where('user_role_id', $role_id)->update([
        'role_holder' => $role_holder_name,
        'user_previlege' => $privilege_text
    ]);

    return redirect()->to(site_url('role'))->with('msg', 'Role updated successfully.');
}



   ///--------------------------------------------------------------------///
   public function update($id = 0)
   {

      $id = $this->request->getVar('expense_category_id');

      $data = [
         'expense_category_name' => $this->request->getVar('expense_category_name_update'),
      ];
      $this->expense_category_model_object->update($id, $data);
   }

   public function delete($id = 0)
   {

      $id = $this->request->getVar('delete_id');

      $this->expense_category_model_object->where('expense_category_id', $id)->delete();
      //$this->NewProductAddModel_Object->where('product_id', $id)->delete();

      //return into supplier page
      return $this->response->redirect(site_url('/Expensecategory'));
   }
}
