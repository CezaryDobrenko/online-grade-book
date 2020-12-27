<?php

class open_group_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        //load database
        $this->load->database();
        //$this->db
    }

    public function get_all_groups(){
        $this->db->select("group_name, group_stage");
        $this->db->from("tbl_groups");
        $query = $this->db->get();
        return $query->result();
    }

}

?>