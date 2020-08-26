<?php

require APPPATH."libraries/REST_Controller.php";

//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");

class manage_absence extends REST_Controller{

    //Constructor
    public function __construct(){
        parent::__construct();
        $this->load->model("class_register_api/admin/manage_absence_model");
        $this->load->helper(array(
            "authorization",
            "jwt"
        ));
    }

    //Create absence
    public function create_absence_post(){

        if(manage_absence::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->absence_lesson_number) && isset($data->absence_date)  && isset($data->absence_teacher_id)  && isset($data->absence_student_id);
            
            if($vfc){  
                if(!empty($this->manage_absence_model->is_teacher_exists($data->absence_teacher_id))){
                   if(!empty($this->manage_absence_model->is_student_exists($data->absence_student_id))){
                        $absence_data = array(
                            "absence_lesson_number" => $data->absence_lesson_number,
                            "absence_date" => $data->absence_date,
                            "absence_teacher_id" => $data->absence_teacher_id,
                            "absence_student_id" => $data->absence_student_id
                        );
                        if(manage_absence::validateInput($absence_data)){
                            if($this->manage_absence_model->create_absence($absence_data)){
                                $this->response(array("message" => "Absence has been created"), parent::HTTP_OK);
                            } else {
                                $this->response(array("message" => "Failed to create absence"), parent::HTTP_INTERNAL_SERVER_ERROR);
                            }
                        } else {
                            $this->response(array("message" => "Thread detected, terminate request"), parent::HTTP_BAD_REQUEST);
                        }
                   } else {
                        $this->response(array("message" => "Student does not exist"), parent::HTTP_CONFLICT);
                   }
                } else {
                    $this->response(array("message" => "Teacher does not exist"), parent::HTTP_CONFLICT);
                }
            } else {
                $this->response(array("message" => "All fields are needed"), parent::HTTP_NOT_FOUND);
            }
        }
    }

    //Read absence
    public function read_absence_get(){
        if(manage_absence::tokenAccessValidation("Administrator")){
            $absence_data = $this->manage_absence_model->get_all_absence();
            if(count($absence_data) > 0){
                $this->response(array("message" => "Absence list", "data" => $absence_data), parent::HTTP_OK);
            } 
            else {
                $this->response(array("message" => "No data found"), parent::HTTP_NOT_FOUND);
            }
        }       
    }

    //Read single absence
    public function read_single_absence_get(){

        if(manage_absence::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));

            if(isset($data->absence_id)){
                $absence_data = $this->manage_absence_model->get_absence($data->absence_id);
    
                if(count($absence_data) > 0){
                    $this->response(array("message" => "Absence data", "data" => $absence_data), parent::HTTP_OK);
                } 
                else {
                    $this->response(array("message" => "No data found"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "All field are needed"), parent::HTTP_NOT_FOUND);
            }
        }
    }

    //Update absence
    public function update_absence_put(){

        if(manage_absence::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->absence_id) && isset($data->absence_lesson_number) && isset($data->absence_date)  && isset($data->absence_teacher_id)  && isset($data->absence_student_id);
            
            if($vfc){  
                if(!empty($this->manage_absence_model->is_teacher_exists($data->absence_teacher_id))){
                   if(!empty($this->manage_absence_model->is_student_exists($data->absence_student_id))){
                        $absence_data = array(
                            "absence_lesson_number" => $data->absence_lesson_number,
                            "absence_date" => $data->absence_date,
                            "absence_teacher_id" => $data->absence_teacher_id,
                            "absence_student_id" => $data->absence_student_id
                        );
                        if(manage_absence::validateInput($absence_data)){
                            if($this->manage_absence_model->update_absence($data->absence_id, $absence_data)){
                                $this->response(array("message" => "Absence has been updated"), parent::HTTP_OK);
                            } else {
                                $this->response(array("message" => "Failed to update absence"), parent::HTTP_INTERNAL_SERVER_ERROR);
                            }
                        } else {
                            $this->response(array("message" => "Thread detected, terminate request"), parent::HTTP_BAD_REQUEST);
                        }
                   } else {
                        $this->response(array("message" => "Student does not exist"), parent::HTTP_CONFLICT);
                   }
                } else {
                    $this->response(array("message" => "Teacher does not exist"), parent::HTTP_CONFLICT);
                }
            } else {
                $this->response(array("message" => "All fields are needed"), parent::HTTP_NOT_FOUND);
            }
        }
    }   

    //Delete absence
    public function delete_absence_delete(){

        if(manage_absence::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->absence_id);
    
            if($vfc){
                if(!empty($this->manage_absence_model->find_by_id($data->absence_id))){
                    if($this->manage_absence_model->delete_absence($data->absence_id)){
                        $this->response(array("message" => "Absence has been deleted"), parent::HTTP_OK);
                    }else{
                        $this->response(array("message" => "Failed to delete absence"), parent::HTTP_INTERNAL_SERVER_ERROR);
                    }
                } else {
                    $this->response(array("message" => "Absence doesn't exist"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "Absence id is needed"), parent::HTTP_NOT_FOUND);
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