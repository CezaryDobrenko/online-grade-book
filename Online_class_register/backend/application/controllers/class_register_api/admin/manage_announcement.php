<?php

require APPPATH."libraries/REST_Controller.php";

//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");

class manage_announcement extends REST_Controller{

    //Constructor
    public function __construct(){
        parent::__construct();
        $this->load->model("class_register_api/admin/manage_announcement_model");
        $this->load->helper(array(
            "authorization",
            "jwt"
        ));
    }

    //Create announcement
    public function create_announcement_post(){

        if(manage_announcement::tokenAccessValidation("Administrator")){
            
            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->announcement_message, $data->announcement_date);
            $headers = $this->input->request_headers();
            $token = $headers['Authorization'];
            $decoded_token = authorization::validateToken($token);
			
            if($vfc){  
				$announcement_data = array(
					"announcement_message" => $data->announcement_message,
					"announcement_date" => $data->announcement_date,
					"announcement_creator_id" => $decoded_token->data->teacher_id
				);
				if(manage_announcement::validateInput($announcement_data)){
					if($this->manage_announcement_model->create_announcement($announcement_data)){
						$this->response(array("message" => "Announcement has been created", "status" => "1"), parent::HTTP_OK);
					} else {
						$this->response(array("message" => "Failed to create announcement", "status" => "0"), parent::HTTP_INTERNAL_SERVER_ERROR);
					}
				} else {
					$this->response(array("message" => "Thread detected, terminate request", "status" => "0"), parent::HTTP_BAD_REQUEST);
				}
			}
            else {
				$this->response(array("message" => "All fields are needed", "status" => "0"), parent::HTTP_NOT_FOUND);
            }
        }
    }

    //Read announcement
    public function read_announcements_get(){
        if(manage_announcement::tokenAccessValidation("Administrator")){
            $announcement_data = $this->manage_announcement_model->get_all_announcements();
            if(count($announcement_data) > 0){
                $this->response(array("message" => "Announcement list", "data" => $announcement_data), parent::HTTP_OK);
            } 
            else {
                $this->response(array("message" => "No data found"), parent::HTTP_NOT_FOUND);
            }
        }       
    }

    //Read single announcement
    public function read_single_announcement_get(){

        if(manage_announcement::tokenAccessValidation("Administrator")){

            if(isset($_GET['id'])){
                $announcement_data = $this->manage_announcement_model->get_announcement($_GET['id']);
    
                if(count($announcement_data) > 0){
                    $this->response(array("message" => "Announcement data", "data" => $announcement_data), parent::HTTP_OK);
                } 
                else {
                    $this->response(array("message" => "No data found"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "All field are needed"), parent::HTTP_NOT_FOUND);
            }
        }
    }

    //Update announcement
    public function update_announcement_put(){

        if(manage_announcement::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->announcement_id) && isset($data->announcement_message) && isset($data->announcement_date);
            $headers = $this->input->request_headers();
            $token = $headers['Authorization'];
            $decoded_token = authorization::validateToken($token);
	
            if($vfc){
				$announcement_data = array(
					"announcement_id" => $data->announcement_id,
					"announcement_message" => $data->announcement_message,
					"announcement_date" => $data->announcement_date,
					"announcement_creator_id" => $decoded_token->data->teacher_id
				);
				if(manage_announcement::validateInput($announcement_data)){
					if($this->manage_announcement_model->update_announcement($data->announcement_id, $announcement_data)){
						$this->response(array("message" => "Announcement has been updated", "status" => "1"), parent::HTTP_OK);
					} else {
						$this->response(array("message" => "Failed to update announcement", "status" => "0"), parent::HTTP_INTERNAL_SERVER_ERROR);
					}
				} else {
					$this->response(array("message" => "Thread detected, terminate request", "status" => "0"), parent::HTTP_BAD_REQUEST);
				}
			} else {
                $this->response(array("message" => "All fields are needed", "status" => "0"), parent::HTTP_NOT_FOUND);
            }
        }
    }   

    //Delete announcement
    public function delete_announcement_delete(){

        if(manage_announcement::tokenAccessValidation("Administrator")){
            
            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->announcement_id);
    
            if($vfc){
                if(!empty($this->manage_announcement_model->find_by_id($data->announcement_id))){
                    if($this->manage_announcement_model->delete_announcement($data->announcement_id)){
                        $this->response(array("message" => "Announcement has been deleted", "status" => "1"), parent::HTTP_OK);
                    }else{
                        $this->response(array("message" => "Failed to delete announcement", "status" => "0"), parent::HTTP_INTERNAL_SERVER_ERROR);
                    }
                } else {
                    $this->response(array("message" => "Announcement doesn't exist", "status" => "0"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "Announcement id is needed", "status" => "0"), parent::HTTP_NOT_FOUND);
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