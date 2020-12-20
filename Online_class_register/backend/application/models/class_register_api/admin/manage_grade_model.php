<?php

class manage_grade_model extends CI_Model{

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

    public function get_all_grades(){
        $this->db->select("a.grade_id, a.grade_value, a.grade_comment, a.grade_created_at, a.grade_semester, b.grade_category_name, d.student_email, c.teacher_email, e.subject_name");
        $this->db->from("tbl_grades as a");
		$this->db->join('tbl_grades_category as b', 'a.grade_category_id = b.grade_category_id', 'left');
		$this->db->join('tbl_teachers as c', 'grade_teacher_id = teacher_id', 'left');
		$this->db->join('tbl_students as d', 'grade_student_id = student_id', 'left');
		$this->db->join('tbl_subjects as e', 'grade_subject_id = subject_id', 'left');
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

    // HELPER METHODS

    public function find_by_id($grade_id){
        $this->db->select("*");
        $this->db->from("tbl_grades");
        $this->db->where("grade_id", $grade_id);
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

    public function check_if_student_group_has_that_lesson($group_id, $subject_id){
        $this->db->select("*");
        $this->db->from("tbl_groups_subjects");
        $this->db->where("group_subject_subject_id",$subject_id);
        $this->db->where("group_subject_group_id",$group_id);
        $query = $this->db->get();
        return $query->row();
    }

}

?>