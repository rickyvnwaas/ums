<?php

namespace core\database;

use PDO;

abstract class Database
{
    /**
     * @var PDO
     */
    private $connection;

    public function __construct($database, $host, $port, $dbName, $username, $password)
    {
        $this->setConnection(new PDO("$database:host=$host;port=$port;dbname=$dbName", $username, $password));
    }

    /**
     * @return PDO
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param PDO $connection
     */
    private function setConnection($connection)
    {
        $this->connection = $connection;
    }
}