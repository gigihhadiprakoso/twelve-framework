<?php

namespace Classes;

class App {
    public $_uri;
    public $_method;
    public $_endpoint;

    public $_config;
    
    public $route;
    public $loader;

    function __construct(){
        $this->_uri = $_SERVER['REQUEST_URI'];
        $this->_method = $_SERVER['REQUEST_METHOD'];
        $this->_endpoint = isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '/';

        $this->setConfig();

        require_once 'Loader.php';
        $load = new Loader();
        $load->setApp($this);
        $this->loader = $load;
        $this->loader->autoload();
    }

    private function setConfig(){
        $path = dirname(__DIR__) . '/config';
        $files = array_diff(scandir($path), array('.', '..'));
        foreach($files as $file){
            $file_path = $path.'/'.$file;
            $filename = pathinfo($file_path)['filename'];
            $this->_config[$filename] = require_once $file_path;
        }
    }

    public function run(){
        $router = new Route;
        
        foreach($this->_config['modules'] as $module){
            $router->setRouteModule($module);
            require_once $this->loader->routes($module);
        }
        $router->access($this->_method, $this->_endpoint);
    }
}