<?php
/**
 * The file is part of the attribute.
 *
 * (c) anhoder <anhoder@88.com>.
 *
 * 2021/1/12 8:50 上午
 */

namespace Yarfox\Attribute\Test\Attribute;

use Attribute;
use JetBrains\PhpStorm\ExpectedValues;

#[Attribute(Attribute::TARGET_CLASS)]
class ClassAttribute
{
    public const NAME = 'ClassAttribute';

    public function __construct(
        #[ExpectedValues(valuesFromClass: ClassAttribute::class)] public string $name
    ) {}
}
