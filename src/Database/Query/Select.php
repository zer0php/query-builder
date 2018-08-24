<?php

namespace Zero\Database\Query;

class Select {
    private $query;
    
    public function __construct($field) {
        $this->query = 'SELECT ' . $field;
    }
    
    public function from($table) {
        return $this->query . ' FROM ' . $table;
    }
}