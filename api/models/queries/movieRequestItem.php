<?php

class MovieRequestItem
{
    private $connection;
    private $table_name = "movies";

    // properties
    public $movie_id;
    public $title;
    public $pc_id;
    public $pc_name;
    public $revenue;
    public $expenses;
    public $profit;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    function getAllDetailsByPcId($pc_id)
    {
        $query = "SELECT m.id as movie_id, m.title as movie_title, m.pc_id, m.revenue as movie_revenue, pc.name as pc_name
                  FROM $this->table_name m
                  JOIN production_companies pc
                    ON pc.id = m.pc_id
                  WHERE pc.id = :id
                  ORDER BY movie_title;";

        $stmt = $this->connection->prepare($query);

        $stmt->bindParam(':id', $pc_id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt;
    }
}

