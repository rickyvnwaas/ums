<?php

namespace core\query;


class QueryBuilder
{
    /**
     * @var Query
     */
    private $query;

    /**
     * @var string
     */
    private $whereQuery = [];

    /**
     * @var string
     */
    private $table;

    /**
     * QueryBuilder constructor.
     * @param array $attributes
     * @param string $table
     */
    public function __construct($attributes, $table)
    {
        $this->setAttributes($attributes);
        $this->setTable($table);
    }

    private $attributes = [];

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param string $table
     */
    private function setTable($table)
    {
        $this->table = $table;
    }

    /**
     * @param Query $query
     */
    public function setQuery($query)
    {
        $this->query = $query;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @param string $attribute
     * @param string $value
     * @param string $compare
     */
    public function where($attribute, $value, $compare = '=')
    {
        $this->whereQuery[] = [$attribute, $compare, $value];
    }

    public function getWhere()
    {
        return $this->whereQuery;
    }

    /**
     * @return string
     */
    public function queryString()
    {
        return $this->query->string($this->getTable(), $this->getAttributes(), $this->getWhere());
    }

    /**
     * @return Query
     */
    public function getQuery()
    {
        return $this->query;
    }

}
