<?php

namespace Modules\Web\Controllers;

use Classes\Controller;

class WelcomeController extends Controller{

    public function show(){
        $this->view('welcome',['time'=>date('Y-m-d')]);
    }
}