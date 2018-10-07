<?php


namespace core;

use core\database\Database;
use core\database\MySql;
use core\query\DeleteQuery;
use core\query\InsertQuery;
use core\query\QueryBuilder;
use core\query\SelectQuery;
use core\query\UpdateQuery;
use model\User;

abstract class Model
{
    /**
     * Selects
     *
     * @var array
     */
    private $select = ['*'];

    /**
     * The table name
     *
     * @var string
     */
    private $table;

    /**
     * The primary key
     *
     * @var string
     */
    private $primaryKey = 'id';

    /**
     * DB connection
     *
     * @var \Database
     */
    private $database;

    /**
     * Protected properties for updating
     *
     * @var array
     */
    protected $protected = [];

    /**
     * @var QueryBuilder
     */
    public $queryBuilder;

    /**
     * Model constructor.
     * Get class name without namespace
     * Get dynamic table name
     */
    public function __construct()
    {

        $classParts = explode('\\', get_class($this));
        $table = strtolower(end($classParts));

        $this->setTable($table);

        $this->setDatabase(new MySql());
        $this->setQueryBuilder(new QueryBuilder(
            $this->select,
            $table
        ));
    }

    /**
     * @param array $select
     */
    public function setSelect($select)
    {
        $this->select = $select;
    }

    /**
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    /**
     * @param string $primaryKey
     */
    public function setPrimaryKey($primaryKey)
    {
        $this->primaryKey = $primaryKey;
    }

    /**
     * @param string $table
     */
    protected function setTable($table)
    {
        if (!empty($table) && is_string($table)) {
            $this->table = strtolower($table);
        }
    }

    /**
     * @return \PDO
     */
    public function getDatabase()
    {
        return $this->database->getConnection();
    }

    /**
     * @param Database $database
     */
    public function setDatabase($database)
    {
        $this->database = $database;
    }

    /**
     * @return QueryBuilder
     */
    public function getQueryBuilder()
    {
        return $this->queryBuilder;
    }

    /**
     * @param QueryBuilder $queryBuilder
     */
    public function setQueryBuilder($queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    public function protectProperties($input)
    {
        return array_diff_key($input, array_flip($this->protected));
    }

    /**
     *
     */
    public function get()
    {
        $builder = $this->getQueryBuilder();
        $builder->setQuery(new SelectQuery());

        $stmt = $this->getDatabase()->prepare($builder->queryString());
        $stmt->execute($builder->getQuery()->getParameters());

        $returnResults = [];

        foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $item) {
            $returnResults[] = $this->map($item);
        }

        return $returnResults;
    }

    /**
     * @param $input
     * Flip array value to key
     * Remove the protected elements
     */
    public function save($input)
    {
        $input = $this->protectProperties($input);

        $builder = $this->getQueryBuilder();
        $builder->setQuery(new InsertQuery());
        $builder->setAttributes($input);

        $this->getDatabase()->prepare($builder->queryString())->execute($builder->getQuery()->getParameters());
    }

    public function update($id, $input)
    {
        $input = $this->protectProperties($input);

        $builder = $this->getQueryBuilder();
        $builder->setQuery(new UpdateQuery());

        $builder->setAttributes($input);
        $builder->where($this->getPrimaryKey(), $id);

        $this->getDatabase()->prepare($builder->queryString())->execute($builder->getQuery()->getParameters());
    }

    public function delete($id)
    {
        $builder = $this->getQueryBuilder();
        $builder->setQuery(new DeleteQuery());
        $builder->where($this->getPrimaryKey(), $id);

        $this->getDatabase()->prepare($builder->queryString())->execute($builder->getQuery()->getParameters());
    }

    /**
     * @return User
     */
    public function first()
    {
        $builder = $this->getQueryBuilder();
        $builder->setQuery(new SelectQuery());

        $stmt = $this->getDatabase()->prepare($builder->queryString());
        $stmt->execute($builder->getQuery()->getParameters());

        $results = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($results) {
            return $this->map($results);
        }

        return null;
    }

    /**
     * @param $arg
     * @return $this
     */
    public function find($arg)
    {
        $builder = $this->getQueryBuilder();
        $builder->setQuery(new SelectQuery());
        $builder->where($this->getPrimaryKey(), $arg);

        $stmt = $this->getDatabase()->prepare($builder->queryString());

        $stmt->execute($builder->getQuery()->getParameters());

        $results = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($results) {
            return $this->map($results);
        }

        return null;
    }

    private function map($item)
    {
        if ($item) {
            $obj = new $this;

            foreach ($item as $attribute => $value) {
                $obj->{"set" . str_replace( '_', '', ucwords($attribute, '_'))}($value);
            }

            return $obj;
        }

        return null;
    }
}