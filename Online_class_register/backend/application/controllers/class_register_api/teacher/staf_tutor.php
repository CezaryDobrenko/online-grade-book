<?php

require APPPATH."libraries/REST_Controller.php";

//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");

class staf_tutor extends REST_Controller{

    //Constructor
    public function __construct(){
        parent::__construct();
        $this->load->model("class_register_api/teacher/staf_tutor_model");
        $this->load->helper(array(
            "authorization",
            "jwt"
        ));
    }

    //Read absence
    public function read_tutor_get(){
        if(staf_tutor::tokenAccessValidation("Teacher","Headmaster")){
            $headers = $this->input->request_headers();
            $token = $headers['Authorization'];
            $decoded_token = authorization::validateToken($token);
			$absence_group = array();
            $students_data = $this->staf_tutor_model->get_all_students($decoded_token->data->teacher_group);
			for($i = 0; $i < count($students_data); $i++){
				$tmp = $this->staf_tutor_model->get_all_absence($students_data[$i]->student_id);
				$absence_group = array_merge($absence_group, $tmp);
			}
            if(count($absence_group) > 0){
                $this->response(array("message" => "Absence list", "data" => $absence_group), parent::HTTP_OK);
            } 
            else {
                $this->response(array("message" => "No data found"), parent::HTTP_NOT_FOUND);
            }
        }       
    }

    //Read single note
    public function read_single_tutor_get(){

        if(staf_tutor::tokenAccessValidation("Teacher","Headmaster")){

            if(isset($_GET['id'])){
                $absence_data = $this->staf_tutor_model->get_absence($_GET['id']);
    
                if(count($absence_data) > 0){
                    $this->response(array("message" => "Note data", "data" => $absence_data), parent::HTTP_OK);
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
    public function update_tutor_put(){

        if(staf_tutor::tokenAccessValidation("Teacher","Headmaster")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->absence_id) && isset($data->absence_lesson_number) && isset($data->absence_date) && isset($data->absence_is_justified) && isset($data->absence_student_id);
            $headers = $this->input->request_headers();
            $token = $headers['Authorization'];
            $decoded_token = authorization::validateToken($token);

            if($vfc){  
                if(!empty($this->staf_tutor_model->is_student_exists($data->absence_student_id))){
					$absence_data = array(
						"absence_lesson_number" => $data->absence_lesson_number,
						"absence_date" => $data->absence_date,
						"absence_is_justified" => $data->absence_is_justified,
						"absence_teacher_id" => $decoded_token->data->teacher_id,
						"absence_student_id" => $data->absence_student_id
					);
					if(staf_tutor::validateInput($absence_data)){
						if($this->staf_tutor_model->update_absence($data->absence_id, $absence_data)){
							$this->response(array("message" => "Absence has been updated", "status" => "1"), parent::HTTP_OK);
						} else {
							$this->response(array("message" => "Failed to update absence", "status" => "0"), parent::HTTP_INTERNAL_SERVER_ERROR);
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

    //Delete absence
    public function delete_tutor_delete(){

        if(staf_tutor::tokenAccessValidation("Teacher","Headmaster")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->absence_id);
            $headers = $this->input->request_headers();
            $token = $headers['Authorization'];
            $decoded_token = authorization::validateToken($token);
            
            if($vfc){
                if(!empty($this->staf_tutor_model->find_by_id($data->absence_id))){
					if($this->staf_tutor_model->delete_absence($data->absence_id)){
						$this->response(array("message" => "Absence has been deleted", "status" => "1"), parent::HTTP_OK);
					}else{
						$this->response(array("message" => "Failed to delete absence", "status" => "0"), parent::HTTP_INTERNAL_SERVER_ERROR);
					}
                } else {
                    $this->response(array("message" => "Absence doesn't exist", "status" => "0"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "Absence id is needed", "status" => "0"), parent::HTTP_NOT_FOUND);
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