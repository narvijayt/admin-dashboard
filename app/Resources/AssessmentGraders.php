<?php

namespace App\Resources;

use App\Library\ScoringEngine;

Class AssessmentGraders{

    protected $ScoringEngine;

    public function __construct(){
        $this->ScoringEngine = new ScoringEngine();
    }
    /**
     * 
     */
    public function _getAssessmentGraders($data = []){
        $errors = [];     

        $request_body = $this->defaultParameters();

        if(isset($data['id']) && !empty($data['id'])){
            $request_body['query_string'] = $data['id'];
            unset($data['id']);
        }
        $request_body = array_merge($request_body, $data);
        return $this->ScoringEngine->_getRequest($request_body, false);   
    }


    /**
     * 
     */
    public function _createAssessmentGraders($data = []){
        $errors = [];     

        $request_body = $this->defaultParameters();

        if(isset($data['id']) && !empty($data['id'])){
            $request_body['query_string'] = $data['id'];
            unset($data['id']);
        }
        $request_body = array_merge($request_body, $data);
        return $this->ScoringEngine->_postRequest($request_body, false);        
    }


    /**
     * 
     */
    public function _updateAssessmentGraders($data = []){
        $errors = [];     

        $request_body = $this->defaultParameters();

        if(isset($data['id']) && !empty($data['id'])){
            $request_body['query_string'] = $data['id'];
            unset($data['id']);
        }
        $request_body = array_merge($request_body, $data);
        return $this->ScoringEngine->_putRequest($request_body, false);        
    }
    
    /**
     * Delete HTTP Request
     */
    public function _deleteAssessmentGraders($data = []){
        $errors = [];     

        $request_body = $this->defaultParameters();

        if(isset($data['id']) && !empty($data['id'])){
            $request_body['query_string'] = $data['id'];
            unset($data['id']);
        }
        $request_body = array_merge($request_body, $data);
        return $this->ScoringEngine->_deleteRequest($request_body, false);
    }

    public function defaultParameters(){
        return [
            'service'   =>  'api/v1/self-assessment-graders',
        ];
    }
}