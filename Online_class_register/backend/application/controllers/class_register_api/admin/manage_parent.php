<?php

require APPPATH."libraries/REST_Controller.php";

//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");

class manage_parent extends REST_Controller{

    //Constructor
    public function __construct(){
        parent::__construct();
        $this->load->model("class_register_api/admin/manage_parent_model");
        $this->load->helper(array(
            "authorization",
            "jwt"
        ));
    }

    //Create parent
    public function create_parent_post(){

        if(manage_parent::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->parent_email) && isset($data->parent_password)  && isset($data->parent_student_id) && isset($data->parent_is_active);
            
            if($vfc){  
                if(empty($this->manage_parent_model->is_email_exists($data->parent_email))){
                    if(!empty($this->manage_parent_model->is_student_exists($data->parent_student_id))){
                        $parent_data = array(
                            "parent_email" => $data->parent_email,
                            "parent_password" => password_hash($data->parent_password,PASSWORD_DEFAULT),
                            "parent_is_active" => $data->parent_is_active,
                            "parent_student_id" => $data->parent_student_id
                        );
                        if(manage_parent::validateInput($parent_data)){
                            if($this->manage_parent_model->create_parent($parent_data)){
                                $this->response(array("message" => "Parent has been created", "status" => "1"), parent::HTTP_OK);
                            } else {
                                $this->response(array("message" => "Failed to create parent", "status" => "0"), parent::HTTP_INTERNAL_SERVER_ERROR);
                            }
                        } else {
                            $this->response(array("message" => "Thread detected, terminate request", "status" => "0"), parent::HTTP_BAD_REQUEST);
                        }
                    } else {
                        $this->response(array("message" => "Student does not exist", "status" => "0"), parent::HTTP_NOT_FOUND);
                    }
                } else {
                    $this->response(array("message" => "Email address has been taken", "status" => "0"), parent::HTTP_CONFLICT);
                }
            } else {
                $this->response(array("message" => "All fields are needed", "status" => "0"), parent::HTTP_NOT_FOUND);
            }
        }
    }

    //Read parent
    public function read_parent_get(){
        if(manage_parent::tokenAccessValidation("Administrator")){
            $parent_data = $this->manage_parent_model->get_all_parents();
            if(count($parent_data) > 0){
                $this->response(array("message" => "Parent list", "data" => $parent_data), parent::HTTP_OK);
            } 
            else {
                $this->response(array("message" => "No data found"), parent::HTTP_NOT_FOUND);
            }
        }       
    }

    //Read single parent
    public function read_single_parent_get(){

        if(manage_parent::tokenAccessValidation("Administrator")){

            if(isset($_GET['id'])){
                $parent_data = $this->manage_parent_model->get_parent($_GET['id']);
    
                if(count($parent_data) > 0){
                    $this->response(array("message" => "Parent data", "data" => $parent_data), parent::HTTP_OK);
                } 
                else {
                    $this->response(array("message" => "No data found"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "All field are needed"), parent::HTTP_NOT_FOUND);
            }
        }
    }

    //Update parent
    public function update_parent_put(){

        if(manage_parent::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->parent_id) && isset($data->parent_email) && isset($data->parent_password)  && isset($data->parent_student_id) && isset($data->parent_is_active);

            if($vfc){
                if(empty($this->manage_parent_model->is_email_unique($data->parent_email, $data->parent_id))){
                    if(!empty($this->manage_parent_model->is_student_exists($data->parent_student_id))){
                        $parent_data = array(
                            "parent_email" => $data->parent_email,
                            "parent_password" => password_hash($data->parent_password,PASSWORD_DEFAULT),
                            "parent_is_active" => $data->parent_is_active,
                            "parent_student_id" => $data->parent_student_id
                        );
                        if(manage_parent::validateInput($parent_data)){
                            if($this->manage_parent_model->update_parent($data->parent_id, $parent_data)){
                                $this->response(array("message" => "Parent has been updated", "status" => "1"), parent::HTTP_OK);
                            } else {
                                $this->response(array("message" => "Failed to update parent", "status" => "0"), parent::HTTP_INTERNAL_SERVER_ERROR);
                            }
                        } else {
                            $this->response(array("message" => "Thread detected, terminate request", "status" => "0"), parent::HTTP_BAD_REQUEST);
                        }
                    } else {
                        $this->response(array("message" => "Student does not exist", "status" => "0"), parent::HTTP_NOT_FOUND);
                    }
                } else {
                    $this->response(array("message" => "Email adress has been taken", "status" => "0"), parent::HTTP_CONFLICT);
                }
            } else {
                $this->response(array("message" => "All fields are needed", "status" => "0"), parent::HTTP_NOT_FOUND);
            }
        }
    }   

    //Delete parent
    public function delete_parent_delete(){

        if(manage_parent::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->parent_id);
    
            if($vfc){
                if(!empty($this->manage_parent_model->find_by_id($data->parent_id))){
                    if($this->manage_parent_model->delete_parent($data->parent_id)){
                        $this->response(array("message" => "Parent has been deleted", "status" => "1"), parent::HTTP_OK);
                    }else{
                        $this->response(array("message" => "Failed to delete parent", "status" => "0"), parent::HTTP_INTERNAL_SERVER_ERROR);
                    }
                } else {
                    $this->response(array("message" => "Parent doesn't exist", "status" => "0"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "Parent id is needed", "status" => "0"), parent::HTTP_NOT_FOUND);
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