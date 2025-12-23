<?php
 namespace App\Models;
use CodeIgniter\Model;

class GeneralSettingsModel extends Model
 {
    protected $table = 'general_settings';

    protected $primaryKey = 'id';

    protected $allowedFields = ['company_name','company_email','country','currency_id','company_phone','company_logo', 'company_address'];

} 

