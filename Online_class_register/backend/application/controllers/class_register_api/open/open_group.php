<?php

require APPPATH."libraries/REST_Controller.php";

//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");

class open_group extends REST_Controller{

    //Constructor
    public function __construct(){
        parent::__construct();
        $this->load->model("class_register_api/open/open_group_model");
    }

    //Read group
    public function read_groups_get(){
            $group_data = $this->open_group_model->get_all_groups();
            if(count($group_data) > 0){
                $this->response(array("message" => "Group list", "data" => $group_data), parent::HTTP_OK);
            } 
            else {
                $this->response(array("message" => "No data found"), parent::HTTP_NOT_FOUND);
            }      
    }

}

?>