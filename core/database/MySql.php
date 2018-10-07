<?php

namespace core\database;

use config\DatabaseConstants;
use core\database\Database;

class MySql extends Database
{
    public function __construct()
    {
        parent::__construct(
            'mysql',
            DatabaseConstants::MYSQL_HOST,
            DatabaseConstants::MYSQL_PORT,
            DatabaseConstants::MYSQL_DB_NAME,
            DatabaseConstants::MYSQL_USERNAME,
            DatabaseConstants::MYSQL_PASSWORD
        );
    }
}