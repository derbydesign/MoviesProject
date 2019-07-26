<?php

class ProductionCompany
{
    private $connection;
    private $table_name = "production_companies";

    // properties
    private $id;
    private $name;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }
}

