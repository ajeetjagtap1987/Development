<?php

namespace App\Models;

use CodeIgniter\Model;

class LicenseModel extends Model
{
    protected $table = 'license';
    // .. other member variables
   
    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
        // OR $this->db = db_connect();
    }

    public function getAssetDataBySoftwareName($searchTerm)
    {
       // $where = "(model_name like '".$searchTerm."%')";
        $builder = $this->db->table($this->table);
        $builder->select('*');
       // $builder->where($where);
        $builder->like('software_name', $searchTerm);
        $builder->where('deleted_by', NULL);
        $builder->orderBy('created_date ASC');
        $query  = $builder->get();
        return $query->getResultArray();
    }
}