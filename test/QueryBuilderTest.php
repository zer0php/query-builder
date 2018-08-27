<?php

use PHPUnit\Framework\TestCase;
use Zero\Database\Query\QueryBuilder;
use Zero\Database\Query\Select;

class QueryBuilderTest extends TestCase {
    
    public function test_Select_ReturnsNewSelectInstance() {
        $query = new QueryBuilder();
        $this->assertInstanceOf(Select::class, $query->select('*'));
    }
} 