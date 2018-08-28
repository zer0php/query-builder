<?php

namespace Zero\Database\Query;

use IteratorAggregate;

class NamedValueBinder implements IteratorAggregate
{
    /**
     * @var array
     */
    private $bindings = [];

    /**
     * @var array
     */
    private $placeholders = [];

    /**
     * @param $key
     * @param $value
     * @param string $type [optional] default: string
     * @return self
     */
    public function bind($key, $value, $type = 'string')
    {
        $param = str_replace('.', '_', $key);
        $placeholder = ':' . $param;
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $this->placeholders[$key][] = $placeholder . $k;
                $this->setBinding($key . $k, $param . $k, $v, $type);
            }
        } else {
            $this->placeholders[$key] = $placeholder;
            $this->setBinding($key, $param, $value, $type);
        }
        return $this;
    }

    /**
     * @param $key
     * @return string|null
     */
    public function getPlaceholder($key)
    {
        if (!isset($this->placeholders[$key])) {
            return null;
        }

        $placeholder = $this->placeholders[$key];
        return is_array($placeholder) ? '(' . implode(',', $placeholder) . ')' : $placeholder;
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function getValue($key)
    {
        return isset($this->bindings[$key]['value']) ? $this->bindings[$key]['value'] : null;
    }

    /**
     * @return \Generator|\Traversable
     */
    public function getIterator()
    {
        foreach ($this->bindings as $key => $binding) {
            yield $binding['param'] => $binding['value'];
        }
    }

    /**
     * @param $key
     * @param $param
     * @param $value
     * @param string $type [optional] default: string
     */
    private function setBinding($key, $param, $value, $type = 'string')
    {
        $this->bindings[$key] = [
            'param' => $param,
            'value' => $value,
            'type' => $type
        ];
    }
}