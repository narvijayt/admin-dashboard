<?php

namespace App\Resources;

use App\Library\ScoringEngine;

Class Batch{

    protected $ScoringEngine;

    public function __construct(){
        $this->ScoringEngine = new ScoringEngine();
    }
    /**
     * 
     */
    public function _batchRequest($data = []){
        if(!isset($data['calls']) || empty($data['calls']))
            return false;

        $data['service'] = 'batch';
        return $this->ScoringEngine->_batchRequest($data, false);
    }
}