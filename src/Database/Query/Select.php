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

    protected function parseValue($value, NamedValueBinder $generator)
    {
        if(is_array($value)) {
            $value = implode(', ', $value);
        }
        return $value;
    }
}