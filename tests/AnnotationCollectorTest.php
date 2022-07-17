<?php

use Anhoder\Annotation\AttributeKeeper;
use Anhoder\Annotation\Test\Handler\ClassAttributeHandler;
use PHPUnit\Framework\TestCase;

class AnnotationCollectorTest extends TestCase
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
