<?php
/**
 * The file is part of the annotation.
 *
 * (c) anhoder <anhoder@88.com>.
 *
 * 2021/1/11 10:24 下午
 */

namespace Anhoder\Annotation\Handler;

use Anhoder\Annotation\Contract\AnnotationHandlerInterface;
use Attribute;
use JetBrains\PhpStorm\ExpectedValues;
use ReflectionAttribute;
use ReflectionClass;

/**
 * Class Handler
 * @package Anhoder\Annotation\Annotation
 */
abstract class Handler implements AnnotationHandlerInterface
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
     * @var ReflectionAttribute
     */
    protected ReflectionAttribute $annotation;

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
    public function setAnnotation(ReflectionAttribute $attribute)
    {
        $this->annotation = $attribute;
    }

    /**
     * @inheritDoc
     */
    abstract public function handle();
}
