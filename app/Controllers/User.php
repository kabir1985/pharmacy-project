<?php

namespace App\Controllers;

use App\Models\UserModel;

use CodeIgniter\HTTP\IncomingRequest;

class User extends BaseController
{
   private $user_model_object;
   private $db;

   public function __construct()
   {
      $this->user_model_object = new UserModel();
      $this->db = db_connect();
   }

   public function index()
   {
   $sql = "SELECT user_role.user_role_id, user_role.role_holder, 
            user.user_id, user.login_id, user.login_password, user.user_name, user.user_email
   FROM user 
   LEFT JOIN user_role ON user_role.user_role_id = user.user_role_id ";

   $data['user_show'] = $this->db->query($sql)->getResult('array');

      return view('user/user_add', $data);
   }

   //--------------------------------------------------------------------//
   public function create()
   {
      $data = [
         'user_name'      => $this->request->getVar('user_name'),
         'user_email'     => $this->request->getVar('user_email'),
         'login_id'       => $this->request->getVar('login_id'),
         'login_password' => $this->request->getVar('login_password'),
         'user_role_id'   => $this->request->getVar('user_role_id')
      ];
      //$df = new ProductCategoryModel();
      $id =  $this->user_model_object->insert($data);
      if ($id > 0) {
         echo "1";
      } else {
         echo "0";
      }
   }

   //--------------------------------------------------------------------//
   public function update($id = 0)
   {

      $id   = $this->request->getVar('user_id');

      $data = [
         'user_name'      => $this->request->getVar('user_name'),
         'user_email'     => $this->request->getVar('user_email'),
         'login_id'       => $this->request->getVar('login_id'),
         'login_password' => $this->request->getVar('login_password'),
         'user_role_id'   => $this->request->getVar('user_role_id_edit')
      ];
    $id = $this->user_model_object->update($id, $data);
      if ($id > 0) {
         echo "1";
      } else {
         echo "0";
      }
   }

   public function delete($id = 0)
   {

      $id = $this->request->getVar('delete_id');

      $this->user_model_object->where('user_id', $id)->delete();

      //return into supplier page
      return $this->response->redirect(site_url('/User'));
   }
}