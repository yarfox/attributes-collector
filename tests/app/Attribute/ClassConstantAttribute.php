<?php
/**
 * The file is part of the attributes-collector.
 *
 * (c) anhoder <anhoder@88.com>.
 *
 * 2022/7/20 23:07
 */

namespace Yarfox\Attribute\Test\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
class ClassConstantAttribute
{
    public function __construct(
        public string $foo
    ) {}
}
