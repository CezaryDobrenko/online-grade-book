<?php

require APPPATH."libraries/REST_Controller.php";

//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");

class staf_grade extends REST_Controller{

    //Constructor
    public function __construct(){
        parent::__construct();
        $this->load->model("class_register_api/teacher/staf_grade_model");
        $this->load->helper(array(
            "authorization",
            "jwt"
        ));
    }

    //Create grade
    public function create_grade_post(){
        if(staf_grade::tokenAccessValidation("Nauczyciel","Dyrektor")){
            $headers = $this->input->request_headers();
            $token = $headers['Authorization'];
            $decoded_token = authorization::validateToken($token);
            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->grade_value) && isset($data->grade_comment) && isset($data->grade_semester)  && isset($data->grade_category_id)  && isset($data->grade_student_id) && isset($data->grade_subject_id);
            if($vfc){  
                if(!empty($this->staf_grade_model->is_category_exists($data->grade_category_id))){
                    if(!empty($this->staf_grade_model->is_subject_exists($data->grade_subject_id))){
                        if(!empty($this->staf_grade_model->is_student_exists($data->grade_student_id))){
                            if(!empty($this->staf_grade_model->is_teacher_has_subject($decoded_token->data->teacher_id, $data->grade_subject_id))){
                                $group_id = $this->staf_grade_model->get_group_from_student($data->grade_student_id)->student_group_id;
                                if(!empty($this->staf_grade_model->check_if_student_group_has_that_lesson($group_id, $data->grade_subject_id))){
                                    $grade_data = array(
                                        "grade_value" => $data->grade_value,
                                        "grade_comment" => $data->grade_comment,
                                        "grade_category_id" => $data->grade_category_id,
                                        "grade_student_id" => $data->grade_student_id,
                                        "grade_teacher_id" => $decoded_token->data->teacher_id,
                                        "grade_subject_id" => $data->grade_subject_id,
                                        "grade_semester" => $data->grade_semester
                                    );
                                    if(staf_grade::validateInput($grade_data)){
                                        if($this->staf_grade_model->create_grade($grade_data)){
                                            $this->response(array("message" => "Grade has been created"), parent::HTTP_OK);
                                        } else {
                                            $this->response(array("message" => "Failed to create grade"), parent::HTTP_INTERNAL_SERVER_ERROR);
                                        }
                                    } else {
                                        $this->response(array("message" => "Thread detected, terminate request"), parent::HTTP_BAD_REQUEST);
                                    }
                                } else {
                                    $this->response(array("message" => "Student group does not have that subject"), parent::HTTP_CONFLICT);
                                }
                            } else {
                                $this->response(array("message" => "Teacher does not have that subject"), parent::HTTP_CONFLICT);
                            }
                        } else {
                            $this->response(array("message" => "Student does not exist"), parent::HTTP_NOT_FOUND);
                        }
                    } else {
                        $this->response(array("message" => "Subject does not exist"), parent::HTTP_NOT_FOUND);
                    }
                } else {
                    $this->response(array("message" => "Category does not exist"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "All fields are needed"), parent::HTTP_NOT_FOUND);
            }
        }       
    }

