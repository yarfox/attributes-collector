<?php
/**
 * The file is part of the attributes-collector.
 *
 * (c) anhoder <anhoder@88.com>.
 *
 * 2022/7/20 23:05
 */

namespace Yarfox\Attribute\Test\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class MethodAttribute
{
    public function __construct(
        public string $foo,
        public string $bar,
    ) {}
}
