<?php

namespace Asm89\PlusMinus;

class ItemTest extends TestCase
{
    private $minusItem;
    private $plusItem;

    public function setUp()
    {
        $this->minusItem  = new Item('asm89', Item::MINUS);
        $this->plusItem = new Item('asm89', Item::PLUS);
    }
    /**
     * @test
     */
    public function it_returns_its_value()
    {
        $this->assertEquals('asm89', $this->minusItem->getValue());
    }

    /**
     * @test
     */
    public function minus_is_minus()
    {
        $this->assertTrue($this->minusItem->isMinus());
    }

    /**
     * @test
     */
    public function minus_is_not_plus()
    {
        $this->assertFalse($this->minusItem->isPlus());
    }

    /**
     * @test
     */
    public function plus_is_not_minus()
    {
        $this->assertFalse($this->plusItem->isMinus());
    }

    /**
     * @test
     */
    public function plus_is_plus()
    {
        $this->assertTrue($this->plusItem->isPlus());
    }
}
