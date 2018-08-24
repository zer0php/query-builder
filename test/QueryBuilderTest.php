<?php

use PHPUnit\Framework\TestCase;

class QueryBuilderTest extends TestCase {
    
    public function test_Select_ReturnsNewSelectInstance() {
        $query = new \Zero\Database\Query\QueryBuilder();
        $this->assertInstanceOf(\Zero\Database\Query\Select::class, $query->select('*'));
    }
} 