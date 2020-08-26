<?php

class manage_note_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        //load database
        $this->load->database();
        //$this->db
    }

    //CRUD METHODS

    public function create_note($note_data){
        return $this->db->insert("tbl_notes",$note_data);
    }

    public function get_all_note(){
        $this->db->select("*");
        $this->db->from("tbl_notes");
        $query = $this->db->get();
        return $query->result();
    }

    public function get_note($note_id){
        $this->db->select("*");
        $this->db->from("tbl_notes");
        $this->db->where("note_id",$note_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function update_note($note_id, $note_data){
        $this->db->where("note_id", $note_id);
        return $this->db->update("tbl_notes",$note_data);
    }

    public function delete_note($note_id){
        $this->db->where("note_id", $note_id);
        return $this->db->delete("tbl_notes");
    }

    // HELPER METHODS

    public function find_by_id($note_id){
        $this->db->select("*");
        $this->db->from("tbl_notes");
        $this->db->where("note_id", $note_id);
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

    public function is_teacher_exists($teacher_id){
        $this->db->select("*");
        $this->db->from("tbl_teachers");
        $this->db->where("teacher_id",$teacher_id);
        $query = $this->db->get();
        return $query->row();
    }


}

?>