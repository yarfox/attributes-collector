<?php

use Yarfox\Attribute\AttributeKeeper;
use Yarfox\Attribute\Test\Handler\ClassAttributeHandler;
use PHPUnit\Framework\TestCase;

class AttributeCollectorTest extends TestCase
{
    public function test()
    {
        AttributeKeeper::bootloader();
        AttributeKeeper::collect();

        $attributes = ClassAttributeHandler::getAttributes();
        $this->assertCount(1, $attributes);
        $this->assertEquals('test', $attributes[0]->getTest());
    }
}
