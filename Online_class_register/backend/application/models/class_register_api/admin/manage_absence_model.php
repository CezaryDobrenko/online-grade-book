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
        $this->db->select("a.absence_id, a.absence_lesson_number, a.absence_date, a.absence_created_at, a.absence_is_justified, b.teacher_email, c.student_email");
        $this->db->from("tbl_absence as a");
		$this->db->join('tbl_teachers as b', 'absence_teacher_id = teacher_id', 'left');
		$this->db->join('tbl_students as c', 'absence_student_id = student_id', 'left');
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