<?php

class MovieActor
{
    private $connection;
    private $table_name = "movie_actors";

    // properties
    public $movie_id;
    public $actor_id;
    public $character_name;
    public $base_salary;
    public $revenue_share;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    function insert()
    {
        $query = "INSERT INTO $this->table_name (movie_id, actor_id, character_name, actor_base_salary, actor_revenue_share)
                  VALUES (:movie_id, :actor_id, :character_name, :base_salary, :revenue_share);";

        $stmt = $this->connection->prepare($query);

        $stmt->bindParam(':movie_id', $this->movie_id, PDO::PARAM_INT);
        $stmt->bindParam(':actor_id', $this->actor_id, PDO::PARAM_INT);
        $stmt->bindParam(':character_name', $this->character_name, PDO::PARAM_STR);
        $stmt->bindParam(':base_salary', $this->base_salary, PDO::PARAM_STR);
        $stmt->bindParam(':revenue_share', $this->revenue_share, PDO::PARAM_STR);

        if($stmt->execute()){
            return true;
        }

        return false;
    }
}

