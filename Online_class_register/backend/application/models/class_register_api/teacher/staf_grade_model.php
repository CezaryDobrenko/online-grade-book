<?php

class staf_grade_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        //load database
        $this->load->database();
        //$this->db
    }

    //CRUD METHODS

    public function create_grade($grade_data){
        return $this->db->insert("tbl_grades",$grade_data);
    }
    
    public function get_all_grade($teacher_id){
        $this->db->select('tg.grade_id,tg.grade_value,tg.grade_comment,tg.grade_created_at,tg.grade_semester,tg.grade_kind, tgc.grade_category_name, ts.subject_name AS grade_subject_name, CONCAT( tsu.student_name, " ", tsu.student_surname ) AS grade_student');
        $this->db->from("tbl_grades AS tg");
        $this->db->join('tbl_students AS tsu','tsu.student_id = tg.grade_student_id', 'left');
        $this->db->join('tbl_grades_category AS tgc','tgc.grade_category_id = tg.grade_category_id', 'left');
        $this->db->join('tbl_subjects AS ts','ts.subject_id = tg.grade_subject_id', 'left');
        $this->db->where("grade_teacher_id",$teacher_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_grade($grade_id){
        $this->db->select("*");
        $this->db->from("tbl_grades");
        $this->db->where("grade_id",$grade_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function update_grade($grade_id, $grade_data){
        $this->db->where("grade_id", $grade_id);
        return $this->db->update("tbl_grades",$grade_data);
    }

    public function delete_grade($grade_id){
        $this->db->where("grade_id", $grade_id);
        return $this->db->delete("tbl_grades");
    }


    //HELPER METHODS

    public function find_by_id($grade_id){
        $this->db->select("*");
        $this->db->from("tbl_grades");
        $this->db->where("grade_id", $grade_id);
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

    public function is_category_exists($category_id){
        $this->db->select("*");
        $this->db->from("tbl_grades_category");
        $this->db->where("grade_category_id",$category_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function is_subject_exists($subject_id){
        $this->db->select("*");
        $this->db->from("tbl_subjects");
        $this->db->where("subject_id",$subject_id);
        $query = $this->db->get();
        return $query->row();
    }
	
	public function is_final_or_middle_unique_u($student_id, $grade_kind, $subject_id, $grade_id, $semester){
        $this->db->select("*");
        $this->db->from("tbl_grades");
        $this->db->where("grade_student_id",$student_id);
        $this->db->where("grade_kind",$grade_kind);
        $this->db->where("grade_subject_id",$subject_id);
        $this->db->where("grade_semester",$semester);
        $this->db->where("grade_id !=",$grade_id);
        $query = $this->db->get();
        return $query->row();
    }
	
	public function is_final_or_middle_unique_c($student_id, $grade_kind, $subject_id, $semester){
        $this->db->select("*");
        $this->db->from("tbl_grades");
        $this->db->where("grade_student_id",$student_id);
        $this->db->where("grade_kind",$grade_kind);
        $this->db->where("grade_subject_id",$subject_id);
        $this->db->where("grade_semester",$semester);
        $query = $this->db->get();
        return $query->row();
    }

    public function check_if_student_group_has_that_lesson($group_id, $subject_id){
        $this->db->select("*");
        $this->db->from("tbl_groups_subjects");
        $this->db->where("group_subject_subject_id",$subject_id);
        $this->db->where("group_subject_group_id",$group_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_group_from_student($student_id){
        $this->db->select("student_group_id");
        $this->db->from("tbl_students");
        $this->db->where("student_id", $student_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function is_teacher_has_subject($teacher_id, $subject_id){
        $this->db->select("*");
        $this->db->from("tbl_subject_has_teacher");
        $this->db->where("subject_has_teacher_subject_id", $subject_id);
        $this->db->where("subject_has_teacher_teacher_id", $teacher_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function is_teacher_creator($grade_id, $teacher_id){
        $this->db->select("*");
        $this->db->from("tbl_grades");
        $this->db->where("grade_id", $grade_id);
        $this->db->where("grade_teacher_id", $teacher_id);
        $query = $this->db->get();
        return $query->row();
    }

}

?>