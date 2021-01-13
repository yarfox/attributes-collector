<?php
/**
 * The file is part of the annotation.
 *
 * (c) anhoder <anhoder@88.com>.
 *
 * 2021/1/12 8:50 上午
 */

namespace Anhoder\Annotation\Test\Annotation;

use Attribute;
use JetBrains\PhpStorm\ExpectedValues;

#[Attribute(Attribute::TARGET_CLASS)]
class ClassAnnotation
{
    public const TEST = 'test';

    private string $test;

    public function __construct(#[ExpectedValues(valuesFromClass: ClassAnnotation::class)] string $test)
    {
        $this->test = $test;
    }
}
