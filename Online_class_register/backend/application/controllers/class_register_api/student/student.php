<?php

require APPPATH."libraries/REST_Controller.php";

//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");

class Student extends REST_Controller{

    //Constructor
    public function __construct(){
        parent::__construct();
        $this->load->model("class_register_api/student/Student_model");
    }

    //List Branches
    public function list_get(){

        $student_list = $this->Student_model->get_all_students();

        if(count($student_list) > 0){
            //branches found
            $this->response(array(
                "status" => 1,
                "message" => "Student list",
                "data" => $student_list
            ));
        } else {
            // empty table
            $this->response(array(
                "status" => 0,
                "message" => "No data found"
            ), parent::HTTP_NOT_FOUND);
        }
    }
}

?>