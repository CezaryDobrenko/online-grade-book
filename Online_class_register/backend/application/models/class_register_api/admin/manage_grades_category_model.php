<?php

class manage_grades_category_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        //load database
        $this->load->database();
        //$this->db
    }

    //CRUD METHODS

    public function create_grade_category($grade_data){
        return $this->db->insert("tbl_grades_category",$grade_data);
    }

    public function get_all_grade_category(){
        $this->db->select("*");
        $this->db->from("tbl_grades_category");
        $query = $this->db->get();
        return $query->result();
    }

    public function get_grade_category($grade_id){
        $this->db->select("*");
        $this->db->from("tbl_grades_category");
        $this->db->where("grade_category_id",$grade_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function update_grade_category($grade_id, $grade_data){
        $this->db->where("grade_category_id", $grade_id);
        return $this->db->update("tbl_grades_category",$grade_data);
    }

    public function delete_grade_category($grade_id){
        $this->db->where("grade_category_id", $grade_id);
        return $this->db->delete("tbl_grades_category");
    }

    // HELPER METHODS

    public function is_grade_category_exists($category_name){
        $this->db->select("*");
        $this->db->from("tbl_grades_category");
        $this->db->where("grade_category_name",$category_name);
        $query = $this->db->get();
        return $query->row();
    }

    public function find_by_id($grade_id){
        $this->db->select("*");
        $this->db->from("tbl_grades_category");
        $this->db->where("grade_category_id", $grade_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function is_grade_category_unique($category_name, $id){
        $this->db->select("*");
        $this->db->from("tbl_grades_category");
        $this->db->where("grade_category_name",$category_name);
        $this->db->where("grade_category_id !=",$id);
        $query = $this->db->get();
        return $query->row();
    }

}

?>