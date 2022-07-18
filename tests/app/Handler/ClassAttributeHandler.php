<?php
/**
 * The file is part of the attribute.
 *
 * (c) anhoder <anhoder@88.com>.
 *
 * 2021/1/12 8:52 上午
 */

namespace Yarfox\Attribute\Test\Handler;

use Yarfox\Attribute\Attribute\AttributeHandler;
use Yarfox\Attribute\Handler\AbstractHandler;
use Yarfox\Attribute\Test\Attribute\ClassAttribute;

#[AttributeHandler(ClassAttribute::class)]
class ClassAttributeHandler extends AbstractHandler
{
    /**
     * @var array<ClassAttribute>
     */
    private static array $attributes = [];

    public static function getAttributes(): array
    {
        return self::$attributes;
    }

    public function handle(): void
    {
        $attribute = $this->attribute;
        var_dump($attribute->getTest());
        self::$attributes[] = $attribute;
    }
}
