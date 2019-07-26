<?php

class Actor
{
    private $connection;
    private $table_name = "actors";

    // properties
    public $id;
    public $first_name;
    public $last_name;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    function insert()
    {
        $query = "INSERT INTO $this->table_name (first_name, last_name)
                  VALUES (:first_name, :last_name);";

        $stmt = $this->connection->prepare($query);

        $stmt->bindParam(':first_name', $this->first_name, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $this->last_name, PDO::PARAM_STR);

        if($stmt->execute()){
            return true;
        }

        return false;
    }
}

