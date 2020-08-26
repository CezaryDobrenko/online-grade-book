<?php

require APPPATH."libraries/REST_Controller.php";

//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");

class parent_login extends REST_Controller{

    //Constructor
    public function __construct(){
        parent::__construct();
        $this->load->model("class_register_api/login/parent_login_model");
        $this->load->helper(array(
            "authorization",
            "jwt"
        ));
    }

    //Login to api 
    public function parent_login_post(){
        $data = json_decode(file_get_contents("php://input"));

        if(isset($data->parent_email) && isset($data->parent_password)){

            $email = $data->parent_email;
            $password = $data->parent_password;
            $parent_details = $this->parent_login_model->is_email_exists($email);

            if(!empty($parent_details)){
                if(password_verify($password, $parent_details->parent_password)){
                    $parent_details->user_role = "Parent";
                    $token = authorization::generateToken((array)$parent_details);
                    $this->response(array("status" => 1,"message" => "Login successfully","token" => $token), parent::HTTP_OK);
                } else {
                    $this->response(array("status" => 0,"message" => "Password didn't match"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("status" => 0,"message" => "Email adress not found"), parent::HTTP_NOT_FOUND);
            }
        } else {
            $this->response(array("status" => 0,"message" => "Login details needed"), parent::HTTP_NOT_FOUND);
        }
    }
}

?>