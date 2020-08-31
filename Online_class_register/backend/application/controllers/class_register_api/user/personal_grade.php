<?php

require APPPATH."libraries/REST_Controller.php";

//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");

class personal_grade extends REST_Controller{

    //Constructor
    public function __construct(){
        parent::__construct();
        $this->load->model("class_register_api/user/personal_grade_model");
        $this->load->helper(array(
            "authorization",
            "jwt"
        ));
    }

    //Read grade
    public function read_grade_get(){
        if(personal_grade::tokenAccessValidation("Student","Rodzic")){
            $headers = $this->input->request_headers();
            $token = $headers['Authorization'];
            $decoded_token = authorization::validateToken($token);
            $group_id = $this->personal_grade_model->find_student_group($decoded_token->data->student_id)->student_group_id;
            $subject_data = $this->personal_grade_model->get_all_subject($group_id);
            $grades_data = $this->personal_grade_model->get_all_grade($decoded_token->data->student_id);
            $final_data = array();

            foreach ($subject_data as &$name) {
                $subject_name = $name->subject_name;
                $final_data[$subject_name] = array();
            }

            foreach ($grades_data as &$grade) {
                array_push($final_data[$grade->grade_subject_name], (array)$grade); 
            }

            if(count($final_data) > 0){
                $this->response(array("message" => "Grade list", "data" => $final_data), parent::HTTP_OK);
            } 
            else {
                $this->response(array("message" => "No data found"), parent::HTTP_NOT_FOUND);
            }  
        

        }       
    }

    //Read single grade
    public function read_single_grade_get(){
        if(personal_grade::tokenAccessValidation("Student","Rodzic")){
            $data = json_decode(file_get_contents("php://input"));

            if(isset($data->grade_id)){
                $grade_data = $this->personal_grade_model->get_grade($data->grade_id);
    
                if(count((array)$grade_data) > 0){
                    $this->response(array("message" => "Grade data", "data" => $grade_data), parent::HTTP_OK);
                } 
                else {
                    $this->response(array("message" => "No data found"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "All field are needed"), parent::HTTP_NOT_FOUND);
            }
        }       
    }

    //Token validation
    public function tokenAccessValidation($role,$role2){

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


}

?>