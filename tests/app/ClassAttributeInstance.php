<?php
/**
 * The file is part of the attribute.
 *
 * (c) anhoder <anhoder@88.com>.
 *
 * 2021/1/13 1:15 下午
 */

namespace Yarfox\Attribute\Test;

use Yarfox\Attribute\Test\Attribute\ClassAttribute;
use Yarfox\Attribute\Test\Attribute\ClassConstantAttribute;
use Yarfox\Attribute\Test\Attribute\FunctionAttribute;
use Yarfox\Attribute\Test\Attribute\MethodAttribute;
use Yarfox\Attribute\Test\Attribute\MethodParamAttribute;
use Yarfox\Attribute\Test\Attribute\PropertyAttribute;

#[ClassAttribute(ClassAttribute::NAME)]
class ClassAttributeInstance
{
    #[ClassConstantAttribute('This is ClassConstantAttribute')]
    const FOO = 'foo';

    #[PropertyAttribute('This is PropertyAttribute')]
    private string $foo;

    #[MethodAttribute('This is MethodAttribute(foo)', 'foo')]
    public function foo(#[MethodParamAttribute('This is ParamAttribute(foo)')]string $foo): void
    {

    }

    #[MethodAttribute('This is MethodAttribute(bar)', 'bar')]
    public function bar(#[MethodParamAttribute('This is ParamAttribute(bar)')]string $bar): void
    {

    }
}

#[FunctionAttribute('This is FunctionAttribute', 2)]
function foo(): void
{

}
