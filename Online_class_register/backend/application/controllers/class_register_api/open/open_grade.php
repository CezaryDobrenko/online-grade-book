<?php

require APPPATH."libraries/REST_Controller.php";

//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");

class open_grade extends REST_Controller{

    //Constructor
    public function __construct(){
        parent::__construct();
        $this->load->model("class_register_api/open/open_grade_model");
    }

    //Read grade
    public function read_grades_get(){
            $grade_data = $this->open_grade_model->get_all_grades();
            if(count($grade_data) > 0){
                $this->response(array("message" => "Grade list", "data" => $grade_data), parent::HTTP_OK);
            } 
            else {
                $this->response(array("message" => "No data found"), parent::HTTP_NOT_FOUND);
            }      
    }

}

?>