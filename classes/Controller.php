<?php

namespace Classes;

use Classes\Loader;

class Controller {
    protected $model;
    private $load;

    public function __construct(){
        $this->load = new Loader();


    }

    protected function setRecord(){

    }

    protected function response($data = array()){
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

    protected function view($filename_view, $data=array()){
        list($dir, $module) = $this->getModuleClass();
        $path_view = getcwd()."/".strtolower($dir)."/".strtolower($module)."/views/".$filename_view;

        require_once $this->load->view($path_view, $data);
    }

    private function getModuleClass(){
        $classname = get_class($this);
        return explode("\\",$classname);
    }
}