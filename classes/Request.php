<?php

namespace Classes;

class Request {
    
    private $request;

    public function appendInput($param=array()){
        $this->request = array_merge($this->request, $param);
    }

    public function setInput($param){
        $this->request = $param;
    }

    public function getInput($param){
        return $param ? $this->request[$param] : null;
    }

    public function getAll(){
        return $this->request;
    }
}