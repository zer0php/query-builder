<?php

namespace Zero\Database\Query;

/**
 * Class AbstractQuery
 * @package Zero\Database\Query
 */
abstract class AbstractQuery implements QueryInterface
{
    /**
     * @var QueryInterface
     */
    private $prevQuery;

    /**
     * @var mixed
     */
    private $value;

    abstract protected function getType();

    abstract protected function parseValue($value, ValueBinder $generator);

    protected function setValue($value, QueryInterface $prevQuery = null) {
        $this->value = $value;
        $this->prevQuery = $prevQuery;
    }

    public function toSql(ValueBinder $generator) {
        $query = '';
        if($this->prevQuery) {
            $query .= $this->prevQuery->toSql($generator) . ' ';
        }
        $query .= $this->getType() . ' ' . $this->parseValue($this->value, $generator);
        return $query;
    }

    public function __toString() {
        return $this->toSql(new ValueBinder());
    }
}