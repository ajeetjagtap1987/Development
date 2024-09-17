<?php

namespace App\Models;

use CodeIgniter\Model;

class UserAssetsModel extends Model
{
    protected $table = 'user_assets';
    // .. other member variables
   
    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
        // OR $this->db = db_connect();
    }
}