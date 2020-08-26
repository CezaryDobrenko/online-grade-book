<?php

class teacher_login_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        //load database
        $this->load->database();
        //$this->db
    }

    public function is_email_exists($email){
        $this->db->select("teacher_id, teacher_email, teacher_password, teacher_role AS user_role");
        $this->db->from("tbl_teachers");
        $this->db->where("teacher_email",$email);
        $query = $this->db->get();
        return $query->row();
    }


}

?>