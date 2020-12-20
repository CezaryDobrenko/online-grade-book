<?php

class staf_category_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        //load database
        $this->load->database();
        //$this->db
    }

    public function get_category(){
        $this->db->select("*");
        $this->db->from("tbl_grades_category");
        $query = $this->db->get();
        return $query->result();
    }

}

?>