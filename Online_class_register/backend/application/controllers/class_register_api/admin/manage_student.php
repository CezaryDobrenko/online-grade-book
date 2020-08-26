<?php

require APPPATH."libraries/REST_Controller.php";

//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");

class manage_student extends REST_Controller{

    //Constructor
    public function __construct(){
        parent::__construct();
        $this->load->model("class_register_api/admin/manage_student_model");
        $this->load->helper(array(
            "authorization",
            "jwt"
        ));
    }

    //Create student
    public function create_student_post(){

        if(manage_student::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->student_email) && isset($data->student_password)  && isset($data->student_name)  && isset($data->student_surname)  && isset($data->student_group_id) && isset($data->student_is_active);
            
            if($vfc){  
                if(empty($this->manage_student_model->is_email_exists($data->student_email))){
                    if(!empty($this->manage_student_model->is_group_exists($data->student_group_id))){
                        $student_data = array(
                            "student_email" => $data->student_email,
                            "student_password" => password_hash($data->student_password,PASSWORD_DEFAULT),
                            "student_name" => $data->student_name,
                            "student_surname" => $data->student_surname,
                            "student_is_active" => $data->student_is_active,
                            "student_group_id" => $data->student_group_id
                        );
                        if(manage_student::validateInput($student_data)){
                            if($this->manage_student_model->create_student($student_data)){
                                $this->response(array("message" => "Student has been created"), parent::HTTP_OK);
                            } else {
                                $this->response(array("message" => "Failed to create student"), parent::HTTP_INTERNAL_SERVER_ERROR);
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

    //Read student
    public function read_student_get(){
        if(manage_student::tokenAccessValidation("Administrator")){
            $student_data = $this->manage_student_model->get_all_students();
            if(count($student_data) > 0){
                $this->response(array("message" => "Student list", "data" => $student_data), parent::HTTP_OK);
            } 
            else {
                $this->response(array("message" => "No data found"), parent::HTTP_NOT_FOUND);
            }
        }       
    }

    //Read single student
    public function read_single_student_get(){

        if(manage_student::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));

            if(isset($data->student_id)){
                $student_data = $this->manage_student_model->get_student($data->student_id);
    
                if(count($student_data) > 0){
                    $this->response(array("message" => "Student data", "data" => $student_data), parent::HTTP_OK);
                } 
                else {
                    $this->response(array("message" => "No data found"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "All field are needed"), parent::HTTP_NOT_FOUND);
            }
        }
    }

    //Update student
    public function update_student_put(){

        if(manage_student::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->student_id) && isset($data->student_email) && isset($data->student_password)  && isset($data->student_name)  && isset($data->student_surname)  && isset($data->student_group_id) && isset($data->student_is_active);
            
            if($vfc){
                if(empty($this->manage_student_model->is_email_unique($data->student_email, $data->student_id))){
                    if(!empty($this->manage_student_model->is_group_exists($data->student_group_id))){
                        $student_data = array(
                            "student_email" => $data->student_email,
                            "student_password" => password_hash($data->student_password,PASSWORD_DEFAULT),
                            "student_name" => $data->student_name,
                            "student_surname" => $data->student_surname,
                            "student_is_active" => $data->student_is_active,
                            "student_group_id" => $data->student_group_id
                        );
                        if(manage_student::validateInput($student_data)){
                            if($this->manage_student_model->update_student($data->student_id, $student_data)){
                                $this->response(array("message" => "Student has been updated"), parent::HTTP_OK);
                            } else {
                                $this->response(array("message" => "Failed to update student"), parent::HTTP_INTERNAL_SERVER_ERROR);
                            }
                        } else {
                            $this->response(array("message" => "Thread detected, terminate request"), parent::HTTP_BAD_REQUEST);
                        }
                    } else {
                        $this->response(array("message" => "Group does not exist"), parent::HTTP_NOT_FOUND);
                    }
                } else {
                    $this->response(array("message" => "Email adress has been taken"), parent::HTTP_CONFLICT);
                }
            } else {
                $this->response(array("message" => "All fields are needed"), parent::HTTP_NOT_FOUND);
            }
        }
    }   

    //Delete student
    public function delete_student_delete(){

        if(manage_student::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->student_id);
    
            if($vfc){
                if(!empty($this->manage_student_model->find_by_id($data->student_id))){
                    if($this->manage_student_model->delete_student($data->student_id)){
                        $this->response(array("message" => "Student has been deleted"), parent::HTTP_OK);
                    }else{
                        $this->response(array("message" => "Failed to delete teacher"), parent::HTTP_INTERNAL_SERVER_ERROR);
                    }
                } else {
                    $this->response(array("message" => "Student doesn't exist"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "Student id is needed"), parent::HTTP_NOT_FOUND);
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