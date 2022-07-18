<?php

use Yarfox\Attribute\AttributeKeeper;
use Yarfox\Attribute\ConfigCollector;
use Yarfox\Attribute\Test\Handler\ClassAttributeHandler;
use PHPUnit\Framework\TestCase;
use Yarfox\Container\Facade\Container;

class AttributeCollectorTest extends TestCase
{
    public function test()
    {
        AttributeKeeper::bootloader();

        /** @var ConfigCollector $collector */
        $collector = Container::getInstance(ConfigCollector::class);

        // Inject fake data
        Closure::bind(function () use ($collector) {
            $collector->configs['Yarfox\\Attribute\\Test\\'] = [
                'scanDirs' => [
                    'Yarfox\\Attribute\\Test' => realpath(__DIR__ . '/app'),
                ]
            ];
        }, null, ConfigCollector::class)();
        AttributeKeeper::collect();

        $attributes = ClassAttributeHandler::getAttributes();
        $this->assertCount(1, $attributes);
        $this->assertEquals('test', $attributes[0]->getTest());
    }
}
