<?php
/**
 * The file is part of the annotation.
 *
 * (c) anhoder <anhoder@88.com>.
 *
 * 2021/1/8 2:05 下午
 */

namespace Anhoder\Annotation\Contract;

use Attribute;
use JetBrains\PhpStorm\ExpectedValues;
use ReflectionClass;

/**
 * Interface AttributeHandlerInterface
 * @package Anhoder\Annotation\Contract
 */
interface HandlerInterface
{
    /**
     * @param int $target
     * @return void
     */
    public function setTarget(#[ExpectedValues(valuesFromClass: Attribute::class)] int $target);

    /**
     * @param string $name class name or method name or property name or constant name
     * @return void
     */
    public function setTargetName(string $name);

    /**
     * @param ReflectionClass $reflection
     * @return void
     */
    public function setClassReflection(ReflectionClass $reflection);

    /**
     * @param object $attributeObject
     * @return void
     */
    public function setAttribute(object $attributeObject);

    /**
     * @return void
     */
    public function handle();
}
