<?php

use PHPUnit\Framework\TestCase;
use Zero\Database\Query\NamedValueBinder;

class NamedValueBinderTest extends TestCase {

    /**
     * @var NamedValueBinder
     */
    private $valueBinder;
    
    protected function setUp()
    {
        $this->valueBinder = new NamedValueBinder();
    }

    public function test_getPlaceholder_WithoutValues_ReturnsNull() {
        
        $this->assertEquals(null, $this->valueBinder->getPlaceholder('not-exists'));
    }

    public function test_getPlaceholder_WithIntValue_ReturnsStringNamedParam() {
        $this->valueBinder->bind('id', 1);
        $this->assertEquals(':id', $this->valueBinder->getPlaceholder('id'));
    }

    public function test_getPlaceholder_WithSpecialKey_ReturnsUnderscoredNamedParam() {
        $this->valueBinder->bind('Users.id', 1);
        $this->assertEquals(':Users_id', $this->valueBinder->getPlaceholder('Users.id'));
    }
    
    public function test_getPlaceholder_WithArrayValue_ReturnsStringNamedParam() {
        $this->valueBinder->bind('id', [1,2,3]);
        $this->assertEquals('(:id0,:id1,:id2)', $this->valueBinder->getPlaceholder('id'));
    }
    
    public function test_getValue_ReturnsValue() {
        $this->valueBinder->bind('id', 1);
        $this->assertEquals(1, $this->valueBinder->getValue('id'));
    }

    public function test_getValue_WithSpecialKey_ReturnsValue() {
        $this->valueBinder->bind('Users.id', 1);
        $this->assertEquals(1, $this->valueBinder->getValue('Users.id'));
    }
    
    public function test_getValue_WithArrayValue_ReturnsValue() {
        $this->valueBinder->bind('id', [1,2,3]);
        $this->assertEquals(1, $this->valueBinder->getValue('id0'));
        $this->assertEquals(2, $this->valueBinder->getValue('id1'));
        $this->assertEquals(3, $this->valueBinder->getValue('id2'));
        $this->assertEquals(null, $this->valueBinder->getValue('id'));
    }

    public function test_getValue_WithMultipleSameKey_ReturnsValue() {
        $this->valueBinder->bind('id', 1);
        $this->valueBinder->bind('id', 2);
        $this->valueBinder->bind('id', 3);
        $this->assertEquals(1, $this->valueBinder->getValue('id'));
        $this->assertEquals(2, $this->valueBinder->getValue('id_1'));
        $this->assertEquals(3, $this->valueBinder->getValue('id_2'));
        $this->assertEquals(':id_2', $this->valueBinder->getPlaceholder('id_2'));
    }

    public function test_getIterator_WithArrayValue_ReturnsValue() {
        $this->valueBinder->bind('id', [1]);
        $this->valueBinder->bind('name', 'Joe');
        $this->assertEquals(['id0' => 1, 'name' => 'Joe'], iterator_to_array($this->valueBinder));
    }
} 