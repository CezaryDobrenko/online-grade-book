<?php

class open_category_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        //load database
        $this->load->database();
        //$this->db
    }

    public function get_all_categories(){
        $this->db->select("grade_category_name, grade_category_weight");
        $this->db->from("tbl_grades_category");
        $query = $this->db->get();
        return $query->result();
    }

}

?>