<?php

use PHPUnit\Framework\TestCase;
use Zero\Database\Query\From;

class FromTest extends TestCase {
    
    public function test_toSql_WithTable_ReturnsPartOfQuery() {
        $from = new From('sample_table');
        $this->assertEquals('FROM sample_table', $from.'');
    }
} 