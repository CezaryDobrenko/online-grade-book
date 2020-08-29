<?php

class student_login_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        //load database
        $this->load->database();
        //$this->db
    }

    public function is_email_exists($student_email){
        $this->db->select("student_id, student_email, student_is_active, student_password");
        $this->db->from("tbl_students");
        $this->db->where("student_email",$student_email);
        $query = $this->db->get();
        return $query->row();
    }


}

?>