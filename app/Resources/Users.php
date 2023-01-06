<?php

namespace App\Resources;

use App\Library\ScoringEngine;

Class Users{

    protected $ScoringEngine;

    public function __construct(){
        $this->ScoringEngine = new ScoringEngine();
    }
    /**
     * 
     */
    public function _getUsers($data = []){
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
    public function _createUsers($data = []){
        $errors = [];     

        $request_body = $this->defaultParameters();

        /*if(isset($data['id']) && !empty($data['id'])){
            $request_body['query_string'] = $data['id'];
            unset($data['id']);
        }*/
        
        $request_body = array_merge($request_body, $data);
        return $this->ScoringEngine->_postRequest($request_body, true);
        
    }

    /**
     * 
     */
    public function _updateUsers($data = []){
        $errors = [];     

        $request_body = $this->defaultParameters();

        if(isset($data['id']) && !empty($data['id'])){
            $request_body['query_string'] = $data['id'];
            unset($data['id']);
        }
        $request_body = array_merge($request_body, $data);
        return $this->ScoringEngine->_putRequest($request_body, true);
        
    }

    public function defaultParameters(){
        return [
            'service'   =>  'api/v1/users',
        ];
    }
}