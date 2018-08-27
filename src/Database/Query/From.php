<?php

namespace Zero\Database\Query;

class From extends AbstractQuery implements QueryInterface {
    
    public function __construct($table, QueryInterface $query = null) {
        $this->setValue($table, $query);
    }

    /**
     * @param $expr
     * @return Where
     */
    public function where($expr)
    {
        return new Where($expr, $this);
    }
    
    protected function getType() {
        return 'FROM';
    }

    protected function parseValue($value)
    {
        return $value;
    }
}