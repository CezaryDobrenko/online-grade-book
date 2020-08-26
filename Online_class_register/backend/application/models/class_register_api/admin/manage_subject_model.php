<?php

class manage_subject_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        //load database
        $this->load->database();
        //$this->db
    }

    //CRUD METHODS

    public function create_subject($subject_data){
        return $this->db->insert("tbl_subjects",$subject_data);
    }

    public function get_all_subjects(){
        $this->db->select("*");
        $this->db->from("tbl_subjects");
        $query = $this->db->get();
        return $query->result();
    }

    public function get_subject($subject_id){
        $this->db->select("*");
        $this->db->from("tbl_subjects");
        $this->db->where("subject_id",$subject_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function update_subject($subject_id, $subject_data){
        $this->db->where("subject_id", $subject_id);
        return $this->db->update("tbl_subjects",$subject_data);
    }

    public function delete_subject($subject_id){
        $this->db->where("subject_id", $subject_id);
        return $this->db->delete("tbl_subjects");
    }

    // HELPER METHODS

    public function is_subject_exists($subject){
        $this->db->select("*");
        $this->db->from("tbl_subjects");
        $this->db->where("subject_name",$subject);
        $query = $this->db->get();
        return $query->row();
    }

    public function find_by_id($subject_id){
        $this->db->select("*");
        $this->db->from("tbl_subjects");
        $this->db->where("subject_id", $subject_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function is_subject_unique($subject_name, $subject_id){
        $this->db->select("*");
        $this->db->from("tbl_subjects");
        $this->db->where("subject_name",$subject_name);
        $this->db->where("subject_id !=",$subject_id);
        $query = $this->db->get();
        return $query->row();
    }

}

?>