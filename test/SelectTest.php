<?php

use PHPUnit\Framework\TestCase;

class SelectTest extends TestCase {
    
    public function test_toSql_WithTable_ReturnsPartOfQuery() {
        $select = new \Zero\Database\Query\Select('field');
        $this->assertEquals('SELECT field', $select->toSql());
    }
    
    public function test_From_WithAllFieldAndTable_ReturnsFullQuery() {
        $select = new \Zero\Database\Query\Select('*');
        $this->assertEquals('SELECT * FROM table', $select->from('table')->toSql());
    }
} 