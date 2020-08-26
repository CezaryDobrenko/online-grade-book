<?php

require APPPATH."libraries/REST_Controller.php";

//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");

class manage_note extends REST_Controller{

    //Constructor
    public function __construct(){
        parent::__construct();
        $this->load->model("class_register_api/admin/manage_note_model");
        $this->load->helper(array(
            "authorization",
            "jwt"
        ));
    }

    //Create note
    public function create_note_post(){

        if(manage_note::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->note_comment) && isset($data->note_teacher_id)  && isset($data->note_student_id);
            
            if($vfc){  
                if(!empty($this->manage_note_model->is_student_exists($data->note_student_id))){
                    if(!empty($this->manage_note_model->is_teacher_exists($data->note_teacher_id))){
                        $note_data = array(
                            "note_comment" => $data->note_comment,
                            "note_teacher_id" => $data->note_teacher_id,
                            "note_student_id" => $data->note_student_id
                        );
                        if(manage_note::validateInput($note_data)){
                            if($this->manage_note_model->create_note($note_data)){
                                $this->response(array("message" => "Note has been created"), parent::HTTP_OK);
                            } else {
                                $this->response(array("message" => "Failed to create note"), parent::HTTP_INTERNAL_SERVER_ERROR);
                            }
                        } else {
                            $this->response(array("message" => "Thread detected, terminate request"), parent::HTTP_BAD_REQUEST);
                        }
                    } else {
                        $this->response(array("message" => "Teacher does not exist"), parent::HTTP_NOT_FOUND);
                    }
                } else {
                    $this->response(array("message" => "Student does not exist"), parent::HTTP_CONFLICT);
                }
            } else {
                $this->response(array("message" => "All fields are needed"), parent::HTTP_NOT_FOUND);
            }
        }
    }

    //Read note
    public function read_note_get(){
        if(manage_note::tokenAccessValidation("Administrator")){
            $note_data = $this->manage_note_model->get_all_note();
            if(count($note_data) > 0){
                $this->response(array("message" => "Note list", "data" => $note_data), parent::HTTP_OK);
            } 
            else {
                $this->response(array("message" => "No data found"), parent::HTTP_NOT_FOUND);
            }
        }       
    }

    //Read single note
    public function read_single_note_get(){

        if(manage_note::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));

            if(isset($data->note_id)){
                $note_data = $this->manage_note_model->get_note($data->note_id);
    
                if(count($note_data) > 0){
                    $this->response(array("message" => "Note data", "data" => $note_data), parent::HTTP_OK);
                } 
                else {
                    $this->response(array("message" => "No data found"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "All field are needed"), parent::HTTP_NOT_FOUND);
            }
        }
    }

    //Update note
    public function update_note_put(){

        if(manage_note::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->note_id) && isset($data->note_comment) && isset($data->note_teacher_id)  && isset($data->note_student_id);
    
            if($vfc){
                if(!empty($this->manage_note_model->is_student_exists($data->note_student_id))){
                    if(!empty($this->manage_note_model->is_teacher_exists($data->note_teacher_id))){
                        $note_data = array(
                            "note_comment" => $data->note_comment,
                            "note_teacher_id" => $data->note_teacher_id,
                            "note_student_id" => $data->note_student_id
                        );
                        if(manage_note::validateInput($note_data)){
                            if($this->manage_note_model->update_note($data->note_id, $note_data)){
                                $this->response(array("message" => "Note has been updated"), parent::HTTP_OK);
                            } else {
                                $this->response(array("message" => "Failed to update note"), parent::HTTP_INTERNAL_SERVER_ERROR);
                            }
                        } else {
                            $this->response(array("message" => "Thread detected, terminate request"), parent::HTTP_BAD_REQUEST);
                        }
                    } else {
                        $this->response(array("message" => "Teacher does not exist"), parent::HTTP_NOT_FOUND);
                    }
                } else {
                    $this->response(array("message" => "Student does not exist"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "All fields are needed"), parent::HTTP_NOT_FOUND);
            }
        }
    }   

    //Delete note
    public function delete_note_delete(){

        if(manage_note::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->note_id);
    
            if($vfc){
                if(!empty($this->manage_note_model->find_by_id($data->note_id))){
                    if($this->manage_note_model->delete_note($data->note_id)){
                        $this->response(array("message" => "Note has been deleted"), parent::HTTP_OK);
                    }else{
                        $this->response(array("message" => "Failed to delete note"), parent::HTTP_INTERNAL_SERVER_ERROR);
                    }
                } else {
                    $this->response(array("message" => "Note doesn't exist"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "Note id is needed"), parent::HTTP_NOT_FOUND);
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