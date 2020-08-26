<?php

class manage_lesson_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        //load database
        $this->load->database();
        //$this->db
    }

    //CRUD METHODS

    public function create_lesson($lesson_data){
        return $this->db->insert("tbl_groups_subjects",$lesson_data);
    }

    public function get_all_lesson(){
        $this->db->select("*");
        $this->db->from("tbl_groups_subjects");
        $query = $this->db->get();
        return $query->result();
    }

    public function get_lesson($lesson_id){
        $this->db->select("*");
        $this->db->from("tbl_groups_subjects");
        $this->db->where("group_subject_id",$lesson_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function update_lesson($lesson_id, $lesson_data){
        $this->db->where("group_subject_id", $lesson_id);
        return $this->db->update("tbl_groups_subjects",$lesson_data);
    }

    public function delete_lesson($lesson_id){
        $this->db->where("group_subject_id", $lesson_id);
        return $this->db->delete("tbl_groups_subjects");
    }

    // HELPER METHODS

    public function find_by_id($lesson_id){
        $this->db->select("*");
        $this->db->from("tbl_groups_subjects");
        $this->db->where("group_subject_id", $lesson_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function is_group_exists($group_id){
        $this->db->select("*");
        $this->db->from("tbl_groups");
        $this->db->where("group_id",$group_id);
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

    public function is_relation_exists($group_id, $subject_id){
        $this->db->select("*");
        $this->db->from("tbl_groups_subjects");
        $this->db->where("group_subject_subject_id",$subject_id);
        $this->db->where("group_subject_group_id",$group_id);
        $query = $this->db->get();
        return $query->row();
    }

}

?>