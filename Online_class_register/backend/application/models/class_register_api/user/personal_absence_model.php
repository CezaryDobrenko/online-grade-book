<?php

class personal_absence_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        //load database
        $this->load->database();
        //$this->db
    }

    public function get_all_absence($student_id){
        $this->db->select('ta.absence_id, ta.absence_lesson_number, ta.absence_date, ta.absence_created_at, CONCAT( tt.teacher_name, " ", tt.teacher_surname ) AS absence_teacher_fullname');
        $this->db->from("tbl_absence AS ta");
        $this->db->join('tbl_teachers AS tt','tt.teacher_id = ta.absence_teacher_id');
        $this->db->where("absence_student_id",$student_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_absence($absence_id, $student_id){
        $this->db->select('ta.absence_id, ta.absence_lesson_number, ta.absence_date, ta.absence_created_at, CONCAT( tt.teacher_name, " ", tt.teacher_surname ) AS absence_teacher_fullname');
        $this->db->from("tbl_absence AS ta");
        $this->db->join('tbl_teachers AS tt','tt.teacher_id = ta.absence_teacher_id');
        $this->db->where("absence_student_id",$student_id);
        $this->db->where("absence_id",$absence_id);
        $query = $this->db->get();
        return $query->result();
    }



}

?>