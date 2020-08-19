<?php

require APPPATH."libraries/REST_Controller.php";

//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");

class manage_parent extends REST_Controller{

    //Constructor
    public function __construct(){
        parent::__construct();
        $this->load->model("class_register_api/admin/manage_parent_model");
    }

    //Create parent
    public function create_parent_post(){

    }

    //Read parent
    public function read_parent_get(){

        $parent_data = $this->manage_parent_model->get_all_parents();

        if(count($parent_data) > 0){
            $this->response(array("status" => 1, "message" => "Parent list", "data" => $parent_data), parent::HTTP_OK);
        } 
        else {
            $this->response(array("status" => 0, "message" => "No data found"), parent::HTTP_NOT_FOUND);
        }
        
    }

    //Update parent
    public function update_parent_put(){

    }   

    //Delete parent
    public function delete_parent_delete(){

    } 

}

?>