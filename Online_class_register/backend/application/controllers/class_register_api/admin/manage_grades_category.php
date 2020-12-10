<?php

require APPPATH."libraries/REST_Controller.php";

//headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");

class manage_grades_category extends REST_Controller{

    //Constructor
    public function __construct(){
        parent::__construct();
        $this->load->model("class_register_api/admin/manage_grades_category_model");
        $this->load->helper(array(
            "authorization",
            "jwt"
        ));
    }

    //Create grades_category
    public function create_grades_category_post(){

        if(manage_grades_category::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->grade_category_name) && isset($data->grade_category_weight)  && isset($data->grade_category_color);
            
            if($vfc){  
                if(empty($this->manage_grades_category_model->is_grade_category_exists($data->grade_category_name))){
                    $grade_category_data = array(
                        "grade_category_name" => $data->grade_category_name,
                        "grade_category_weight" => $data->grade_category_weight,
                        "grade_category_color" => $data->grade_category_color
                    );
                    if(manage_grades_category::validateInput($grade_category_data)){
                        if($this->manage_grades_category_model->create_grade_category($grade_category_data)){
                            $this->response(array("message" => "Category has been created", "status" => "1"), parent::HTTP_OK);
                        } else {
                            $this->response(array("message" => "Failed to create category", "status" => "0"), parent::HTTP_INTERNAL_SERVER_ERROR);
                        }
                    } else {
                        $this->response(array("message" => "Thread detected, terminate request", "status" => "0"), parent::HTTP_BAD_REQUEST);
                    }
                } else {
                    $this->response(array("message" => "Category name already exists", "status" => "0"), parent::HTTP_CONFLICT);
                }
            } else {
                $this->response(array("message" => "All fields are needed", "status" => "0"), parent::HTTP_NOT_FOUND);
            }
        }
    }

    //Read grades_category
    public function read_grades_category_get(){
        if(manage_grades_category::tokenAccessValidation("Administrator")){
            $grade_category_data = $this->manage_grades_category_model->get_all_grade_category();
            if(count($grade_category_data) > 0){
                $this->response(array("message" => "Category list", "data" => $grade_category_data), parent::HTTP_OK);
            } 
            else {
                $this->response(array("message" => "No data found"), parent::HTTP_NOT_FOUND);
            }
        }       
    }

    //Read single grades_category
    public function read_single_grades_category_get(){

        if(manage_grades_category::tokenAccessValidation("Administrator")){

            if(isset($_GET['id'])){
                $grade_category_data = $this->manage_grades_category_model->get_grade_category($_GET['id']);
    
                if(count($grade_category_data) > 0){
                    $this->response(array("message" => "Category data", "data" => $grade_category_data), parent::HTTP_OK);
                } 
                else {
                    $this->response(array("message" => "No data found"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "All field are needed"), parent::HTTP_NOT_FOUND);
            }
        }
    }

    //Update grades_category
    public function update_grades_category_put(){

        if(manage_grades_category::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->grade_category_id) && isset($data->grade_category_name) && isset($data->grade_category_weight)  && isset($data->grade_category_color);
    
            if($vfc){
                if(!empty($this->manage_grades_category_model->find_by_id($data->grade_category_id))){
                    if(empty($this->manage_grades_category_model->is_grade_category_unique($data->grade_category_name, $data->grade_category_id))){
                        $grade_category_data = array(
                            "grade_category_name" => $data->grade_category_name,
                            "grade_category_weight" => $data->grade_category_weight,
                            "grade_category_color" => $data->grade_category_color
                        );
                        if(manage_grades_category::validateInput($grade_category_data)){
                            if($this->manage_grades_category_model->update_grade_category($data->grade_category_id, $grade_category_data)){
                                $this->response(array("message" => "Category has been updated", "status" => "1"), parent::HTTP_OK);
                            } else {
                                $this->response(array("message" => "Failed to update category", "status" => "0"), parent::HTTP_INTERNAL_SERVER_ERROR);
                            }
                        } else {
                            $this->response(array("message" => "Thread detected, terminate request", "status" => "0"), parent::HTTP_BAD_REQUEST);
                        }
                    } else {
                        $this->response(array("message" => "Category name has been taken", "status" => "0"), parent::HTTP_NOT_FOUND);
                    }
                } else {
                    $this->response(array("message" => "Categoty does not exist", "status" => "0"), parent::HTTP_CONFLICT);
                }
            } else {
                $this->response(array("message" => "All fields are needed", "status" => "0"), parent::HTTP_NOT_FOUND);
            }
        }
    }   

    //Delete grades_category
    public function delete_grades_category_delete(){

        if(manage_grades_category::tokenAccessValidation("Administrator")){

            $data = json_decode(file_get_contents("php://input"));
            $vfc = isset($data->grade_category_id);
    
            if($vfc){
                if(!empty($this->manage_grades_category_model->find_by_id($data->grade_category_id))){
                    if($this->manage_grades_category_model->delete_grade_category($data->grade_category_id)){
                        $this->response(array("message" => "Categoty has been deleted", "status" => "1"), parent::HTTP_OK);
                    }else{
                        $this->response(array("message" => "Failed to delete teacher", "status" => "0"), parent::HTTP_INTERNAL_SERVER_ERROR);
                    }
                } else {
                    $this->response(array("message" => "Categoty doesn't exist", "status" => "0"), parent::HTTP_NOT_FOUND);
                }
            } else {
                $this->response(array("message" => "Categoty id is needed", "status" => "0"), parent::HTTP_NOT_FOUND);
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