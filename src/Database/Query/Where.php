<?php

namespace Zero\Database\Query;

class Where extends AbstractQuery {

    public function __construct($expr, QueryInterface $query = null) {
        $this->setValue($expr, $query);
    }

    private function parseArray($field, array $values) {
        $ids = array_map(function($value) use($field) {
            return $field . $value;
        }, array_keys($values));
        return $ids ? ':'.implode(',:', $ids) : '';
    }

    private function parseQuery(QueryInterface $query) {
        return $query->toSql();
    }

    protected function parseValue($value) {
        if(is_array($value)) {
            $query = '';
            foreach($value as $field => $fieldValue) {
                $expr = '= :' . $field;
                if(is_array($fieldValue)) {
                    $expr = 'IN (' . $this->parseArray($field, $fieldValue).')';
                } else if($fieldValue instanceof QueryInterface) {
                    $expr = 'IN (' . $this->parseQuery($fieldValue).')';
                }
                $query .= $field . ' ' . $expr;
            }
            $value = $query;
        }
        return $value;
    }

    protected function getType() {
        return 'WHERE';
    }
}