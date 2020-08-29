<?php

require APPPATH."libraries/REST_Controller.php";

//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");

class staf_student extends REST_Controller{

    //Constructor
    public function __construct(){
        parent::__construct();
        $this->load->model("class_register_api/teacher/staf_student_model");
        $this->load->helper(array(
            "authorization",
            "jwt"
        ));
    }

    //Read teacher subject
    public function read_student_get(){
        if(staf_student::tokenAccessValidation("Nauczyciel","Dyrektor")){
            $student_data = $this->staf_student_model->get_all_student();
            if(count($student_data) > 0){
                $this->response(array("message" => "Student list", "data" => $student_data), parent::HTTP_OK);
            } 
            else {
                $this->response(array("message" => "No data found"), parent::HTTP_NOT_FOUND);
            }
        }       
    }
 
    //Read teacher subject
    public function read_by_group_student_get(){
        if(staf_student::tokenAccessValidation("Nauczyciel","Dyrektor")){
            $data = json_decode(file_get_contents("php://input"));
            if(isset($data->group_id)){
                $student_data = $this->staf_student_model->get_by_group_student($data->group_id);
                if(count($student_data) > 0){
                    $this->response(array("message" => "Student list", "data" => $student_data), parent::HTTP_OK);
                } 
                else {
                    $this->response(array("message" => "No data found"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "All field are needed"), parent::HTTP_NOT_FOUND);
            }
        }       
    }

    //Token validation
    public function tokenAccessValidation($role, $role2){

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