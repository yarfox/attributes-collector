<?php
/**
 * The file is part of the attributes-collector.
 *
 * (c) anhoder <anhoder@88.com>.
 *
 * 2022/7/20 23:03
 */

namespace Yarfox\Attribute\Test\Handler;

use Yarfox\Attribute\Attribute\AttributeHandler;
use Yarfox\Attribute\Handler\AbstractHandler;
use Yarfox\Attribute\Test\Attribute\ClassConstantAttribute;
use Yarfox\Attribute\Test\Attribute\FunctionAttribute;
use Yarfox\Attribute\Test\Attribute\MethodAttribute;
use Yarfox\Attribute\Test\Attribute\PropertyAttribute;

#[AttributeHandler(ClassConstantAttribute::class)]
class ClassConstantAttributeHandler extends AbstractHandler
{
    public function handle(): void
    {
        /** @var ClassConstantAttribute $attribute */
        $attribute = $this->attribute;
        var_dump($attribute->foo);
    }
}
