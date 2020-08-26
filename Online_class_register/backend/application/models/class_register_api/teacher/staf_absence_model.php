<?php

class staf_absence_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        //load database
        $this->load->database();
        //$this->db
    }

    //CRUD METHODS


    public function get_all_absence($teacher_id){
        $this->db->select('ta.absence_id, ta.absence_lesson_number, ta.absence_date, ta.absence_created_at, CONCAT( ts.student_name, " ", ts.student_surname ) AS absence_student');
        $this->db->from("tbl_absence AS ta");
        $this->db->join('tbl_students AS ts','ts.student_id = ta.absence_student_id');
        $this->db->where("absence_teacher_id",$teacher_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_absence($absence_id){
        $this->db->select('ta.absence_id, ta.absence_lesson_number, ta.absence_date, ta.absence_created_at, CONCAT( ts.student_name, " ", ts.student_surname ) AS absence_student');
        $this->db->from("tbl_absence AS ta");
        $this->db->join('tbl_students AS ts','ts.student_id = ta.absence_student_id');
        $this->db->where("absence_id",$absence_id);
        $query = $this->db->get();
        return $query->result();
    }

}

?>