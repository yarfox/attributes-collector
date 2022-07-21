<?php
/**
 * The file is part of the attributes-collector.
 *
 * (c) anhoder <anhoder@88.com>.
 *
 * 2022/7/20 23:01
 */

namespace Yarfox\Attribute\Test\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_FUNCTION)]
class FunctionAttribute
{
    public function __construct(
        public string $foo,
        public int $bar
    ) {}
}
