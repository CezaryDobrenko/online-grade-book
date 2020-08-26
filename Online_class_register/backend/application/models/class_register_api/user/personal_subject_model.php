<?php

class personal_subject_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        //load database
        $this->load->database();
        //$this->db
    }

    public function find_student_group($student_id){
        $this->db->select("*");
        $this->db->from("tbl_students");
        $this->db->where("student_id", $student_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_all_subject($group_id){
        $this->db->select("ts.subject_name");
        $this->db->from("tbl_groups_subjects AS tgs");
        $this->db->join('tbl_subjects AS ts','ts.subject_id = tgs.group_subject_subject_id');
        $this->db->where("group_subject_group_id",$group_id);
        $query = $this->db->get();
        return $query->result();
    }

}

?>