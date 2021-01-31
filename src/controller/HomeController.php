<?php

namespace Src\Controller; 

use Src\Core\View;

class HomeController
{
    public function index()
    {
        return new View('home/index.phtml');
    }
}