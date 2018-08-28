<?php

namespace Zero\Database\Query;

class Where extends AbstractQuery {

    public function __construct($expr, QueryInterface $query = null) {
        $this->setValue($expr, $query);
    }

    private function parseArray($field, array $values, NamedValueBinder $generator) {
        $generator->bind($field, $values);
        return $generator->getPlaceholder($field);
    }

    private function parseQuery(QueryInterface $query, NamedValueBinder $generator) {
        return $query->toSql($generator);
    }

    protected function parseValue($value, NamedValueBinder $generator) {
        if(is_array($value)) {
            $conditions = [];
            foreach($value as $field => $fieldValue) {
                $expr = '';
                $fieldParts = explode(' ', $field, 2);
                if(count($fieldParts) === 2) {
                    $field = $fieldParts[0];
                    $expr .= $fieldParts[1] . ' ';
                } else {
                    $expr .= '= ';
                }
                if(is_array($fieldValue)) {
                    $expr = 'IN ' . $this->parseArray($field, $fieldValue, $generator);
                } else if($fieldValue instanceof QueryInterface) {
                    $expr = 'IN (' . $this->parseQuery($fieldValue, $generator).')';
                } else {
                    $generator->bind($field, $fieldValue);
                    $expr .= $generator->getPlaceholder($field);
                }
                $conditions[] = $field . ' ' . $expr;
            }
            $value = implode(' AND ', $conditions);
        }
        return $value;
    }

    protected function getType() {
        return 'WHERE';
    }
}