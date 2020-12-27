<?php

class personal_grade_model extends CI_Model{

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
        $this->db->join('tbl_subjects AS ts','ts.subject_id = tgs.group_subject_subject_id', "left");
        $this->db->where("group_subject_group_id",$group_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_all_grade($student_id){
        $this->db->select('tg.grade_id, tg.grade_value, tg.grade_comment, tg.grade_semester, tg.grade_kind, tg.grade_created_at, ts.subject_name AS grade_subject_name, tgc.grade_category_name, tgc.grade_category_weight, tgc.grade_category_color, CONCAT( tt.teacher_name, " ", tt.teacher_surname ) AS grade_teacher_fullname');
        $this->db->from("tbl_grades AS tg");
        $this->db->join('tbl_subjects AS ts','ts.subject_id = tg.grade_subject_id', "left");
        $this->db->join('tbl_teachers AS tt','tt.teacher_id = tg.grade_teacher_id', "left");
        $this->db->join('tbl_grades_category AS tgc','tgc.grade_category_id = tg.grade_category_id', "left");
        $this->db->where("grade_student_id",$student_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_grade($grade_id){
        $this->db->select('tg.grade_id, tg.grade_value, tg.grade_comment, tg.grade_semester, tg.grade_kind, tg.grade_created_at, ts.subject_name AS grade_subject_name, tgc.grade_category_name, tgc.grade_category_weight, CONCAT( tt.teacher_name, " ", tt.teacher_surname ) AS grade_teacher_fullname');
        $this->db->from("tbl_grades AS tg");
        $this->db->join('tbl_subjects AS ts','ts.subject_id = tg.grade_subject_id', "left");
        $this->db->join('tbl_teachers AS tt','tt.teacher_id = tg.grade_teacher_id', "left");
        $this->db->join('tbl_grades_category AS tgc','tgc.grade_category_id = tg.grade_category_id', "left");
        $this->db->where("grade_id", $grade_id);
        $query = $this->db->get();
        return $query->row();
    }


}

?>