    //Read grade
    public function read_grade_get(){
        if(staf_grade::tokenAccessValidation("Nauczyciel","Dyrektor")){
            $headers = $this->input->request_headers();
            $token = $headers['Authorization'];
            $decoded_token = authorization::validateToken($token);
            $grade_data = $this->staf_grade_model->get_all_grade($decoded_token->data->teacher_id);
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
        if(staf_grade::tokenAccessValidation("Nauczyciel","Dyrektor")){
            $data = json_decode(file_get_contents("php://input"));
            if(isset($data->grade_id)){
                $headers = $this->input->request_headers();
                $token = $headers['Authorization'];
                $decoded_token = authorization::validateToken($token);
                $grade_data = $this->staf_grade_model->get_grade($data->grade_id);
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
        if(staf_grade::tokenAccessValidation("Nauczyciel","Dyrektor")){
            $headers = $this->input->request_headers();
            $token = $headers['Authorization'];
            $decoded_token = authorization::validateToken($token);
            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->grade_id) && isset($data->grade_value) && isset($data->grade_comment) && isset($data->grade_semester)  && isset($data->grade_category_id)  && isset($data->grade_student_id) && isset($data->grade_subject_id);
            if($vfc){  
                if(!empty($this->staf_grade_model->is_category_exists($data->grade_category_id))){
                    if(!empty($this->staf_grade_model->is_subject_exists($data->grade_subject_id))){
                        if(!empty($this->staf_grade_model->is_student_exists($data->grade_student_id))){
                            if(!empty($this->staf_grade_model->is_teacher_has_subject($decoded_token->data->teacher_id, $data->grade_subject_id))){
                                $group_id = $this->staf_grade_model->get_group_from_student($data->grade_student_id)->student_group_id;
                                if(!empty($this->staf_grade_model->check_if_student_group_has_that_lesson($group_id, $data->grade_subject_id))){
                                    if(!empty($this->staf_grade_model->is_teacher_creator($data->grade_id, $decoded_token->data->teacher_id))){
                                        $grade_data = array(
                                            "grade_value" => $data->grade_value,
                                            "grade_comment" => $data->grade_comment,
                                            "grade_category_id" => $data->grade_category_id,
                                            "grade_student_id" => $data->grade_student_id,
                                            "grade_teacher_id" => $decoded_token->data->teacher_id,
                                            "grade_subject_id" => $data->grade_subject_id,
                                            "grade_semester" => $data->grade_semester
                                        );
                                        if(staf_grade::validateInput($grade_data)){
                                            if($this->staf_grade_model->update_grade($data->grade_id, $grade_data)){
                                                $this->response(array("message" => "Grade has been updated"), parent::HTTP_OK);
                                            } else {
                                                $this->response(array("message" => "Failed to updated grade"), parent::HTTP_INTERNAL_SERVER_ERROR);
                                            }
                                        } else {
                                            $this->response(array("message" => "Thread detected, terminate request"), parent::HTTP_BAD_REQUEST);
                                        }
                                    } else {
                                        $this->response(array("message" => "Teacher did not create this grade"), parent::HTTP_CONFLICT);
                                    }
                                } else {
                                    $this->response(array("message" => "Student group does not have that subject"), parent::HTTP_CONFLICT);
                                }
                            } else {
                                $this->response(array("message" => "Teacher does not have that subject"), parent::HTTP_CONFLICT);
                            }
                        } else {
                            $this->response(array("message" => "Student does not exist"), parent::HTTP_NOT_FOUND);
                        }
                    } else {
                        $this->response(array("message" => "Subject does not exist"), parent::HTTP_NOT_FOUND);
                    }
                } else {
                    $this->response(array("message" => "Category does not exist"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "All fields are needed"), parent::HTTP_NOT_FOUND);
            }
        }       
    }

    //Delete grade
    public function delete_grade_delete(){

        if(staf_grade::tokenAccessValidation("Nauczyciel","Dyrektor")){

            $headers = $this->input->request_headers();
            $token = $headers['Authorization'];
            $decoded_token = authorization::validateToken($token);
            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->grade_id);
    
            if($vfc){
                if(!empty($this->staf_grade_model->find_by_id($data->grade_id))){
                    if(!empty($this->staf_grade_model->is_teacher_creator($data->grade_id, $decoded_token->data->teacher_id))){
                        if($this->staf_grade_model->delete_grade($data->grade_id)){
                            $this->response(array("message" => "Grade has been deleted"), parent::HTTP_OK);
                        }else{
                            $this->response(array("message" => "Failed to delete grade"), parent::HTTP_INTERNAL_SERVER_ERROR);
                        }
                    } else {
                        $this->response(array("message" => "Teacher did not create this grade"), parent::HTTP_CONFLICT);
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