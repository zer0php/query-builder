<?php

use PHPUnit\Framework\TestCase;

class FromTest extends TestCase {
    
    public function test_toSql_WithTable_ReturnsPartOfQuery() {
        $from = new \Zero\Database\Query\From('sample_table');
        $this->assertEquals('FROM sample_table', $from->toSql());
    }
} 