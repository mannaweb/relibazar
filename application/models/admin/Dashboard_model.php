<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}


	public function getUsers(){
        $this->db->select('id');
        $this->db->from('users');
         $this->db->where('status',1);
         $this->db->where('role','admin');
        $query = $this->db->get()->num_rows();
        return $query;

    }

    public function getCategories(){
        $this->db->select('id');
        $this->db->from('categories');
        $this->db->where('status',1);
        $query = $this->db->get()->num_rows();
        return $query;

    }

    public function getProducts(){
        $this->db->select('id');
        $this->db->from('products');
        $this->db->where('status',1);
        $this->db->where('deleted_at',NULL);
        $query = $this->db->get()->num_rows();
        return $query;

    }

     public function getOrders(){
        $this->db->select('id');
        $this->db->from('orders');
        $query = $this->db->get()->num_rows();
        return $query;

    }
	
}
?>