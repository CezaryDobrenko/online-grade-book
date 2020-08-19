<?php

class manage_teacher_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        //load database
        $this->load->database();
        //$this->db
    }

    //CRUD METHODS

    public function create_teacher($teacher_data){
        return $this->db->insert("tbl_teachers",$teacher_data);
    }

    public function get_all_teachers(){
        $this->db->select("*");
        $this->db->from("tbl_teachers");
        $query = $this->db->get();
        return $query->result();
    }

    public function get_teacher($teacher_id){
        $this->db->select("*");
        $this->db->from("tbl_teachers");
        $this->db->where("teacher_id",$teacher_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function update_teacher($teacher_id, $teacher_data){
        $this->db->where("teacher_id", $teacher_id);
        return $this->db->update("tbl_teachers",$teacher_data);
    }

    public function delete_teacher($teacher_id){
        $this->db->where("teacher_id", $teacher_id);
        return $this->db->delete("tbl_teachers");
    }

    // HELPER METHODS

    public function is_email_exists($email){
        $this->db->select("*");
        $this->db->from("tbl_teachers");
        $this->db->where("teacher_email",$email);
        $query = $this->db->get();
        return $query->row();
    }

    public function find_by_id($teacher_id){
        $this->db->select("*");
        $this->db->from("tbl_teachers");
        $this->db->where("teacher_id", $teacher_id);
        $query = $this->db->get();
        return $query->row();
    }

}

?>