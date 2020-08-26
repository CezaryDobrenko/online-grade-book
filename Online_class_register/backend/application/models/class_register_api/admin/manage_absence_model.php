<?php

class manage_absence_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        //load database
        $this->load->database();
        //$this->db
    }

    //CRUD METHODS

    public function create_absence($absence_data){
        return $this->db->insert("tbl_absence",$absence_data);
    }

    public function get_all_absence(){
        $this->db->select("*");
        $this->db->from("tbl_absence");
        $query = $this->db->get();
        return $query->result();
    }

    public function get_absence($absence_id){
        $this->db->select("*");
        $this->db->from("tbl_absence");
        $this->db->where("absence_id",$absence_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function update_absence($absence_id, $absence_data){
        $this->db->where("absence_id", $absence_id);
        return $this->db->update("tbl_absence",$absence_data);
    }

    public function delete_absence($absence_id){
        $this->db->where("absence_id", $absence_id);
        return $this->db->delete("tbl_absence");
    }

    // HELPER METHODS

    public function find_by_id($absence_id){
        $this->db->select("*");
        $this->db->from("tbl_absence");
        $this->db->where("absence_id", $absence_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function is_teacher_exists($teacher_id){
        $this->db->select("*");
        $this->db->from("tbl_teachers");
        $this->db->where("teacher_id",$teacher_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function is_student_exists($student_id){
        $this->db->select("*");
        $this->db->from("tbl_students");
        $this->db->where("student_id",$student_id);
        $query = $this->db->get();
        return $query->row();
    }

}

?>