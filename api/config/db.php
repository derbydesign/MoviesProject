<?php

class DB
{
    private $host = "localhost";
    private $port = '3306';
    private $username = "root";
    private $password = "root";
    private $database = "movies_project";

    public $connection;

    public function getConnection($has_db = true){

        $this->connection = null;

        if ($has_db) {
            $db_str = 'dbname=' . $this->database;
        } else {
            $db_str = '';
        }

        try{
            $this->connection = new PDO("mysql:host=" . $this->host . ";port=" . $this->port . ";" . $db_str, $this->username, $this->password);
            $this->connection->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Error: " . $exception->getMessage();
        }

        return $this->connection;
    }
}
