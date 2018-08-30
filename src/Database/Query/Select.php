<?php

namespace Zero\Database\Query;

class Select extends AbstractQuery implements QueryInterface {
    
    public function __construct($fields, QueryInterface $query = null) {
        $this->setValue($fields, $query);
    }
    
    public function from($table) {
        return new From($table, $this);
    }
    
    protected function getType() {
        return 'SELECT';
    }

    protected function parseValue($value, ValueBinderInterface $generator)
    {
        if(is_array($value)) {
            $fields = [];
            foreach($value as $alias => $field) {
                $fields[] = $field . (!is_int($alias) ? ' AS ' . $alias : '');
            }
            $value = implode(', ', $fields);
        }
        return $value;
    }
}