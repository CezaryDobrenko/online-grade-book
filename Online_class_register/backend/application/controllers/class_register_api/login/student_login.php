<?php

require APPPATH."libraries/REST_Controller.php";

//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");

class student_login extends REST_Controller{

    //Constructor
    public function __construct(){
        parent::__construct();
        $this->load->model("class_register_api/login/student_login_model");
        $this->load->helper(array(
            "authorization",
            "jwt"
        ));
    }

    //Login to api 
    public function student_login_post(){
        $data = json_decode(file_get_contents("php://input"));

        if(isset($data->student_email) && isset($data->student_password)){

            $email = $data->student_email;
            $password = $data->student_password;
            $student_details = $this->student_login_model->is_email_exists($email);

            if(!empty($student_details)){
                if(password_verify($password, $student_details->student_password)){
                    $student_details->user_role = "Student";
                    $token = authorization::generateToken((array)$student_details);
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