<?php

namespace core\query;


class UpdateQuery extends Query
{
    /**
     * @param $table
     * @param $attributes
     * @param array $where
     * @return string
     *
     * Build update query
     */
    public function string($table, $attributes, $where = [])
    {
        $query = "UPDATE $table SET ";

        foreach ($attributes as $attribute => $value) {
            $this->addParameter($value);
            $attributes[$attribute] = "$attribute = ?";
        }

        $attributes = implode(', ', $attributes);
        $query .= rtrim($attributes, ", ");

        $this->setWhere($where);

        $where = $this->getWhere();

        return $query . ' ' . $where;
    }
}