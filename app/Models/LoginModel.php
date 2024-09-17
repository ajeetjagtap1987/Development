<?php

namespace App\Models;

use CodeIgniter\Model;

// class LoginModel extends Model
// {

// protected $table   = 'user_master';


//     public function userCheck($email, $password)
//     {


//         // // $db->select("*");
//         // // $db->from('users');
//         // // $db->where('users.email', $email);
//         // // $db->where('users.user_password', md5($password));
//         // // $db->where('users.status', 1);

//         // $query = $db->query('select * from users where email="'.$email.'" & pwd="'.md5($password).'"');
//         // if ($query->num_rows() != 0) {
//         //     $row = $query->row();
//         //    // $thehashvalue= hash('sha256', $row->salt . hash('sha256', $password) );
//         //         $data = array(
//         //             'user_id' => $row->id,
//         //             'first_name' => $row->f_name,
//         //             'last_name' => $row->l_name,
//         //             'full_name' => $row->f_name.' '.$row->l_name,
//         //             'email' => $row->email,
//         //             'type' => $row->type,
//         //             'validated' => true
//         //         );
//         //         $this->session->set_userdata($data);
//         //         return true;
//         // } else {
//         //     return false;
//         // }
//     }
// }

class LoginModel extends Model
{
    protected $table = 'user';
    // .. other member variables

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
        // OR $this->db = db_connect();
    }

    public function userCheck($email)
    {
        $builder = $this->db->table($this->table);
        $builder->select('*');
        $builder->where('email', $email);
        $builder->whereIn('user_type',array(ADMIN,TECHNICIAN));
        $builder->where('deleted_by',NULL);
        $query  = $builder->get();
        return $query->getResultArray();
    }

}