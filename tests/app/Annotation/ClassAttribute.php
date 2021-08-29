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
class ClassAttribute
{
    public const TEST = 'test';

    private string $test;

    public function __construct(#[ExpectedValues(valuesFromClass: ClassAttribute::class)] string $test)
    {
        $this->test = $test;
    }

    public function getTest(): string
    {
        return $this->test;
    }
}
