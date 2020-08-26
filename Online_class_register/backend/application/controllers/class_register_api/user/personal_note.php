<?php

require APPPATH."libraries/REST_Controller.php";

//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");

class personal_note extends REST_Controller{

    //Constructor
    public function __construct(){
        parent::__construct();
        $this->load->model("class_register_api/user/personal_note_model");
        $this->load->helper(array(
            "authorization",
            "jwt"
        ));
    }

    //Read note
    public function read_note_get(){
        if(personal_note::tokenAccessValidation("Student","Parent")){
            $headers = $this->input->request_headers();
            $token = $headers['Authorization'];
            $decoded_token = authorization::validateToken($token);
            $note_data = $this->personal_note_model->get_all_note($decoded_token->data->student_id);
            if(count($note_data) > 0){
                $this->response(array("message" => "Personal note list", "data" => $note_data), parent::HTTP_OK);
            } 
            else {
                $this->response(array("message" => "No data found"), parent::HTTP_NOT_FOUND);
            }
        }       
    }

    //Read single note
    public function read_single_note_get(){
        if(personal_note::tokenAccessValidation("Student","Parent")){
            $data = json_decode(file_get_contents("php://input"));
            if(isset($data->note_id)){
                $headers = $this->input->request_headers();
                $token = $headers['Authorization'];
                $decoded_token = authorization::validateToken($token);
                $note_data = $this->personal_note_model->get_note($data->note_id,$decoded_token->data->student_id);
                if(count($note_data) > 0){
                    $this->response(array("message" => "Personal note data", "data" => $note_data), parent::HTTP_OK);
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