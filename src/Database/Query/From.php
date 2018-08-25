<?php

namespace Zero\Database\Query;

class From implements QueryInterface {
    use QueryPartTrait;
    
    public function __construct($table, QueryInterface $query = null) {
        $this->set($table, $query);
    }
    
    protected function getType() {
        return 'FROM';
    }
}