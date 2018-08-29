<?php

use PHPUnit\Framework\TestCase;
use Zero\Database\Query\Select;
use Zero\Database\Query\Where;

class WhereTest extends TestCase
{

    public function test_toSql_WithArrayData_ReturnsPreparedPartOfQuery()
    {
        $where = new Where(['id' => 1]);
        $this->assertEquals('WHERE id = :id', $where . '');
    }

    public function test_toSql_WithQueryArrayData_ReturnsPreparedPartOfQuery()
    {
        $selectQuery = new Select('*');
        $where = new Where(['id' => $selectQuery->from('table')->where(['id' => 1])]);
        $this->assertEquals('WHERE id IN (SELECT * FROM table WHERE id = :id)', $where . '');
    }

    public function test_toSql_WithArrayValueData_ReturnsPreparedPartOfQuery()
    {
        $where = new Where(['id IN' => [1, 2, 3]]);
        $this->assertEquals('WHERE id IN (:id0,:id1,:id2)', $where . '');
    }

    public function test_toSql_WithLikeArrayData_ReturnsPreparedPartOfQuery()
    {
        $where = new Where(['id LIKE' => '%1%']);
        $this->assertEquals('WHERE id LIKE :id', $where . '');
    }

    public function test_toSql_WithMultipleCondition_ReturnsPreparedPartOfQuery()
    {
        $where = new Where(['name LIKE' => '%Joe%', 'age >' => 15, 'active' => 1]);
        $this->assertEquals('WHERE (name LIKE :name AND age > :age AND active = :active)', $where . '');
    }

    public function test_toSql_WithOrCondition_ReturnsPreparedPartOfQuery()
    {
        $where = new Where(['OR' => ['name' => 'Joe', 'age <' => 15]]);
        $this->assertEquals('WHERE (name = :name OR age < :age)', $where . '');
    }

    public function test_toSql_WithComplexCondition_ReturnsPreparedPartOfQuery()
    {
        $where = new Where([
            [
                'OR' => [
                    'name' => 'Joe',
                    'age <' => 15
                ]
            ],
            [
                'OR' => [
                    'active' => true,
                    'age >' => 15
                ]
            ]
        ]);
        $this->assertEquals('WHERE ((name = :name OR age < :age) AND (active = :active OR age > :age))', $where . '');
    }
} 