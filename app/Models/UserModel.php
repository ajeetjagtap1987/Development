<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';


    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();


    }

    public function insert_data($data = array())
    {
        $this->db->table($this->table)->insert($data);

        return $this->db->insertID();
    }

    public function update_data($id, $data = array())
    {
        $this->db->table($this->table)->update($data, array(
            "id" => $id,
        ));

        //echo $this->db->getLastQuery();die;
        return $this->db->affectedRows();
    }

    public function delete_data($id)
    {
        // return $this->db->table($this->table)->delete(array(
        //     "id" => $id,
        // ));

        $this->db->table($this->table)->delete(["id" => $id]);


        return true;
    }

    public function userCheck($email)
    {
        $builder = $this->db->table($this->table);
        $builder->select('*');
        $builder->where('email', $email);
        $builder->where('deleted_by', NULL);
        $query  = $builder->get();
        return $query->getResultArray();

    }

    public function getUserById($id)
    {
        $query = $this->db->query('select * from '.$this->table.' where id="'.$id.'"');
        return $query->getResultArray();
    }


    public function getUserByFilterCount( $keyword, $filter, $limit = NULL, $start = NULL) {
        $group = $this->db->table($this->table);

        //$this->db->query('select * from '.$this->table);

        if( isset($filter['created_date']) && $filter['created_date'] != '' ) {
            $str = explode(" - ",$filter['created_date']);
            $str1=str_replace("/","-",trim($str[0]));
            $str2=str_replace("/","-",trim($str[1]));
            $group->where( "date(u.created_date) between '".$str1."' and '".$str2."'");
        }
        if( isset($filter['show']) && $filter['show'] != '' ) {
            $group->where( 'u.is_active', $filter['show'] );
        }
        if(!empty($keyword)) {
            $where = " (u.f_name like '%".$keyword."%' or u.mobile like '%".$keyword."%')";
            $group->where( $where);
        }
        // if( $filter['order_by'] !='' ) {
        //     $group->order_by( 'u.'.$filter['sort_by'], $filter['order_by'] );
        // }
        $group->limit($limit, $start);

        $query = $group->get();

        //  echo $this->db->last_query();
        $result = $query->getNumRows();
        return $result;
    }

    public function getUserByFilter( $keyword, $filter, $limit = NULL, $start = NULL) {
        $group = $this->db->table($this->table);
        //->where('name', $groupName)->get()->getFirstRow()

        //$this->db->query('select * from '.$this->table);
        // $this->db->join('lead_comments as lc', 'u.id = lc.lead_id', 'left');

        if( isset($filter['created_date']) && $filter['created_date'] != '' ) {
            $str = explode(" - ",$filter['created_date']);
            $str1=str_replace("/","-",trim($str[0]));
            $str2=str_replace("/","-",trim($str[1]));
            $group->where( "date(u.created_date) between '".$str1."' and '".$str2."'");
        }
        if( isset($filter['show']) && $filter['show'] != '' ) {
            $group->where( 'u.is_active', $filter['show'] );
        }
        if(!empty($keyword)) {
            $where = " (u.f_name like '%".$keyword."%' or u.mobile like '%".$keyword."%')";
            $group->where( $where);
        }
        //$group->group_by( 'u.id');
        if( $filter['order_by'] !='' ) {
            $group->order_by( 'u.'.$filter['sort_by'], $filter['order_by'] );
        }
        $group->limit($limit, $start);
        $query = $group->get();
        //  echo $this->db->last_query();
        $result = $query->getResultArray();
        return $result;
    }

    public function getAllAssignedDataByColumnName($table,$coloumnname,$value)
    {
        $builder = $this->db->table($table);
        $builder->select('*');
        $builder->where($coloumnname, $value);
        $builder->where('status', ASSIGNED);
        $builder->orderBy('created_date ASC');
        $query  = $builder->get();
        return $query->getResultArray();
    }
}