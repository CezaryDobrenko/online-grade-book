<?php

require APPPATH."libraries/REST_Controller.php";

//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");

class open_category extends REST_Controller{

    //Constructor
    public function __construct(){
        parent::__construct();
        $this->load->model("class_register_api/open/open_category_model");
    }

    //Read category
    public function read_categories_get(){
            $category_data = $this->open_category_model->get_all_categories();
            if(count($category_data) > 0){
                $this->response(array("message" => "Category list", "data" => $category_data), parent::HTTP_OK);
            } 
            else {
                $this->response(array("message" => "No data found"), parent::HTTP_NOT_FOUND);
            }      
    }

}

?>