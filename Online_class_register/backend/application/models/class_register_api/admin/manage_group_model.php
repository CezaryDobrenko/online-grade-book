<?php

class manage_group_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        //load database
        $this->load->database();
        //$this->db
    }

    //CRUD METHODS

    public function create_group($group_data){
        return $this->db->insert("tbl_groups",$group_data);
    }

    public function get_all_groups(){
        $this->db->select("*");
        $this->db->from("tbl_groups");
        $query = $this->db->get();
        return $query->result();
    }

    public function get_group($group_id){
        $this->db->select("*");
        $this->db->from("tbl_groups");
        $this->db->where("group_id",$group_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function update_group($group_id, $group_data){
        $this->db->where("group_id", $group_id);
        return $this->db->update("tbl_groups",$group_data);
    }

    public function delete_group($group_id){
        $this->db->where("group_id", $group_id);
        return $this->db->delete("tbl_groups");
    }

    // HELPER METHODS

    public function is_group_name_exists($email){
        $this->db->select("*");
        $this->db->from("tbl_groups");
        $this->db->where("group_name",$email);
        $query = $this->db->get();
        return $query->row();
    }

    public function find_by_id($group_id){
        $this->db->select("*");
        $this->db->from("tbl_groups");
        $this->db->where("group_id", $group_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function is_group_name_unique($email, $group_id){
        $this->db->select("*");
        $this->db->from("tbl_groups");
        $this->db->where("group_name",$email);
        $this->db->where("group_id !=",$group_id);
        $query = $this->db->get();
        return $query->row();
    }

}

?>