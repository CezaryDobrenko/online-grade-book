<?php

class manage_student_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        //load database
        $this->load->database();
    }

    //CRUD METHODS

    public function create_student($student_data){
        return $this->db->insert("tbl_students",$student_data);
    }

    public function get_all_students(){
        $this->db->select("a.student_id, a.student_email, a.student_password, a.student_name, a.student_surname, a.student_is_active, b.group_short_name");
        $this->db->from("tbl_students as a");
		$this->db->join('tbl_groups as b', 'student_group_id = group_id', 'left');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_student($student_id){
        $this->db->select("*");
        $this->db->from("tbl_students");
        $this->db->where("student_id",$student_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function update_student($student_id, $student_data){
        $this->db->where("student_id", $student_id);
        return $this->db->update("tbl_students",$student_data);
    }

    public function delete_student($student_id){
        $this->db->where("student_id", $student_id);
        return $this->db->delete("tbl_students");
    }

    // HELPER METHODS

    public function is_email_exists($email){
        $this->db->select("*");
        $this->db->from("tbl_students");
        $this->db->where("student_email",$email);
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


    public function find_by_id($student_id){
        $this->db->select("*");
        $this->db->from("tbl_students");
        $this->db->where("student_id", $student_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function is_email_unique($email, $student_id){
        $this->db->select("*");
        $this->db->from("tbl_students");
        $this->db->where("student_email",$email);
        $this->db->where("student_id !=", $student_id);
        $query = $this->db->get();
        return $query->row();
    }

}

?>