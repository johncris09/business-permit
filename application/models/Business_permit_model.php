<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Business_permit_model extends CI_Model
{


	public $table = 'business_permit';
	
    public function __construct()
    {
        parent::__construct();
    }
 

	
    public function get_all_business_permit()
    { 
        return $this->db 
			->get($this->table);
    }

    
    public function insert($data)
    {
        
        $insert = $this->db->insert($this->table, $data);
        if(!$insert && $this->db->error()['code'] == 1062){
            return false;
        }else{
            return true;
        }
    }

    public function get_business_permit($data)
    {  
        $this->db->where($data);
        return $this->db->get($this->table)->result_array()[0];
    } 

    public function get_latest_sp_no()
    {
        return $this->db 
            ->order_by('id', 'desc')
			->get($this->table)
            ->result_array()[0]['sp_no'];
    }
 
 
    public function update($data)
    { 
        return $this->db
            ->where('id', $data['id'])
            ->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db
            ->where('id', $id)
            ->delete($this->table);
    }

 
}