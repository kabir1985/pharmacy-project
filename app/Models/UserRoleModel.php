<?php
namespace App\Models;
use CodeIgniter\Model;

class UserRoleModel extends Model
 {
    protected $table = 'user_role';

    protected $primaryKey = 'user_role_id';

    protected $allowedFields = ['role_holder', 'user_previlege'];
}