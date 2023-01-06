<?php

namespace App\Resources;

use App\Library\ScoringEngine;

Class Authentication{

    protected $ScoringEngine;

    public function __construct(){
        $this->ScoringEngine = new ScoringEngine();
    }
    /**
     * 
     */
    public function _authenticate($data){
        $errors = [];
        if(!isset($data['login']) || empty($data['login'])){
            $errors["invalid_login"] = "User Name is missing.";
        }

        if(!isset($data['password']) || empty($data['password'])){
            $errors["invalid_password"] = "User Password is missing.";
        }

        $request_body = array_merge($this->defaultParameters(), $data);

        return $this->ScoringEngine->_postRequest($request_body, false);
        
    }

    public function defaultParameters(){
        return [
            'service'   =>  'authentication',
            'strategy'   =>  'local',
        ];
    }
}