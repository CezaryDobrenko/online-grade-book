<?php

class personal_announcement_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        //load database
        $this->load->database();
        //$this->db
    }

    public function get_all_announcements(){
        $this->db->select('a.announcement_id, a.announcement_message, a.announcement_date, CONCAT( b.teacher_name, " ", b.teacher_surname ) AS announcement_creator_id');
        $this->db->from("tbl_announcements as a");
		$this->db->join('tbl_teachers as b', 'announcement_creator_id = teacher_id', 'left');
        $query = $this->db->get();
        return $query->result();
    }

}

?>