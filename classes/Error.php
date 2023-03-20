<?php
namespace Classes;

class Error{
    public function error404(){
        abort('Not found. (404)');
    }
}