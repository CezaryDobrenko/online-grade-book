<?php

class staf_tutor_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        //load database
        $this->load->database();
        //$this->db
    }

    //CRUD METHODS

    public function get_all_students($group_id){
        $this->db->select('*');
        $this->db->from("tbl_students");
        $this->db->where("student_group_id",$group_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_all_absence($student_id){
        $this->db->select('ta.absence_id, ta.absence_lesson_number, ta.absence_date, ta.absence_is_justified, ta.absence_created_at, CONCAT( ts.student_name, " ", ts.student_surname ) AS absence_student, gs.group_short_name');
        $this->db->from("tbl_absence AS ta");
        $this->db->join('tbl_students AS ts','ts.student_id = ta.absence_student_id', 'left');
        $this->db->join('tbl_groups AS gs','gs.group_id = ts.student_group_id', 'left');
        $this->db->where("absence_student_id",$student_id);
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
    
    //HELPER METHODS

    public function find_by_id($absence_id){
        $this->db->select("*");
        $this->db->from("tbl_absence");
        $this->db->where("absence_id", $absence_id);
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

    public function is_teacher_creator($absence_id, $teacher_id){
        $this->db->select("*");
        $this->db->from("tbl_absence");
        $this->db->where("absence_id",$absence_id);
        $this->db->where("absence_teacher_id",$teacher_id);
        $query = $this->db->get();
        return $query->row();
    }

    
}

?>