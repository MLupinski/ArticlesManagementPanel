<?php

namespace Src\Model;

use PDO;

class HomeModel
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;    
    }
}