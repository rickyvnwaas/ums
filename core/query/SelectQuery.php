<?php

namespace core\query;


class SelectQuery extends Query
{
    /**
     * @param $table
     * @param $attributes
     * @param array $where
     * @return string
     *
     * Build select
     */
    public function string($table, $attributes, $where = [])
    {
        if (is_array($attributes)) {
            $attributes = implode(',', $attributes);

            $attributes = rtrim($attributes,", ");
        }

        $this->setWhere($where);

        $where = $this->getWhere();

        return "SELECT $attributes FROM $table $where";
    }
}