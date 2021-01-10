<?php
/**
 *  * The file is part of the annotation.
 *
 * (c) anhoder <anhoder@88.com>.
 *
 * 2021/1/8 2:05 下午
 */

namespace Anhoder\Annotation\Contract;

use Attribute;
use JetBrains\PhpStorm\ExpectedValues;
use ReflectionClass;
use Reflector;

/**
 * Interface HandlerInterface
 * @package Anhoder\Annotation\Contract
 */
interface AnnotationHandlerInterface
{
    /**
     * @param $target
     * @return mixed
     */
    public function setTarget(#[ExpectedValues(valuesFromClass: Attribute::class)] $target);

    /**
     * @param string $name class name or method name or property name or constant name
     * @return mixed
     */
    public function setTargetName(string $name);

    /**
     * @param ReflectionClass $reflection
     * @return mixed
     */
    public function setClassReflection(ReflectionClass $reflection);

    /**
     * @param object $attribute
     * @return mixed
     */
    public function setAnnotation(object $attribute);

    /**
     * @return mixed
     */
    public function handler();
}
