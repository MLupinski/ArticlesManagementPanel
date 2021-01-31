<?php

namespace Src\Core;
use PDO;
use FFI\Exception;
use PDOException;

class Database
{
    protected $connection;
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function openConnection()
    {
        try {
            $this->connection = new PDO(
                "mysql:host={$this->config->config['server']};
                dbname={$this->config->config['database']};charset=utf8",
                $this->config->config['user'],
                $this->config->config['password']
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $this->connection;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function closeConnection()
    {
        $this->connection = null;
    }
}