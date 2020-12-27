<?php

class personal_note_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        //load database
        $this->load->database();
        //$this->db
    }

    public function get_all_note($student_id){
        $this->db->select('tn.note_id, tn.note_comment, tn.note_created_at, CONCAT( tt.teacher_name, " ", tt.teacher_surname ) AS note_teacher_fullname');
        $this->db->from("tbl_notes AS tn");
        $this->db->where("note_student_id",$student_id);
        $this->db->join('tbl_teachers AS tt','tt.teacher_id = tn.note_teacher_id', "left");
        $query = $this->db->get();
        return $query->result();
    }

    public function get_note($note_id, $student_id){
        $this->db->select('tn.note_id, tn.note_comment, tn.note_created_at, CONCAT( tt.teacher_name, " ", tt.teacher_surname ) AS note_teacher_fullname');
        $this->db->from("tbl_notes AS tn");
        $this->db->join('tbl_teachers AS tt','tt.teacher_id = tn.note_teacher_id', "left");
        $this->db->where("note_student_id",$student_id);
        $this->db->where("note_id",$note_id);
        $query = $this->db->get();
        return $query->result();
    }



}

?>