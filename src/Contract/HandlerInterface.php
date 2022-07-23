<?php
/**
 * The file is part of the attribute.
 *
 * (c) anhoder <anhoder@88.com>.
 *
 * 2021/1/8 2:05 下午
 */

namespace Yarfox\Attribute\Contract;

use Attribute;
use JetBrains\PhpStorm\ExpectedValues;
use ReflectionClass;
use ReflectionClassConstant;
use ReflectionFunction;
use ReflectionMethod;
use ReflectionParameter;
use ReflectionProperty;

/**
 * Interface AttributeHandlerInterface
 * @package Yarfox\Attribute\Contract
 */
interface HandlerInterface
{
    /**
     * @param int $target value from Attribute::class
     * @return void
     */
    public function setTarget(int $target): void;

    /**
     * @param string $name class name or method name or property name or constant name
     * @return void
     */
    public function setTargetName(string $name): void;

    /**
     * @param ReflectionClass $reflection
     * @return void
     */
    public function setClassReflection(ReflectionClass $reflection): void;

    /**
     * @param ReflectionClassConstant $reflection
     * @return void
     */
    public function setClassConstantReflection(ReflectionClassConstant $reflection): void;

    /**
     * @param ReflectionMethod $reflection
     * @return void
     */
    public function setMethodReflection(ReflectionMethod $reflection): void;

    /**
     * @param ReflectionProperty $reflection
     * @return void
     */
    public function setPropertyReflection(ReflectionProperty $reflection): void;

    /**
     * @param ReflectionFunction $reflection
     * @return void
     */
    public function setFunctionReflection(ReflectionFunction $reflection): void;

    /**
     * @param ReflectionParameter $reflection
     * @return void
     */
    public function setParamReflection(ReflectionParameter $reflection): void;

    /**
     * @param object $attributeObject
     * @return void
     */
    public function setAttribute(object $attributeObject): void;

    /**
     * @return void
     */
    public function handle(): void;
}
