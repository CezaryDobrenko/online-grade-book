<?php

require APPPATH."libraries/REST_Controller.php";

//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");

class manage_lesson extends REST_Controller{

    //Constructor
    public function __construct(){
        parent::__construct();
        $this->load->model("class_register_api/admin/manage_lesson_model");
        $this->load->helper(array(
            "authorization",
            "jwt"
        ));
    }

    //Create lesson
    public function create_lesson_post(){

        if(manage_lesson::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->group_subject_subject_id) && isset($data->group_subject_group_id);
            
            if($vfc){  
                if(!empty($this->manage_lesson_model->is_subject_exists($data->group_subject_subject_id))){
                    if(!empty($this->manage_lesson_model->is_group_exists($data->group_subject_group_id))){
                        if(empty($this->manage_lesson_model->is_relation_exists($data->group_subject_group_id, $data->group_subject_subject_id))){
                            $lesson_data = array(
                                "group_subject_subject_id" => $data->group_subject_subject_id,
                                "group_subject_group_id" => $data->group_subject_group_id
                            );
                            if(manage_lesson::validateInput($lesson_data)){
                                if($this->manage_lesson_model->create_lesson($lesson_data)){
                                    $this->response(array("message" => "Lesson has been created", "status" => "1"), parent::HTTP_OK);
                                } else {
                                    $this->response(array("message" => "Failed to create lesson", "status" => "0"), parent::HTTP_INTERNAL_SERVER_ERROR);
                                }
                            } else {
                                $this->response(array("message" => "Thread detected, terminate request", "status" => "0"), parent::HTTP_BAD_REQUEST);
                            }
                        } else {
                            $this->response(array("message" => "Group does have that subject already", "status" => "0"), parent::HTTP_CONFLICT);
                        }
                    } else {
                        $this->response(array("message" => "Group does not exist", "status" => "0"), parent::HTTP_NOT_FOUND);
                    }
                } else {
                    $this->response(array("message" => "Subject does not exist", "status" => "0"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "All fields are needed", "status" => "0"), parent::HTTP_NOT_FOUND);
            }
        }
    }

    //Read lesson
    public function read_lesson_get(){
        if(manage_lesson::tokenAccessValidation("Administrator")){
            $lesson_data = $this->manage_lesson_model->get_all_lesson();
            if(count($lesson_data) > 0){
                $this->response(array("message" => "Lesson list", "data" => $lesson_data), parent::HTTP_OK);
            } 
            else {
                $this->response(array("message" => "No data found"), parent::HTTP_NOT_FOUND);
            }
        }       
    }

    //Read single lesson
    public function read_single_lesson_get(){

        if(manage_lesson::tokenAccessValidation("Administrator")){

            if(isset($_GET['id'])){
                $lesson_data = $this->manage_lesson_model->get_lesson($_GET['id']);
    
                if(count($lesson_data) > 0){
                    $this->response(array("message" => "Lesson data", "data" => $lesson_data), parent::HTTP_OK);
                } 
                else {
                    $this->response(array("message" => "No data found"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "All field are needed"), parent::HTTP_NOT_FOUND);
            }
        }
    }

    //Update lesson
    public function update_lesson_put(){

        if(manage_lesson::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->group_subject_id) && isset($data->group_subject_subject_id) && isset($data->group_subject_group_id);
    
            if($vfc){
                if(!empty($this->manage_lesson_model->find_by_id($data->group_subject_id))){
                    if(!empty($this->manage_lesson_model->is_subject_exists($data->group_subject_subject_id))){
                        if(!empty($this->manage_lesson_model->is_group_exists($data->group_subject_group_id))){
                            if(empty($this->manage_lesson_model->is_relation_exists($data->group_subject_group_id, $data->group_subject_subject_id))){
                                $lesson_data = array(
                                    "group_subject_subject_id" => $data->group_subject_subject_id,
                                    "group_subject_group_id" => $data->group_subject_group_id
                                );
                                if(manage_lesson::validateInput($lesson_data)){
                                    if($this->manage_lesson_model->update_lesson($data->group_subject_id, $lesson_data)){
                                        $this->response(array("message" => "Lesson has been updated", "status" => "1"), parent::HTTP_OK);
                                    } else {
                                        $this->response(array("message" => "Failed to update lesson", "status" => "0"), parent::HTTP_INTERNAL_SERVER_ERROR);
                                    }
                                } else {
                                    $this->response(array("message" => "Thread detected, terminate request", "status" => "0"), parent::HTTP_BAD_REQUEST);
                                }
                            } else {
                                $this->response(array("message" => "Group does have that subject already", "status" => "0"), parent::HTTP_CONFLICT);
                            }
                        } else {
                            $this->response(array("message" => "Group does not exist", "status" => "0"), parent::HTTP_NOT_FOUND);
                        }
                    } else {
                        $this->response(array("message" => "Subject does not exist", "status" => "0"), parent::HTTP_CONFLICT);
                    }
                } else {
                    $this->response(array("message" => "Lesson does not exist", "status" => "0"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "All fields are needed", "status" => "0"), parent::HTTP_NOT_FOUND);
            }
        }
    }   

    //Delete lesson
    public function delete_lesson_delete(){

        if(manage_lesson::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->group_subject_id);
    
            if($vfc){
                if(!empty($this->manage_lesson_model->find_by_id($data->group_subject_id))){
                    if($this->manage_lesson_model->delete_lesson($data->group_subject_id)){
                        $this->response(array("message" => "Lesson has been deleted", "status" => "1"), parent::HTTP_OK);
                    }else{
                        $this->response(array("message" => "Failed to delete lesson", "status" => "0"), parent::HTTP_INTERNAL_SERVER_ERROR);
                    }
                } else {
                    $this->response(array("message" => "Lesson doesn't exist", "status" => "0"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "Lesson id is needed", "status" => "0"), parent::HTTP_NOT_FOUND);
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