<?php

require APPPATH."libraries/REST_Controller.php";

//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");

class personal_group extends REST_Controller{

    //Constructor
    public function __construct(){
        parent::__construct();
        $this->load->model("class_register_api/user/personal_group_model");
        $this->load->helper(array(
            "authorization",
            "jwt"
        ));
    }

    //Read subject
    public function read_group_get(){
        if(personal_group::tokenAccessValidation("Student","Parent")){
            $headers = $this->input->request_headers();
            $token = $headers['Authorization'];
            $decoded_token = authorization::validateToken($token);
            $group_id = $this->personal_group_model->find_student_group($decoded_token->data->student_id)->student_group_id;
            $group_data = $this->personal_group_model->get_group($group_id);
            if(count($group_data) > 0){
                $this->response(array("message" => "Group list", "data" => $group_data), parent::HTTP_OK);
            } 
            else {
                $this->response(array("message" => "No data found"), parent::HTTP_NOT_FOUND);
            }
        }       
    }

    //Token validation
    public function tokenAccessValidation($role,$role2){

        $headers = $this->input->request_headers();
        $token = $headers['Authorization'];
        $current_time = time();

        try{
            $isAuth = authorization::validateToken($token);
            if($isAuth){
                if($isAuth->exp > $current_time){
                    if(($isAuth->data->user_role == $role) || ($isAuth->data->user_role == $role2)){
                        return true;
                    } else {
                        $this->response(array("message" => "Permmision denied"), parent::HTTP_FORBIDDEN);
                    }
                } else {
                    $this->response(array("message" => "Token expired"), parent::HTTP_UNAUTHORIZED);
                }
            } else {
                $this->response(array("message" => "Unauthorize access"), parent::HTTP_UNAUTHORIZED);
            }
        }catch(Exception $ex){
            $this->response(array("message" => $ex->getMessage()), parent::HTTP_INTERNAL_SERVER_ERROR);
        }
        return false;
    }


}

?>