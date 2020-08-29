<?php

class staf_group_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        //load database
        $this->load->database();
        //$this->db
    }

    public function get_all_group(){
        $this->db->select('group_id, group_name, group_short_name');
        $this->db->from("tbl_groups");
        $query = $this->db->get();
        return $query->result();
    }

}

?>