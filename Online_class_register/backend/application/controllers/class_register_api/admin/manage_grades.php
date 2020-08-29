<?php

require APPPATH."libraries/REST_Controller.php";

//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");

class manage_grades extends REST_Controller{

    //Constructor
    public function __construct(){
        parent::__construct();
        $this->load->model("class_register_api/admin/manage_grade_model");
        $this->load->helper(array(
            "authorization",
            "jwt"
        ));
    }

    //Create grade
    public function create_grade_post(){

        if(manage_grades::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->grade_value) && isset($data->grade_comment) && isset($data->grade_semester)  && isset($data->grade_category_id)  && isset($data->grade_student_id)  && isset($data->grade_teacher_id) && isset($data->grade_subject_id);
            
            if($vfc){  
                if(!empty($this->manage_grade_model->is_teacher_exists($data->grade_teacher_id))){
                    if(!empty($this->manage_grade_model->is_student_exists($data->grade_student_id))){
                        if(!empty($this->manage_grade_model->is_category_exists($data->grade_category_id))){
                            if(!empty($this->manage_grade_model->is_subject_exists($data->grade_subject_id))){
                                $student_group_id = $this->manage_grade_model->is_student_exists($data->grade_student_id)->student_group_id;
                                if(!empty($this->manage_grade_model->check_if_student_group_has_that_lesson($student_group_id, $data->grade_subject_id))){
                                    $grade_data = array(
                                        "grade_value" => $data->grade_value,
                                        "grade_comment" => $data->grade_comment,
                                        "grade_category_id" => $data->grade_category_id,
                                        "grade_student_id" => $data->grade_student_id,
                                        "grade_teacher_id" => $data->grade_teacher_id,
                                        "grade_subject_id" => $data->grade_subject_id,
                                        "grade_semester" => $data->grade_semester
                                    );
                                    if(manage_grades::validateInput($grade_data)){
                                        if($this->manage_grade_model->create_grade($grade_data)){
                                            $this->response(array("message" => "Grade has been created"), parent::HTTP_OK);
                                        } else {
                                            $this->response(array("message" => "Failed to create grade"), parent::HTTP_INTERNAL_SERVER_ERROR);
                                        }
                                    } else {
                                        $this->response(array("message" => "Thread detected, terminate request"), parent::HTTP_BAD_REQUEST);
                                    }
                                } else {
                                    $this->response(array("message" => "Student group does not have that subject"), parent::HTTP_NOT_FOUND);
                                }
                            } else {
                                $this->response(array("message" => "Subject does not exist"), parent::HTTP_NOT_FOUND);
                            }
                        } else {
                            $this->response(array("message" => "Category does not exist"), parent::HTTP_NOT_FOUND);
                        }
                    } else {
                        $this->response(array("message" => "Student does not exist"), parent::HTTP_NOT_FOUND);
                    }
                } else {
                    $this->response(array("message" => "Teacher does not exist"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "All fields are needed"), parent::HTTP_NOT_FOUND);
            }
        }
    }

    //Read grade
    public function read_grade_get(){
        if(manage_grades::tokenAccessValidation("Administrator")){
            $grade_data = $this->manage_grade_model->get_all_grades();
            if(count($grade_data) > 0){
                $this->response(array("message" => "Grade list", "data" => $grade_data), parent::HTTP_OK);
            } 
            else {
                $this->response(array("message" => "No data found"), parent::HTTP_NOT_FOUND);
            }
        }       
    }

    //Read single grade
    public function read_single_grade_get(){

        if(manage_grades::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));

            if(isset($data->grade_id)){
                $grade_data = $this->manage_grade_model->get_grade($data->grade_id);
    
                if(count($grade_data) > 0){
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

    //Update grade
    public function update_grade_put(){

        if(manage_grades::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->grade_id) && isset($data->grade_value) && isset($data->grade_comment) && isset($data->grade_semester)  && isset($data->grade_category_id)  && isset($data->grade_student_id)  && isset($data->grade_teacher_id) && isset($data->grade_subject_id);
            
            if($vfc){  
                if(!empty($this->manage_grade_model->is_teacher_exists($data->grade_teacher_id))){
                    if(!empty($this->manage_grade_model->is_student_exists($data->grade_student_id))){
                        if(!empty($this->manage_grade_model->is_category_exists($data->grade_category_id))){
                            if(!empty($this->manage_grade_model->is_subject_exists($data->grade_subject_id))){
                                $student_group_id = $this->manage_grade_model->is_student_exists($data->grade_student_id)->student_group_id;
                                if(!empty($this->manage_grade_model->check_if_student_group_has_that_lesson($student_group_id, $data->grade_subject_id))){
                                    $grade_data = array(
                                        "grade_value" => $data->grade_value,
                                        "grade_comment" => $data->grade_comment,
                                        "grade_category_id" => $data->grade_category_id,
                                        "grade_student_id" => $data->grade_student_id,
                                        "grade_teacher_id" => $data->grade_teacher_id,
                                        "grade_subject_id" => $data->grade_subject_id,
                                        "grade_semester" => $data->grade_semester
                                    );
                                    if(manage_grades::validateInput($grade_data)){
                                        if($this->manage_grade_model->update_grade($data->grade_id, $grade_data)){
                                            $this->response(array("message" => "Grade has been updated"), parent::HTTP_OK);
                                        } else {
                                            $this->response(array("message" => "Failed to update grade"), parent::HTTP_INTERNAL_SERVER_ERROR);
                                        }
                                    } else {
                                        $this->response(array("message" => "Thread detected, terminate request"), parent::HTTP_BAD_REQUEST);
                                    }
                                } else {
                                    $this->response(array("message" => "Student group does not have that subject"), parent::HTTP_NOT_FOUND);
                                }
                            } else {
                                $this->response(array("message" => "Subject does not exist"), parent::HTTP_NOT_FOUND);
                            }
                        } else {
                            $this->response(array("message" => "Category does not exist"), parent::HTTP_NOT_FOUND);
                        }
                    } else {
                        $this->response(array("message" => "Student does not exist"), parent::HTTP_NOT_FOUND);
                    }
                } else {
                    $this->response(array("message" => "Teacher does not exist"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "All fields are needed"), parent::HTTP_NOT_FOUND);
            }
        }
    }   

    //Delete grade
    public function delete_grade_delete(){

        if(manage_grades::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->grade_id);
    
            if($vfc){
                if(!empty($this->manage_grade_model->find_by_id($data->grade_id))){
                    if($this->manage_grade_model->delete_grade($data->grade_id)){
                        $this->response(array("message" => "Grade has been deleted"), parent::HTTP_OK);
                    }else{
                        $this->response(array("message" => "Failed to delete grade"), parent::HTTP_INTERNAL_SERVER_ERROR);
                    }
                } else {
                    $this->response(array("message" => "Grade doesn't exist"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "Grade id is needed"), parent::HTTP_NOT_FOUND);
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