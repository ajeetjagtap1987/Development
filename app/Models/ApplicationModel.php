<?php

namespace App\Models;

use CodeIgniter\Model;

class ApplicationModel extends Model
{
    protected $table = 'application';
    // .. other member variables
   
    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
        // OR $this->db = db_connect();
    }


    public function getApplicationDataByName($searchTerm)
    {
        $builder = $this->db->table($this->table);
        $builder->select('*');
        $builder->like('name', $searchTerm);
        $builder->where('deleted_by', NULL);
        $builder->orderBy('created_date ASC');
        $query  = $builder->get();
        return $query->getResultArray();
    }
}