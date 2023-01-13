<?php

namespace App\Resources;

use App\Library\ScoringEngine;

Class AssessmentEditions{

    protected $ScoringEngine;

    public function __construct(){
        $this->ScoringEngine = new ScoringEngine();
    }
    /**
     * 
     */
    public function _getAssessmentEditions($data = []){
        $errors = [];     

        $request_body = $this->defaultParameters();

        if(isset($data['id']) && !empty($data['id'])){
            $request_body['query_string'] = $data['id'];
            unset($data['id']);
        }
        $request_body = array_merge($request_body, $data);
        return $this->ScoringEngine->_getRequest($request_body, false);
        
    }

    public function defaultParameters(){
        return [
            'service'   =>  'api/v1/assessment-editions',
        ];
    }
}