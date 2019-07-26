<?php

class Movie
{
    private $connection;
    private $table_name = "movies";

    // properties
    public $id;
    public $title;
    public $pc_id;
    public $revenue;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    function getAll()
    {
        $query = "SELECT id, title, pc_id, revenue FROM $this->table_name ORDER BY title;";

        $stmt = $this->connection->prepare($query);

        $stmt->execute();

        return $stmt;
    }
}

