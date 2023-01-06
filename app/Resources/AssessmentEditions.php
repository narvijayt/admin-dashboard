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
    public function _getAssessmentEditions($id = ''){
        $errors = [];     

        $request_body = $this->defaultParameters();

        if(!empty($id)){
            $request_body['query_string'] = $id;
        }
        return $this->ScoringEngine->_getRequest($request_body, false);
        
    }

    public function defaultParameters(){
        return [
            'service'   =>  'api/v1/assessment-editions',
        ];
    }
}