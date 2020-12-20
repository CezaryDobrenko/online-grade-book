<?php

class staf_grades_category_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        //load database
        $this->load->database();
        //$this->db
    }

    public function get_category(){
        $this->db->select("grade_category_id, grade_category_name");
        $this->db->from("tbl_grades_category");
        $query = $this->db->get();
        return $query->result();
    }

}

?>