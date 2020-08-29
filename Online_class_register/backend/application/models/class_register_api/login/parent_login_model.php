<?php

class parent_login_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        //load database
        $this->load->database();
        //$this->db
    }

    public function is_email_exists($parent_email){
        $this->db->select("parent_id, parent_email, parent_password, parent_is_active, parent_student_id AS student_id");
        $this->db->from("tbl_parents");
        $this->db->where("parent_email",$parent_email);
        $query = $this->db->get();
        return $query->row();
    }


}

?>