<?php
/**
 * The file is part of the attribute.
 *
 * (c) anhoder <anhoder@88.com>.
 *
 * 2021/1/11 10:24 下午
 */

namespace Yarfox\Attribute\Handler;

use ReflectionFunction;
use ReflectionMethod;
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
     * @var ?ReflectionClass
     */
    protected ?ReflectionClass $reflectionClass;

    /**
     * @var ?ReflectionMethod
     */
    protected ?ReflectionMethod $reflectionMethod = null;

    /**
     * @var ?ReflectionFunction
     */
    protected ?ReflectionFunction $reflectionFunction = null;

    /**
     * @var object
     */
    protected object $attribute;

    /**
     * @inheritDoc
     */
    public function setTarget($target): void
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
    public function setMethodReflection(ReflectionMethod $reflection): void
    {
        $this->reflectionMethod = $reflection;
    }

    /**
     * @inheritDoc
     */
    public function setFunctionReflection(ReflectionFunction $reflection): void
    {
        $this->reflectionFunction = $reflection;
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
