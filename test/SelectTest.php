<?php

use PHPUnit\Framework\TestCase;

class SelectTest extends TestCase {
    
    public function test_From_WithTable_ReturnsFullQuery() {
        $select = new \Zero\Database\Query\Select('*');
        $this->assertEquals('SELECT * FROM table', $select->from('table'));
    }
} 