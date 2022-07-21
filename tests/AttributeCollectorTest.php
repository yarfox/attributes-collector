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
        echo PHP_EOL, PHP_EOL, PHP_EOL;
        AttributeKeeper::bootloader();

        /** @var ConfigCollector $collector */
        $collector = Container::getInstance(ConfigCollector::class);

        // Inject fake data
        Closure::bind(function () use ($collector) {
            $collector->configs['Yarfox\\Attribute\\Test\\'] = [
                'scanDirs' => [
                    'Yarfox\\Attribute\\Test' => realpath(__DIR__ . '/app'),
                ],
                'functions' => [
                    '\Yarfox\Attribute\Test\foo'
                ],
            ];
        }, null, ConfigCollector::class)();
        AttributeKeeper::collect();

        $attributes = ClassAttributeHandler::getAttributes();
        $this->assertCount(1, $attributes);
        $this->assertEquals('ClassAttribute', $attributes[0]->name);
    }
}
