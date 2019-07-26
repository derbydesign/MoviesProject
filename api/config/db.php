<?php

class DB
{
    private $host = "localhost";
    private $port = '3306';
    private $username = "root";
    private $password = "root";
    private $database = "movies_project";

    public $connection;

    public function getConnection(){

        $this->connection = null;

        try{
            $this->connection = new PDO("mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->database, $this->username, $this->password);
            $this->connection->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Error: " . $exception->getMessage();
        }

        return $this->connection;
    }
}
