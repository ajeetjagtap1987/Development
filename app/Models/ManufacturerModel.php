<?php

namespace App\Models;

use CodeIgniter\Model;

class ManufacturerModel extends Model
{
    protected $table = 'manufacturer';
    // .. other member variables
   
    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
        // OR $this->db = db_connect();
    }
}