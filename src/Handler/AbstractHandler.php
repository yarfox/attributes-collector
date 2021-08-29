<?php
/**
 * The file is part of the annotation.
 *
 * (c) anhoder <anhoder@88.com>.
 *
 * 2021/1/11 10:24 下午
 */

namespace Anhoder\Annotation\Handler;

use Anhoder\Annotation\Contract\HandlerInterface;
use Attribute;
use JetBrains\PhpStorm\ExpectedValues;
use ReflectionAttribute;
use ReflectionClass;

/**
 * Class Handler
 * @package Anhoder\Annotation
 */
abstract class AbstractHandler implements HandlerInterface
{
    /**
     * @var int
     */
    protected int $target;

    /**
     * @var string class name or method name or property name or constant name.
     */
    protected string $targetName;

    /**
     * @var ReflectionClass
     */
    protected ReflectionClass $reflectionClass;

    /**
     * @var object
     */
    protected object $attribute;

    /**
     * @inheritDoc
     */
    public function setTarget(#[ExpectedValues(valuesFromClass: Attribute::class)] $target)
    {
        $this->target = $target;
    }

    /**
     * @inheritDoc
     */
    public function setTargetName(string $name)
    {
        $this->targetName = $name;
    }

    /**
     * @inheritDoc
     */
    public function setClassReflection(ReflectionClass $reflection)
    {
        $this->reflectionClass = $reflection;
    }

    /**
     * @inheritDoc
     */
    public function setAttribute(object $attributeObject)
    {
        $this->attribute = $attributeObject;
    }

    /**
     * @inheritDoc
     */
    abstract public function handle();
}
