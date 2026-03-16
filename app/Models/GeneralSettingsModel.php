<?php
 namespace App\Models;
use CodeIgniter\Model;

class GeneralSettingsModel extends Model
 {
    protected $table = 'general_settings';

    protected $primaryKey = 'id';

    protected $allowedFields = ['company_name','company_email','country','currency_id','company_phone','company_logo', 'company_address'];


    public function getSettings()
    {
        return $this->db->table('general_settings')
            ->select('general_settings.*, currency.currency_name, currency.currency_symbol')
            ->join('currency', 'currency.id = general_settings.currency_id', 'left')
            ->get()
            ->getRowArray();
    }

    

} 

