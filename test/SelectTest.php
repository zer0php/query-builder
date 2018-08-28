<?php

use PHPUnit\Framework\TestCase;
use Zero\Database\Query\Select;

class SelectTest extends TestCase {
    
    public function test_toSql_WithOneField_ReturnsPartOfQuery() {
        $select = new Select('field');
        $this->assertEquals('SELECT field', $select.'');
    }

    public function test_toSql_WithMultipleField_ReturnsPartOfQuery() {
        $select = new Select(['field1', 'field2']);
        $this->assertEquals('SELECT field1, field2', $select.'');
    }
    
    public function test_From_WithAllFieldAndTable_ReturnsFullQuery() {
        $select = new Select('*');
        $this->assertEquals('SELECT * FROM table', $select->from('table').'');
    }

    public function test_From_WithAllFieldAndTableAndWhere_ReturnsFullQuery() {
        $select = new Select('*');
        $this->assertEquals('SELECT * FROM table WHERE id = :id', $select->from('table')->where(['id' => 1]).'');
    }
} 