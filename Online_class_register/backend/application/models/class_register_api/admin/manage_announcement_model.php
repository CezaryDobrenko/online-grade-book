<?php

class manage_announcement_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        //load database
        $this->load->database();
        //$this->db
    }

    //CRUD METHODS

    public function create_announcement($announcement_data){
        return $this->db->insert("tbl_announcements",$announcement_data);
    }

    public function get_all_announcements(){
        $this->db->select('a.announcement_id, a.announcement_message, a.announcement_date, CONCAT( b.teacher_name, " ", b.teacher_surname ) AS announcement_creator_id');
        $this->db->from("tbl_announcements as a");
		$this->db->join('tbl_teachers as b', 'announcement_creator_id = teacher_id', 'left');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_announcement($announcement_id){
        $this->db->select("*");
        $this->db->from("tbl_announcements");
        $this->db->where("announcement_id",$announcement_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function update_announcement($announcement_id, $announcement_data){
        $this->db->where("announcement_id", $announcement_id);
        return $this->db->update("tbl_announcements",$announcement_data);
    }

    public function delete_announcement($announcement_id){
        $this->db->where("announcement_id", $announcement_id);
        return $this->db->delete("tbl_announcements");
    }

    // HELPER METHODS

    public function find_by_id($announcement_id){
        $this->db->select("*");
        $this->db->from("tbl_announcements");
        $this->db->where("announcement_id", $announcement_id);
        $query = $this->db->get();
        return $query->row();
    }
	
}

?>