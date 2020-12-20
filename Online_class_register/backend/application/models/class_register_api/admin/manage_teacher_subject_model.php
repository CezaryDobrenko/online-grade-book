<?php

class manage_teacher_subject_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        //load database
        $this->load->database();
        //$this->db
    }

    //CRUD METHODS

    public function create_teacher_subject($teacher_subject_data){
        return $this->db->insert("tbl_subject_has_teacher",$teacher_subject_data);
    }

    public function get_all_teacher_subject(){
        $this->db->select("a.subject_has_teacher_id, b.teacher_email, c.subject_name");
        $this->db->from("tbl_subject_has_teacher as a");
		$this->db->join('tbl_teachers as b', 'subject_has_teacher_teacher_id = teacher_id', 'left');
		$this->db->join('tbl_subjects as c', 'subject_has_teacher_subject_id = subject_id', 'left');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_teacher_subject($teacher_subject_id){
        $this->db->select("*");
        $this->db->from("tbl_subject_has_teacher");
        $this->db->where("subject_has_teacher_id",$teacher_subject_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function update_teacher_subject($teacher_subject_id, $teacher_subject_data){
        $this->db->where("subject_has_teacher_id", $teacher_subject_id);
        return $this->db->update("tbl_subject_has_teacher",$teacher_subject_data);
    }

    public function delete_teacher_subject($teacher_subject_id){
        $this->db->where("subject_has_teacher_id", $teacher_subject_id);
        return $this->db->delete("tbl_subject_has_teacher");
    }

    // HELPER METHODS

    public function find_by_id($teacher_subject_id){
        $this->db->select("*");
        $this->db->from("tbl_subject_has_teacher");
        $this->db->where("subject_has_teacher_id", $teacher_subject_id);
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

    public function is_subject_exists($subject_id){
        $this->db->select("*");
        $this->db->from("tbl_subjects");
        $this->db->where("subject_id",$subject_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function is_teacher_subject_relation_exists($subject_id, $teacher_id){
        $this->db->select("*");
        $this->db->from("tbl_subject_has_teacher");
        $this->db->where("subject_has_teacher_subject_id", $subject_id);
        $this->db->where("subject_has_teacher_teacher_id", $teacher_id);
        $query = $this->db->get();
        return $query->row();
    }

}

?>