<?php

namespace Zero\Database\Query;

class Select implements QueryInterface {
    use QueryPartTrait;
    
    public function __construct($fields, QueryInterface $query = null) {
        $this->set($fields, $query);
    }
    
    public function from($table) {
        return new From($table, $this);
    }
    
    protected function getType() {
        return 'SELECT';
    }
}