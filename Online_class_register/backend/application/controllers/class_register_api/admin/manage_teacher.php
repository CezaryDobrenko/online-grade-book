<?php

require APPPATH."libraries/REST_Controller.php";

//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");

class manage_teacher extends REST_Controller{

    //Constructor
    public function __construct(){
        parent::__construct();
        $this->load->model("class_register_api/admin/manage_teacher_model");
        $this->load->helper(array(
            "authorization",
            "jwt"
        ));
    }

    //Create teacher
    public function create_teacher_post(){

        if(manage_teacher::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->teacher_email) && isset($data->teacher_password)  && isset($data->teacher_name)  && isset($data->teacher_surname)  && isset($data->teacher_role) && isset($data->teacher_group) && isset($data->teacher_is_active);
            
            if($vfc){  
                if(empty($this->manage_teacher_model->is_email_exists($data->teacher_email))){
                    if(!empty($this->manage_teacher_model->is_group_exists($data->teacher_group))){
                        $teacher_data = array(
                            "teacher_email" => $data->teacher_email,
                            "teacher_password" => password_hash($data->teacher_password,PASSWORD_DEFAULT),
                            "teacher_name" => $data->teacher_name,
                            "teacher_surname" => $data->teacher_surname,
                            "teacher_role" => $data->teacher_role,
                            "teacher_is_active" => $data->teacher_is_active,
                            "teacher_group" => $data->teacher_group
                        );
                        if(manage_teacher::validateInput($teacher_data)){
                            if($this->manage_teacher_model->create_teacher($teacher_data)){
                                $this->response(array("message" => "Teacher has been created"), parent::HTTP_OK);
                            } else {
                                $this->response(array("message" => "Failed to create teacher"), parent::HTTP_INTERNAL_SERVER_ERROR);
                            }
                        } else {
                            $this->response(array("message" => "Thread detected, terminate request"), parent::HTTP_BAD_REQUEST);
                        }
                    } else {
                        $this->response(array("message" => "Group does not exist"), parent::HTTP_NOT_FOUND);
                    }
                } else {
                    $this->response(array("message" => "Email address has been taken"), parent::HTTP_CONFLICT);
                }
            } else {
                $this->response(array("message" => "All fields are needed"), parent::HTTP_NOT_FOUND);
            }
        }
    }

    //Read teacher
    public function read_teacher_get(){
        if(manage_teacher::tokenAccessValidation("Administrator")){
            $teacher_data = $this->manage_teacher_model->get_all_teachers();
            if(count($teacher_data) > 0){
                $this->response(array("message" => "Teacher list", "data" => $teacher_data), parent::HTTP_OK);
            } 
            else {
                $this->response(array("message" => "No data found"), parent::HTTP_NOT_FOUND);
            }
        }       
    }

    //Read single teacher
    public function read_single_teacher_get(){

        if(manage_teacher::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));

            if(isset($data->teacher_id)){
                $teacher_data = $this->manage_teacher_model->get_teacher($data->teacher_id);
    
                if(count($teacher_data) > 0){
                    $this->response(array("message" => "Teacher data", "data" => $teacher_data), parent::HTTP_OK);
                } 
                else {
                    $this->response(array("message" => "No data found"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "All field are needed"), parent::HTTP_NOT_FOUND);
            }
        }
    }

    //Update teacher
    public function update_teacher_put(){

        if(manage_teacher::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->teacher_id) && isset($data->teacher_email) && isset($data->teacher_password)  && isset($data->teacher_name)  && isset($data->teacher_surname)  && isset($data->teacher_role) && isset( $data->teacher_is_active);
    
            if($vfc){
                if(empty($this->manage_teacher_model->is_email_unique($data->teacher_email, $data->teacher_id))){
                    if(!empty($this->manage_teacher_model->is_group_exists($data->teacher_group))){
                        $teacher_data = array(
                            "teacher_email" => $data->teacher_email,
                            "teacher_password" => password_hash($data->teacher_password,PASSWORD_DEFAULT),
                            "teacher_name" => $data->teacher_name,
                            "teacher_surname" => $data->teacher_surname,
                            "teacher_role" => $data->teacher_role,
                            "teacher_is_active" => $data->teacher_is_active,
                            "teacher_group" => $data->teacher_group
                        );
                        if(manage_teacher::validateInput($teacher_data)){
                            if($this->manage_teacher_model->update_teacher($data->teacher_id, $teacher_data)){
                                $this->response(array("message" => "Teacher has been updated"), parent::HTTP_OK);
                            } else {
                                $this->response(array("message" => "Failed to update teacher"), parent::HTTP_INTERNAL_SERVER_ERROR);
                            }
                        } else {
                            $this->response(array("message" => "Thread detected, terminate request"), parent::HTTP_BAD_REQUEST);
                        }
                    } else {
                        $this->response(array("message" => "Group does not exist"), parent::HTTP_NOT_FOUND);
                    }
                } else {
                    $this->response(array("message" => "Email address has been taken"), parent::HTTP_CONFLICT);
                }
            } else {
                $this->response(array("message" => "All fields are needed"), parent::HTTP_NOT_FOUND);
            }
        }
    }   

    //Delete teacher
    public function delete_teacher_delete(){

        if(manage_teacher::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->teacher_id);
    
            if($vfc){
                if(!empty($this->manage_teacher_model->find_by_id($data->teacher_id))){
                    if($this->manage_teacher_model->delete_teacher($data->teacher_id)){
                        $this->response(array("message" => "Teacher has been deleted"), parent::HTTP_OK);
                    }else{
                        $this->response(array("message" => "Failed to delete teacher"), parent::HTTP_INTERNAL_SERVER_ERROR);
                    }
                } else {
                    $this->response(array("message" => "Teacher doesn't exist"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "Teacher id is needed"), parent::HTTP_NOT_FOUND);
            }
        }
    } 

    //Token validation
    public function tokenAccessValidation($role){

        $headers = $this->input->request_headers();
        $token = $headers['Authorization'];
        $current_time = time();

        try{
            $isAuth = authorization::validateToken($token);
            if($isAuth){
                if($isAuth->exp > $current_time){
                    if($isAuth->data->user_role == $role){
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

    //Input validation
    public function validateInput($input_data){

        foreach ($input_data as &$value) {
            if ($this->security->xss_clean($value, TRUE) === FALSE)
                return false;
            if($value != html_escape($value))
                return false;
        }
        return true;
    }

}

?>