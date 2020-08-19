<?php

class Student_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        //load database
        $this->load->database();
        //$this->db
    }

    public function get_all_students(){
        $this->db->select("*");
        $this->db->from("tbl_students");
        $query = $this->db->get();
        return $query->result();
    }

}

?>