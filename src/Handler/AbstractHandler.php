<?php
/**
 * The file is part of the attribute.
 *
 * (c) anhoder <anhoder@88.com>.
 *
 * 2021/1/11 10:24 下午
 */

namespace Yarfox\Attribute\Handler;

use Yarfox\Attribute\Contract\HandlerInterface;
use Attribute;
use JetBrains\PhpStorm\ExpectedValues;
use ReflectionAttribute;
use ReflectionClass;

/**
 * Class Handler
 * @package Yarfox\Attribute
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
    public function setTarget(#[ExpectedValues(valuesFromClass: Attribute::class)] $target): void
    {
        $this->target = $target;
    }

    /**
     * @inheritDoc
     */
    public function setTargetName(string $name): void
    {
        $this->targetName = $name;
    }

    /**
     * @inheritDoc
     */
    public function setClassReflection(ReflectionClass $reflection): void
    {
        $this->reflectionClass = $reflection;
    }

    /**
     * @inheritDoc
     */
    public function setAttribute(object $attributeObject): void
    {
        $this->attribute = $attributeObject;
    }

    /**
     * @inheritDoc
     */
    abstract public function handle(): void;
}
