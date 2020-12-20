<?php

require APPPATH."libraries/REST_Controller.php";

//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");

class staf_note extends REST_Controller{

    //Constructor
    public function __construct(){
        parent::__construct();
        $this->load->model("class_register_api/teacher/staf_note_model");
        $this->load->helper(array(
            "authorization",
            "jwt"
        ));
    }

    //Create note
    public function create_note_post(){

        if(staf_note::tokenAccessValidation("Teacher","Headmaster")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->note_comment) && isset($data->note_student_id);
            $headers = $this->input->request_headers();
            $token = $headers['Authorization'];
            $decoded_token = authorization::validateToken($token);

            if($vfc){  
                if(!empty($this->staf_note_model->is_student_exists($data->note_student_id))){
                        $note_data = array(
                            "note_comment" => $data->note_comment,
                            "note_teacher_id" => $decoded_token->data->teacher_id,
                            "note_student_id" => $data->note_student_id
                        );
                        if(staf_note::validateInput($note_data)){
                            if($this->staf_note_model->create_note($note_data)){
                                $this->response(array("message" => "Note has been created", "status" => "1"), parent::HTTP_OK);
                            } else {
                                $this->response(array("message" => "Failed to create note", "status" => "0"), parent::HTTP_INTERNAL_SERVER_ERROR);
                            }
                        } else {
                            $this->response(array("message" => "Thread detected, terminate request", "status" => "0"), parent::HTTP_BAD_REQUEST);
                        }
                } else {
                        $this->response(array("message" => "Student does not exist", "status" => "0"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "All fields are needed", "status" => "0"), parent::HTTP_NOT_FOUND);
            }
        }
    }

    //Read note
    public function read_note_get(){
        if(staf_note::tokenAccessValidation("Teacher","Headmaster")){
            $headers = $this->input->request_headers();
            $token = $headers['Authorization'];
            $decoded_token = authorization::validateToken($token);
            $note_data = $this->staf_note_model->get_all_note($decoded_token->data->teacher_id);
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

        if(staf_note::tokenAccessValidation("Teacher","Headmaster")){

            if(isset($_GET['id'])){
                $note_data = $this->staf_note_model->get_note($_GET['id']);
    
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

        if(staf_note::tokenAccessValidation("Teacher","Headmaster")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->note_id) && isset($data->note_comment) && isset($data->note_student_id);
            $headers = $this->input->request_headers();
            $token = $headers['Authorization'];
            $decoded_token = authorization::validateToken($token);

            if($vfc){  
                if(!empty($this->staf_note_model->is_student_exists($data->note_student_id))){
                    if(!empty($this->staf_note_model->is_teacher_creator($data->note_id, $decoded_token->data->teacher_id))){
                        $note_data = array(
                            "note_comment" => $data->note_comment,
                            "note_teacher_id" => $decoded_token->data->teacher_id,
                            "note_student_id" => $data->note_student_id
                        );
                        if(staf_note::validateInput($note_data)){
                            if($this->staf_note_model->update_note($data->note_id, $note_data)){
                                $this->response(array("message" => "Note has been updated", "status" => "1"), parent::HTTP_OK);
                            } else {
                                $this->response(array("message" => "Failed to update note", "status" => "0"), parent::HTTP_INTERNAL_SERVER_ERROR);
                            }
                        } else {
                            $this->response(array("message" => "Thread detected, terminate request", "status" => "0"), parent::HTTP_BAD_REQUEST);
                        }
                    } else {
                        $this->response(array("message" => "You are not the creator of this note record", "status" => "0"), parent::HTTP_CONFLICT);
                    }
                } else {
                    $this->response(array("message" => "Student does not exist", "status" => "0"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "All fields are needed", "status" => "0"), parent::HTTP_NOT_FOUND);
            }
        }
    }   

    //Delete note
    public function delete_note_delete(){

        if(staf_note::tokenAccessValidation("Teacher","Headmaster")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->note_id);
            $headers = $this->input->request_headers();
            $token = $headers['Authorization'];
            $decoded_token = authorization::validateToken($token);
            
            if($vfc){
                if(!empty($this->staf_note_model->find_by_id($data->note_id))){
                    if(!empty($this->staf_note_model->is_teacher_creator($data->note_id, $decoded_token->data->teacher_id))){
                        if($this->staf_note_model->delete_note($data->note_id)){
                            $this->response(array("message" => "Note has been deleted", "status" => "1"), parent::HTTP_OK);
                        }else{
                            $this->response(array("message" => "Failed to delete note", "status" => "0"), parent::HTTP_INTERNAL_SERVER_ERROR);
                        }
                    } else {
                        $this->response(array("message" => "You are not the creator of this note record", "status" => "0"), parent::HTTP_CONFLICT);
                    }
                } else {
                    $this->response(array("message" => "Note doesn't exist", "status" => "0"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "Note id is needed", "status" => "0"), parent::HTTP_NOT_FOUND);
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