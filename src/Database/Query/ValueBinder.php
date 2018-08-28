<?php

namespace Zero\Database\Query;

class ValueBinder implements \IteratorAggregate {
    private $originalValues = [];
    private $values = [];
    private $params = [];
    
    public function add($key, $value) {
        if(is_array($value)) {
            foreach($value as $k => $v) {
                $this->params[$key][] = ':' . $key . $k;
                $this->values[$key . $k] = $v;
            }
        } else {
            $this->params[$key] = ':' . $key;
            $this->values[$key] = $value;
        }
        $this->originalValues[$key] = $value;
        
        return $this;
    }

    public function getParam($key)
    {
        if(isset($this->params[$key])) {
            $value = $this->params[$key];
            return is_array($value) ? '(' . implode(',', $value) . ')' : ':' . $key;
        }
    }
    
    public function getValue($key)
    {
        $values = $this->values;
        if(isset($values[$key])) {
            return $values[$key];
        }
    }
    
    public function getIterator() {
        foreach($this->values as $key => $value) {
            yield $key => $value;
        }
    }
}