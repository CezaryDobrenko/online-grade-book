<?php

class staf_student_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        //load database
        $this->load->database();
        //$this->db
    }

    public function get_all_student(){
        $this->db->select('student_id, student_name, student_surname');
        $this->db->from("tbl_students");
        $query = $this->db->get();
        return $query->result();
    }

    public function get_by_group_student($group_id){
        $this->db->select('student_id, student_name, student_surname');
        $this->db->from("tbl_students");
        $this->db->where("student_group_id",$group_id);
        $query = $this->db->get();
        return $query->result();
    }

}

?>