<?php

class Lines
{
    private $connection;
    private $table_name = "actors";

    // properties
    public $actor_id;
    public $actor_first_name;
    public $actor_last_name;
    public $character_name;
    public $movie_id;
    public $movie_title;
    public $total_lines;
    public $total_words;
    public $total_references;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    function getLinesByCharacter($movieId, $actorId)
    {
        $query = "SELECT a.first_name, a.last_name, ma.actor_id, ma.movie_id, m.title as movie_title, ma.character_name, ma.character_name
                  FROM $this->table_name a
                  JOIN movie_actors ma
                    ON a.id = ma.actor_id
                  JOIN movies m
                    ON m.id = ma.movie_id
                  WHERE m.id = :movie_id AND a.id = :actor_id";

        $stmt = $this->connection->prepare($query);

        $stmt->bindParam(':movie_id', $movieId, PDO::PARAM_INT);
        $stmt->bindParam(':actor_id', $actorId, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt;
    }
}
