<?php

namespace App\Models;

use CodeIgniter\Model;

class VendorGstModel extends Model
{
    protected $table = 'vendor_gst_detail';
    // .. other member variables
   
    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
        // OR $this->db = db_connect();
    }
}