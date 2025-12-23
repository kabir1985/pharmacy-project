<?php
namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
 {
    protected $table = 'user';

    protected $primaryKey = 'user_id';

    protected $allowedFields = ['user_name', 'user_email', 'login_id', 'login_password', 'user_role_id'];
}