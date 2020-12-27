<?php

require APPPATH."libraries/REST_Controller.php";

//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");

class open_subject extends REST_Controller{

    //Constructor
    public function __construct(){
        parent::__construct();
        $this->load->model("class_register_api/open/open_subject_model");
    }

    //Read subject
    public function read_subjects_get(){
            $subject_data = $this->open_subject_model->get_all_subjects();
            if(count($subject_data) > 0){
                $this->response(array("message" => "Subject list", "data" => $subject_data), parent::HTTP_OK);
            } 
            else {
                $this->response(array("message" => "No data found"), parent::HTTP_NOT_FOUND);
            }      
    }

}

?>