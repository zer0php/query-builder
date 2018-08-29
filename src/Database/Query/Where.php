<?php

namespace Zero\Database\Query;

class Where extends AbstractQuery
{

    public function __construct($expr, QueryInterface $query = null)
    {
        $this->setValue($expr, $query);
    }

    protected function getType()
    {
        return 'WHERE';
    }

    protected function parseValue($value, ValueBinderInterface $generator)
    {
        if (is_array($value)) {
            $value = $this->parseConditions($value, 'AND', $generator);
        }
        return $value;
    }

    private function parseConditions(array $conditions, $conjugation, ValueBinderInterface $generator)
    {
        $parts = [];
        foreach ($conditions as $field => $fieldValue) {
            $expr = '';
            if ($field === 'OR' || $field === 'AND' || is_int($field)) {
                $parts[] = $this->parseConditions($fieldValue, $field, $generator);
                continue;
            }
            $fieldParts = explode(' ', $field, 2);
            $isArray = false;
            if (count($fieldParts) === 2) {
                $field = $fieldParts[0];
                $expr .= $fieldParts[1] . ' ';
                $isArray = $fieldParts[1] === 'IN';
            } else {
                $expr .= '= ';
            }
            if ($isArray) {
                $expr .= $this->parseArray($field, $fieldValue, $generator);
            } elseif ($fieldValue instanceof QueryInterface) {
                $expr = 'IN (' . $this->parseQuery($fieldValue, $generator) . ')';
            } else {
                $generator->bind($field, $fieldValue);
                $expr .= $generator->getPlaceholder($field);
            }
            $parts[] = $field . ' ' . $expr;
        }

        $part = implode(' ' . $conjugation . ' ', $parts);
        if(count($parts) > 1) {
            $part = '(' . $part . ')';
        }
        return $part;
    }

    private function parseArray($field, array $values, ValueBinderInterface $generator)
    {
        $generator->bind($field, $values);
        return $generator->getPlaceholder($field);
    }

    private function parseQuery(QueryInterface $query, ValueBinderInterface $generator)
    {
        return $query->toSql($generator);
    }
}