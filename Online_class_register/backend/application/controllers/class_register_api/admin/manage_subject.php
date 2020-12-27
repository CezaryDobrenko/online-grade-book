<?php

require APPPATH."libraries/REST_Controller.php";

//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");

class manage_subject extends REST_Controller{

    //Constructor
    public function __construct(){
        parent::__construct();
        $this->load->model("class_register_api/admin/manage_subject_model");
        $this->load->helper(array(
            "authorization",
            "jwt"
        ));
    }

    //Create subject
    public function create_subject_post(){

        if(manage_subject::tokenAccessValidation("Administrator")){
            
            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->subject_name);
            
            if($vfc){  
                if(empty($this->manage_subject_model->is_subject_exists($data->subject_name))){
                    $subject_data = array(
                        "subject_name" => $data->subject_name
                    );
                    if(manage_subject::validateInput($subject_data)){
                        if($this->manage_subject_model->create_subject($subject_data)){
                            $this->response(array("message" => "Subject has been created", "status" => "1"), parent::HTTP_OK);
                        } else {
                            $this->response(array("message" => "Failed to create subject", "status" => "0"), parent::HTTP_INTERNAL_SERVER_ERROR);
                        }
                    } else {
                        $this->response(array("message" => "Thread detected, terminate request", "status" => "0"), parent::HTTP_BAD_REQUEST);
                    }
                } else {
                    $this->response(array("message" => "Subject already exists", "status" => "0"), parent::HTTP_CONFLICT);
                }
            } else {
                $this->response(array("message" => "All fields are needed", "status" => "0"), parent::HTTP_NOT_FOUND);
            }
        }
    }

    //Read subject
    public function read_subject_get(){
        if(manage_subject::tokenAccessValidation("Administrator")){
            $subject_data = $this->manage_subject_model->get_all_subjects();
            if(count($subject_data) > 0){
                $this->response(array("message" => "Subject list", "data" => $subject_data), parent::HTTP_OK);
            } 
            else {
                $this->response(array("message" => "No data found"), parent::HTTP_NOT_FOUND);
            }
        }       
    }

    //Read single subject
    public function read_single_subject_get(){

        if(manage_subject::tokenAccessValidation("Administrator")){

            if(isset($_GET['id'])){
                $subject_data = $this->manage_subject_model->get_subject($_GET['id']);
    
                if(count($subject_data) > 0){
                    $this->response(array("message" => "Subject data", "data" => $subject_data), parent::HTTP_OK);
                } 
                else {
                    $this->response(array("message" => "No data found"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "All field are needed"), parent::HTTP_NOT_FOUND);
            }
        }
    }

    //Update subject
    public function update_subject_put(){

        if(manage_subject::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->subject_id) && isset($data->subject_name);
    
            if($vfc){
                if(empty($this->manage_subject_model->is_subject_unique($data->subject_name, $data->subject_id))){
                    $subject_data = array(
                        "subject_name" => $data->subject_name,
                    );
                    if(manage_subject::validateInput($subject_data)){
						if($this->manage_subject_model->update_subject($data->subject_id, $subject_data)){
							$this->response(array("message" => "Teacher has been updated", "status" => "1"), parent::HTTP_OK);
						} else {
							$this->response(array("message" => "Failed to update teacher", "status" => "0"), parent::HTTP_INTERNAL_SERVER_ERROR);
						}
                    } else {
                        $this->response(array("message" => "Thread detected, terminate request", "status" => "0"), parent::HTTP_BAD_REQUEST);
                    }
                } else {
                    $this->response(array("message" => "Subject already exists", "status" => "0"), parent::HTTP_CONFLICT);
                }
            } else {
                $this->response(array("message" => "All fields are needed", "status" => "0"), parent::HTTP_NOT_FOUND);
            }
        }
    }   

    //Delete subject
    public function delete_subject_delete(){

        if(manage_subject::tokenAccessValidation("Administrator")){
            
            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->subject_id);
    
            if($vfc){
                if(!empty($this->manage_subject_model->find_by_id($data->subject_id))){
                    if($this->manage_subject_model->delete_subject($data->subject_id)){
                        $this->response(array("message" => "Subject has been deleted", "status" => "1"), parent::HTTP_OK);
                    }else{
                        $this->response(array("message" => "Failed to delete subject", "status" => "0"), parent::HTTP_INTERNAL_SERVER_ERROR);
                    }
                } else {
                    $this->response(array("message" => "Subject doesn't exist", "status" => "0"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "Subject id is needed", "status" => "0"), parent::HTTP_NOT_FOUND);
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