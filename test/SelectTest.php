<?php

use PHPUnit\Framework\TestCase;
use Zero\Database\Query\Select;

class SelectTest extends TestCase {
    
    public function test_toSql_WithTable_ReturnsPartOfQuery() {
        $select = new Select('field');
        $this->assertEquals('SELECT field', $select->toSql());
    }
    
    public function test_From_WithAllFieldAndTable_ReturnsFullQuery() {
        $select = new Select('*');
        $this->assertEquals('SELECT * FROM table', $select->from('table').'');
    }
} 