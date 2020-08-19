<?php

class manage_parent_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        //load database
        $this->load->database();
        //$this->db
    }

    public function get_all_parents(){
        $this->db->select("*");
        $this->db->from("tbl_parents");
        $query = $this->db->get();
        return $query->result();
    }

}

?>