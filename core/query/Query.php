<?php

namespace core\query;


abstract class Query
{
    private $parameters = [];

    private $where = [];

    public abstract function string($table, $attributes, $where = []);

    public function setWhere($where)
    {
        $this->where = $where;
    }

    /**
     * @param $parameter
     */
    public function addParameter($parameter)
    {
        $this->parameters[] = $parameter;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @return string
     */
    public function getWhere()
    {
        $whereQuery = '';

        foreach ($this->where as $element) {

            $statement = (empty($whereQuery)) ? 'WHERE' : 'AND';

            $whereQuery .= "$statement $element[0] $element[1] ? ";

            $this->addParameter($element[2]);
        }

        return $whereQuery;
    }
}