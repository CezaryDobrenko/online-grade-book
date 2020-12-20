<?php

class staf_subject_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        //load database
        $this->load->database();
        //$this->db
    }

    public function get_subject($teacher_id){
        $this->db->select('ts.subject_id, ts.subject_name');
        $this->db->from("tbl_subject_has_teacher AS tsht");
        $this->db->join('tbl_subjects AS ts','ts.subject_id = tsht.subject_has_teacher_subject_id', 'left');
        $this->db->where("subject_has_teacher_teacher_id",$teacher_id);
        $query = $this->db->get();
        return $query->result();
    }

}

?>