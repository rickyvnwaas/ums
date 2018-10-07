<?php

namespace core\query;


class DeleteQuery extends Query
{
    /**
     * @param $table
     * @param $attributes
     * @param array $where
     * @return string
     * Build delete query
     */
    public function string($table, $attributes, $where = [])
    {
        $this->setWhere($where);

        $where = $this->getWhere();

        return "DELETE FROM $table $where";
    }
}