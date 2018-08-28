<?php

use PHPUnit\Framework\TestCase;
use Zero\Database\Query\Select;

class SelectTest extends TestCase {
    
    public function test_toSql_WithOneField_ReturnsPartOfQuery() {
        $select = new Select('field');
        $this->assertEquals('SELECT field', $select.'');
    }

    public function test_toSql_WithMultipleFields_ReturnsPartOfQuery() {
        $select = new Select(['field1', 'field2']);
        $this->assertEquals('SELECT field1, field2', $select.'');
    }

    public function test_toSql_WithMultipleAliasedFields_ReturnsPartOfQuery() {
        $select = new Select(['f1' => 'field1', 'f2' => 'field2']);
        $this->assertEquals('SELECT field1 AS f1, field2 AS f2', $select.'');
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