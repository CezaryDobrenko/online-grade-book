<?php

class manage_parent_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        //load database
        $this->load->database();
        //$this->db
    }

    //CRUD METHODS

    public function create_parent($parent_data){
        return $this->db->insert("tbl_parents",$parent_data);
    }

    public function get_all_parents(){
        $this->db->select("a.parent_id, a.parent_email, a.parent_password, a.parent_is_active, b.student_email");
        $this->db->from("tbl_parents as a");
		$this->db->join('tbl_students as b', 'parent_student_id = student_id', 'left');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_parent($parent_id){
        $this->db->select("*");
        $this->db->from("tbl_parents");
        $this->db->where("parent_id",$parent_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function update_parent($parent_id, $parent_data){
        $this->db->where("parent_id", $parent_id);
        return $this->db->update("tbl_parents",$parent_data);
    }

    public function delete_parent($parent_id){
        $this->db->where("parent_id", $parent_id);
        return $this->db->delete("tbl_parents");
    }

    // HELPER METHODS

    public function is_email_exists($email){
        $this->db->select("*");
        $this->db->from("tbl_parents");
        $this->db->where("parent_email",$email);
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

    public function find_by_id($parent_id){
        $this->db->select("*");
        $this->db->from("tbl_parents");
        $this->db->where("parent_id", $parent_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function is_email_unique($email, $parent_id){
        $this->db->select("*");
        $this->db->from("tbl_parents");
        $this->db->where("parent_email",$email);
        $this->db->where("parent_id !=",$parent_id);
        $query = $this->db->get();
        return $query->row();
    }

}

?>