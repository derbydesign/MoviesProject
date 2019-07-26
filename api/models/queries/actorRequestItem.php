<?php

class ActorRequestItem
{
    private $connection;
    private $table_name = "actors";

    // properties
    public $actor_id;
    public $first_name;
    public $last_name;
    public $character_name;
    public $base_salary;
    public $revenue_percentage;
    public $revenue_share;
    public $movie_revenue;
    public $total_earnings;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    function getAllDetailsByMovieId($movie_id)
    {
        $query = "SELECT a.id as actor_id, a.first_name, a.last_name, 
                  ma.actor_base_salary, ma.actor_revenue_share as revenue_share, ma.character_name, m.revenue as movie_revenue
                  FROM $this->table_name a
                  JOIN movie_actors ma
                    ON a.id = ma.actor_id
                  JOIN movies m
                    ON m.id = ma.movie_id
                  WHERE m.id = :movie_id
                  ORDER BY ma.actor_base_salary DESC, a.last_name, a.first_name;";

        $stmt = $this->connection->prepare($query);

        $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt;
    }
}

