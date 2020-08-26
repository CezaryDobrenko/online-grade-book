<?php

require APPPATH."libraries/REST_Controller.php";

//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");

class manage_group extends REST_Controller{

    //Constructor
    public function __construct(){
        parent::__construct();
        $this->load->model("class_register_api/admin/manage_group_model");
        $this->load->helper(array(
            "authorization",
            "jwt"
        ));
    }

    //Create group
    public function create_group_post(){

        if(manage_group::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->group_name) && isset($data->group_short_name)  && isset($data->group_level)  && isset($data->group_stage);
            
            if($vfc){  
                if(empty($this->manage_group_model->is_group_name_exists($data->group_name))){
                    $group_data = array(
                        "group_name" => $data->group_name,
                        "group_short_name" => $data->group_short_name,
                        "group_level" => $data->group_level,
                        "group_stage" => $data->group_stage
                    );
                    if(manage_group::validateInput($group_data)){
                        if($this->manage_group_model->create_group($group_data)){
                            $this->response(array("message" => "Group has been created"), parent::HTTP_OK);
                        } else {
                            $this->response(array("message" => "Failed to create group"), parent::HTTP_INTERNAL_SERVER_ERROR);
                        }
                    } else {
                        $this->response(array("message" => "Thread detected, terminate request"), parent::HTTP_BAD_REQUEST);
                    }
                } else {
                    $this->response(array("message" => "Group name is already exist"), parent::HTTP_CONFLICT);
                }
            } else {
                $this->response(array("message" => "All fields are needed"), parent::HTTP_NOT_FOUND);
            }
        }
    }

    //Read group
    public function read_group_get(){
        if(manage_group::tokenAccessValidation("Administrator")){
            $group_data = $this->manage_group_model->get_all_groups();
            if(count($group_data) > 0){
                $this->response(array("message" => "Group list", "data" => $group_data), parent::HTTP_OK);
            } 
            else {
                $this->response(array("message" => "No data found"), parent::HTTP_NOT_FOUND);
            }
        }       
    }

    //Read single group
    public function read_single_group_get(){

        if(manage_group::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));

            if(isset($data->group_id)){
                $group_data = $this->manage_group_model->get_group($data->group_id);
    
                if(count($group_data) > 0){
                    $this->response(array("message" => "Group data", "data" => $group_data), parent::HTTP_OK);
                } 
                else {
                    $this->response(array("message" => "No data found"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "All field are needed"), parent::HTTP_NOT_FOUND);
            }
        }
    }

    //Update group
    public function update_group_put(){

        if(manage_group::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->group_id) && isset($data->group_name) && isset($data->group_short_name)  && isset($data->group_level)  && isset($data->group_stage);

            if($vfc){
                if(empty($this->manage_group_model->is_group_name_unique($data->group_name, $data->group_id))){
                    $group_data = array(
                        "group_name" => $data->group_name,
                        "group_short_name" => $data->group_short_name,
                        "group_level" => $data->group_level,
                        "group_stage" => $data->group_stage
                    );
                    if(manage_group::validateInput($group_data)){
                        if($this->manage_group_model->update_group($data->group_id, $group_data)){
                            $this->response(array("message" => "Group has been updated"), parent::HTTP_OK);
                        } else {
                            $this->response(array("message" => "Failed to update group"), parent::HTTP_INTERNAL_SERVER_ERROR);
                        }
                    } else {
                        $this->response(array("message" => "Thread detected, terminate request"), parent::HTTP_BAD_REQUEST);
                    }
                } else {
                    $this->response(array("message" => "Group name already exists"), parent::HTTP_CONFLICT);
                }
            } else {
                $this->response(array("message" => "All fields are needed"), parent::HTTP_NOT_FOUND);
            }
        }
    }   

    //Delete group
    public function delete_group_delete(){

        if(manage_group::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->group_id);
    
            if($vfc){
                if(!empty($this->manage_group_model->find_by_id($data->group_id))){
                    if($this->manage_group_model->delete_group($data->group_id)){
                        $this->response(array("message" => "Group has been deleted"), parent::HTTP_OK);
                    }else{
                        $this->response(array("message" => "Failed to delete group"), parent::HTTP_INTERNAL_SERVER_ERROR);
                    }
                } else {
                    $this->response(array("message" => "Group doesn't exist"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "Group id is needed"), parent::HTTP_NOT_FOUND);
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