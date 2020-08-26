<?php

require APPPATH."libraries/REST_Controller.php";

//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");

class manage_teacher_subject extends REST_Controller{

    //Constructor
    public function __construct(){
        parent::__construct();
        $this->load->model("class_register_api/admin/manage_teacher_subject_model");
        $this->load->helper(array(
            "authorization",
            "jwt"
        ));
    }

    //Create teacher_subject
    public function create_teacher_subject_post(){

        if(manage_teacher_subject::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->subject_has_teacher_subject_id) && isset($data->subject_has_teacher_teacher_id );
            
            if($vfc){  
                if(!empty($this->manage_teacher_subject_model->is_teacher_exists($data->subject_has_teacher_teacher_id))){
                   if(!empty($this->manage_teacher_subject_model->is_subject_exists($data->subject_has_teacher_subject_id))){
                        $teacher_subject_data = array(
                            "subject_has_teacher_teacher_id" => $data->subject_has_teacher_teacher_id,
                            "subject_has_teacher_subject_id" => $data->subject_has_teacher_subject_id
                        );
                        if(manage_teacher_subject::validateInput($teacher_subject_data)){
                            if($this->manage_teacher_subject_model->create_teacher_subject($teacher_subject_data)){
                                $this->response(array("message" => "Teacher subject relation has been created"), parent::HTTP_OK);
                            } else {
                                $this->response(array("message" => "Failed to create teacher subject relation"), parent::HTTP_INTERNAL_SERVER_ERROR);
                            }
                        } else {
                            $this->response(array("message" => "Thread detected, terminate request"), parent::HTTP_BAD_REQUEST);
                        }
                   } else {
                        $this->response(array("message" => "Subject does not exist"), parent::HTTP_CONFLICT);
                   }
                } else {
                    $this->response(array("message" => "Teacher does not exist"), parent::HTTP_CONFLICT);
                }
            } else {
                $this->response(array("message" => "All fields are needed"), parent::HTTP_NOT_FOUND);
            }
        }
    }

    //Read teacher_subject
    public function read_teacher_subject_get(){
        if(manage_teacher_subject::tokenAccessValidation("Administrator")){
            $teacher_subject_data = $this->manage_teacher_subject_model->get_all_teacher_subject();
            if(count($teacher_subject_data) > 0){
                $this->response(array("message" => "Teacher subject relation list", "data" => $teacher_subject_data), parent::HTTP_OK);
            } 
            else {
                $this->response(array("message" => "No data found"), parent::HTTP_NOT_FOUND);
            }
        }       
    }

    //Read single teacher_subject
    public function read_single_teacher_subject_get(){

        if(manage_teacher_subject::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));

            if(isset($data->subject_has_teacher_id)){
                $teacher_subject_data = $this->manage_teacher_subject_model->get_teacher_subject($data->subject_has_teacher_id);
    
                if(count($teacher_subject_data) > 0){
                    $this->response(array("message" => "Teacher subject relation data", "data" => $teacher_subject_data), parent::HTTP_OK);
                } 
                else {
                    $this->response(array("message" => "No data found"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "All field are needed"), parent::HTTP_NOT_FOUND);
            }
        }
    }

    //Update teacher_subject
    public function update_teacher_subject_put(){

        if(manage_teacher_subject::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->subject_has_teacher_id) && isset($data->subject_has_teacher_subject_id) && isset($data->subject_has_teacher_teacher_id );
            
            if($vfc){  
                if(!empty($this->manage_teacher_subject_model->is_teacher_exists($data->subject_has_teacher_teacher_id))){
                   if(!empty($this->manage_teacher_subject_model->is_subject_exists($data->subject_has_teacher_subject_id))){
                        $teacher_subject_data = array(
                            "subject_has_teacher_teacher_id" => $data->subject_has_teacher_teacher_id,
                            "subject_has_teacher_subject_id" => $data->subject_has_teacher_subject_id
                        );
                        if(manage_teacher_subject::validateInput($teacher_subject_data)){
                            if($this->manage_teacher_subject_model->update_teacher_subject($data->subject_has_teacher_id, $teacher_subject_data)){
                                $this->response(array("message" => "Teacher subject relation has been updated"), parent::HTTP_OK);
                            } else {
                                $this->response(array("message" => "Failed to update teacher subject relation"), parent::HTTP_INTERNAL_SERVER_ERROR);
                            }
                        } else {
                            $this->response(array("message" => "Thread detected, terminate request"), parent::HTTP_BAD_REQUEST);
                        }
                   } else {
                        $this->response(array("message" => "Subject does not exist"), parent::HTTP_CONFLICT);
                   }
                } else {
                    $this->response(array("message" => "Teacher does not exist"), parent::HTTP_CONFLICT);
                }
            } else {
                $this->response(array("message" => "All fields are needed"), parent::HTTP_NOT_FOUND);
            }
        }
    }   

    //Delete teacher_subject
    public function delete_teacher_subject_delete(){

        if(manage_teacher_subject::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->subject_has_teacher_id);
    
            if($vfc){
                if(!empty($this->manage_teacher_subject_model->find_by_id($data->subject_has_teacher_id))){
                    if($this->manage_teacher_subject_model->delete_teacher_subject($data->subject_has_teacher_id)){
                        $this->response(array("message" => "Teacher subject relation has been deleted"), parent::HTTP_OK);
                    }else{
                        $this->response(array("message" => "Failed to delete teacher subject relation"), parent::HTTP_INTERNAL_SERVER_ERROR);
                    }
                } else {
                    $this->response(array("message" => "Teacher subject relation doesn't exist"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "Teacher subject relation id is needed"), parent::HTTP_NOT_FOUND);
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