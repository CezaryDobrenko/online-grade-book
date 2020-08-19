<?php

require APPPATH."libraries/REST_Controller.php";

//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");

class manage_student extends REST_Controller{

    //Constructor
    public function __construct(){
        parent::__construct();
        $this->load->model("class_register_api/admin/manage_student_model");
    }

    //Create student
    public function create_student_post(){

    }

    //Read student
    public function read_student_get(){

        $student_data = $this->manage_student_model->get_all_students();

        if(count($student_data) > 0){
            $this->response(array("status" => 1, "message" => "Student list", "data" => $student_data), parent::HTTP_OK);
        } 
        else {
            $this->response(array("status" => 0, "message" => "No data found"), parent::HTTP_NOT_FOUND);
        }

    }

    //Update student
    public function update_student_put(){

    }   

    //Delete student
    public function delete_student_delete(){

    } 
    
}

?>