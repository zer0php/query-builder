<?php

namespace Zero\Database\Query;

trait QueryPartTrait {
    private $prevQuery;
    private $value;
    
    abstract protected function getType();
    
    private function set($value, QueryInterface $prevQuery = null) {
        $this->value = $value;
        $this->prevQuery = $prevQuery;
    }
    
    public function toSql() {
        $query = '';
        if($this->prevQuery) {
            $query .= $this->prevQuery->toSql() . ' ';
        }
        $query .= $this->getType() . ' ' . $this->value;
        return $query;
    }
    
    public function __toString() {
        return $this->toSql();
    }
}