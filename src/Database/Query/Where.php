<?php

namespace Zero\Database\Query;

class Where extends AbstractQuery {

    public function __construct($expr, QueryInterface $query = null) {
        $this->setValue($expr, $query);
    }

    private function parseArray($field, array $values, ValueBinder $generator) {
        $generator->add($field, $values);
        return $generator->getParam($field);
    }

    private function parseQuery(QueryInterface $query, ValueBinder $generator) {
        return $query->toSql($generator);
    }

    protected function parseValue($value, ValueBinder $generator) {
        if(is_array($value)) {
            $query = '';
            foreach($value as $field => $fieldValue) {
                $expr = '';
                $fieldParts = explode(' ', $field, 2);
                if(count($fieldParts) === 2) {
                    $field = $fieldParts[0];
                    $expr .= $fieldParts[1] . ' ';
                } else {
                    $expr .= '= ';
                }
                $expr .= ':' . $field;
                if(is_array($fieldValue)) {
                    $expr = 'IN ' . $this->parseArray($field, $fieldValue, $generator);
                } else if($fieldValue instanceof QueryInterface) {
                    $expr = 'IN (' . $this->parseQuery($fieldValue, $generator).')';
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