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

    //Login to api 
    public function teacher_login_post(){
        $data = json_decode(file_get_contents("php://input"));

        if(isset($data->teacher_email) && isset($data->teacher_password)){

            $email = $data->teacher_email;
            $password = $data->teacher_password;
            $teacher_details = $this->teacher_login_model->is_email_exists($email);

            if(!empty($teacher_details)){
                if(password_verify($password, $teacher_details->teacher_password)){
                    $token = authorization::generateToken((array)$teacher_details);
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

        //validate token method
        public function test_get(){

            $headers = $this->input->request_headers();
    
            $token = $headers['Authorization'];
    
            try{
    
                $isAuth = authorization::validateToken($token);
    
                if($isAuth){
                    $decoded = JWT::decode($token, parent::JWT_KEY, array('HS256'));
                    $this->response(array("status" => 1,"message" => "Access granted", "token decoded" => $decoded->data->teacher_role), parent::HTTP_OK);
                } else {
                    $this->response(array("status" => 0,"message" => "Unauthorize access"), parent::HTTP_UNAUTHORIZED);
                }
            }catch(Exception $ex){
                $this->response(array("status" => 0,"message" => $ex->getMessage()), parent::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
}

?>