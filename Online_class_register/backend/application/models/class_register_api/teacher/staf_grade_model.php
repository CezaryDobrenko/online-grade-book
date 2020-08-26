<?php

class staf_grade_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        //load database
        $this->load->database();
        //$this->db
    }

    //CRUD METHODS


    public function get_all_grade($teacher_id){
        $this->db->select('tg.grade_id,tg.grade_value,tg.grade_comment,tg.grade_created_at,tgc.grade_category_name, ts.subject_name AS grade_subject_name, CONCAT( tsu.student_name, " ", tsu.student_surname ) AS grade_student');
        $this->db->from("tbl_grades AS tg");
        $this->db->join('tbl_students AS tsu','tsu.student_id = tg.grade_student_id');
        $this->db->join('tbl_grades_category AS tgc','tgc.grade_category_id = tg.grade_category_id');
        $this->db->join('tbl_subjects AS ts','ts.subject_id = tg.grade_subject_id');
        $this->db->where("grade_teacher_id",$teacher_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_grade($grade_id){
        $this->db->select('tg.grade_id,tg.grade_value,tg.grade_comment,tg.grade_created_at,tgc.grade_category_name, ts.subject_name AS grade_subject_name, CONCAT( tsu.student_name, " ", tsu.student_surname ) AS grade_student');
        $this->db->from("tbl_grades AS tg");
        $this->db->join('tbl_students AS tsu','tsu.student_id = tg.grade_student_id');
        $this->db->join('tbl_grades_category AS tgc','tgc.grade_category_id = tg.grade_category_id');
        $this->db->join('tbl_subjects AS ts','ts.subject_id = tg.grade_subject_id');
        $this->db->where("grade_id",$grade_id);
        $query = $this->db->get();
        return $query->result();
    }

}

?>