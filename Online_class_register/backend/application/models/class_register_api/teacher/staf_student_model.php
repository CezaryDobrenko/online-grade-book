<?php

class staf_student_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        //load database
        $this->load->database();
        //$this->db
    }

    public function get_all_student(){
        $this->db->select('ts.student_id, ts.student_name, ts.student_surname, ts.student_email, gs.group_name, gs.group_short_name');
        $this->db->from("tbl_students AS ts");
        $this->db->join('tbl_groups AS gs','ts.student_group_id = gs.group_id', 'left');
        $query = $this->db->get();
        return $query->result();
    }

}

?>