<?php

require 'db.php';

class Install
{
    public function dbCreate()
    {
        try {
            $db = new DB();
            $connection = $db->getConnection(false);
            $sql = file_get_contents("sql/db-create.sql", FILE_USE_INCLUDE_PATH);
            $connection->exec($sql);
            echo "<p>Database and tables created successfully!</p>";
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function dbReset()
    {
        try {
            $db = new DB();
            $connection = $db->getConnection();
            $sql = file_get_contents("sql/db-reset.sql", FILE_USE_INCLUDE_PATH);
            $connection->exec($sql);
            echo "<p>Database data reset to test data!</p>";
            echo '<a href="/MoviesProject">Start App</a>';
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}


