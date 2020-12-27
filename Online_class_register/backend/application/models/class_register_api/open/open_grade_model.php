<?php

class open_grade_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        //load database
        $this->load->database();
        //$this->db
    }

    public function get_all_grades(){
        $this->db->select("a.grade_value, b.grade_category_name, c.subject_name");
        $this->db->from("tbl_grades as a");
		$this->db->join('tbl_grades_category as b', 'b.grade_category_id = a.grade_category_id', 'left');
		$this->db->join('tbl_subjects as c', 'c.subject_id = a.grade_subject_id', 'left');
        $query = $this->db->get();
        return $query->result();
    }

}

?>