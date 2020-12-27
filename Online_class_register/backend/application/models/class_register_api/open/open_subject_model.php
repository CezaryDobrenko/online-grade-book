<?php

class open_subject_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        //load database
        $this->load->database();
        //$this->db
    }

    public function get_all_subjects(){
        $this->db->select("subject_name");
        $this->db->from("tbl_subjects");
        $query = $this->db->get();
        return $query->result();
    }

}

?>