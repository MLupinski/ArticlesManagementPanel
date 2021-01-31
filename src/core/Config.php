<?php
namespace Src\Core;
use FFI\Exception;

class Config
{
    public $config;

    public function __construct()
    {
        if (file_exists('.config')) {
            $this->config = parse_ini_file('.config');
        } else {
            throw new Exception('Plik konfiguracyjny nie istnieje');
        }    
    }
    public function get(string $key): string
    {
        return $this->config[$key];
    }
}