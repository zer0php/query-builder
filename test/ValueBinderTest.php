<?php

use PHPUnit\Framework\TestCase;
use Zero\Database\Query\ValueBinder;

class ValueBinderTest extends TestCase {
    
    public function test_getParam_WithIntValue_ReturnsStringNamedParam() {
        $valueBinder = new ValueBinder();
        $valueBinder->add('id', 1);
        $this->assertEquals(':id', $valueBinder->getParam('id'));
    }
    
    public function test_getParam_WithArrayValue_ReturnsStringNamedParam() {
        $valueBinder = new ValueBinder();
        $valueBinder->add('id', [1,2,3]);
        $this->assertEquals('(:id0,:id1,:id2)', $valueBinder->getParam('id'));
    }
    
    public function test_getValue_ReturnsValue() {
        $valueBinder = new ValueBinder();
        $valueBinder->add('id', 1);
        $this->assertEquals(1, $valueBinder->getValue('id'));
    }
    
    public function test_getValue_WithArrayValue_ReturnsValue() {
        $valueBinder = new ValueBinder();
        $valueBinder->add('id', [1,2,3]);
        $this->assertEquals(1, $valueBinder->getValue('id0'));
        $this->assertEquals(2, $valueBinder->getValue('id1'));
        $this->assertEquals(3, $valueBinder->getValue('id2'));
        $this->assertEquals(null, $valueBinder->getValue('id'));
    }
    
    public function test_getIterator_WithArrayValue_ReturnsValue() {
        $valueBinder = new ValueBinder();
        $valueBinder->add('id', [1]);
        $valueBinder->add('name', 'Joe');
        $this->assertEquals(['id0' => 1, 'name' => 'Joe'], iterator_to_array($valueBinder));
    }
} 