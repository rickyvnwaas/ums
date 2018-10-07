<?php

namespace core\query;


use function Couchbase\defaultDecoder;

class InsertQuery extends Query
{
    /**
     * @param $table
     * @param $attributes
     * @param null $where
     * @return string
     * Build insert query
     */
    public function string($table, $attributes, $where = null)
    {
        $query = "INSERT INTO $table";
        $values = [];

        foreach ($attributes as $attribute => $value) {
            $this->addParameter($value);

            $values[] = '?';
        }

        $attributeString = implode(', ', array_keys($attributes));

        $valuesString = implode(', ', $values);

        return "$query ($attributeString) VALUES ($valuesString )";
    }
}