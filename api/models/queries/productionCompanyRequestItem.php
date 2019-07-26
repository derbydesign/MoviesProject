<?php

class ProductionCompanyRequestItem
{
    private $connection;
    private $table_name = "production_companies";

    // properties
    public $pc_id;
    public $pc_name;
    public $total_salary_expenses;
    public $total_revenue_share_expenses;
    public $total_revenue;
    public $total_expenses;
    public $total_profit;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    function getAllDetails()
    {
        $query = "SELECT pc.id as pc_id, pc.name as pc_name, sum(ma.actor_base_salary) as total_salary_expenses, sum(ma.actor_revenue_share * m.revenue) as total_revenue_share_expenses, sum(m.revenue) as total_pc_revenue
                FROM $this->table_name pc
                JOIN movies m
                    ON pc.id = m.pc_id
                JOIN movie_actors ma
                    ON ma.movie_id = m.id
                JOIN actors a
                    ON a.id = ma.actor_id
                GROUP BY pc.id
                ORDER BY pc.name;";

        $stmt = $this->connection->prepare($query);

        $stmt->execute();

        return $stmt;
    }
}

