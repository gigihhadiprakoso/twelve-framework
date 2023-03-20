<?php

namespace Classes;

use Classes\App;

class Loader {

    private $app;

    function __construct(){
        
    }

    public function setApp(App $app){
        $this->app = $app;
    }

    public function model($name, $module){

    }

    public function controller($name, $module){

    }

    public function view($name, $data=array()){
        return $name . ".view.php";
    }

    public function routes($module){
        return dirname(__DIR__).'/modules/'.$module.'/routes.php';
    }

    public function config(){

    }

    protected function getDirectoryLoad(){
        $directory_load = array('classes','helpers',);
        foreach($this->app->_config['modules'] as $module){
            if(is_dir(dirname(__DIR__).'/modules/'.$module.'/controllers')) $directory_load[] = 'modules/'.$module.'/controllers';
            if(is_dir(dirname(__DIR__).'/modules/'.$module.'/models')) $directory_load[] = 'modules/'.$module.'/models';
        }

        return $directory_load;
    }

    protected function getFileNotLoad(){
        return array(
            basename(__FILE__), 'App.php',
        );
    }

    public function autoload(){
        foreach($this->getDirectoryLoad() as $dir){
            $path = dirname(__DIR__) . '/'.$dir.'/';
            $files = array_diff(scandir($dir), array('.', '..'));
            foreach($files as $file){
                if(in_array($file,$this->getFileNotLoad())) continue;

                require_once $path.$file;
            }
        }
    }

}