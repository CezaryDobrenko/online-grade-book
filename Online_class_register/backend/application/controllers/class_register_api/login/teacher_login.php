<?php

require APPPATH."libraries/REST_Controller.php";

//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");

class teacher_login extends REST_Controller{

    //Constructor
    public function __construct(){
        parent::__construct();
        $this->load->model("class_register_api/login/teacher_login_model");
        $this->load->helper(array(
            "authorization",
            "jwt"
        ));
    }

	//Browser info
    public function teacher_login_get(){
		echo "Endpoint for teacher providing login feature";
	}

    //Login to api 
    public function teacher_login_post(){
        $data = json_decode(file_get_contents("php://input"));

        if(isset($data->teacher_email) && isset($data->teacher_password)){

            $email = $data->teacher_email;
            $password = $data->teacher_password;
            $teacher_details = $this->teacher_login_model->is_email_exists($email);

            if(!empty($teacher_details)){
                if(password_verify($password, $teacher_details->teacher_password)){
                    if($teacher_details->teacher_is_active == 1){
                        $token = authorization::generateToken((array)$teacher_details);
                        $this->response(array("status" => 1,"message" => "Login successfully","token" => $token), parent::HTTP_OK);
                    } else {
                        $this->response(array("status" => 0,"message" => "Account has been deactivated"), parent::HTTP_CONFLICT);
                    }
                } else {
                    $this->response(array("status" => 0,"message" => "Wrong Credentials"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("status" => 0,"message" => "Wrong Credentials"), parent::HTTP_NOT_FOUND);
            }
        } else {
            $this->response(array("status" => 0,"message" => "Login details needed"), parent::HTTP_NOT_FOUND);
        }
    }
}

?>