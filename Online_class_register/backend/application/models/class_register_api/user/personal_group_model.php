<?php

class personal_group_model extends CI_Model{

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

    public function get_group($group_id){
        $this->db->select("*");
        $this->db->from("tbl_groups");
        $this->db->where("group_id",$group_id);
        $query = $this->db->get();
        return $query->result();
    }

}

?>