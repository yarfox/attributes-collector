<?php
/**
 * The file is part of the annotation.
 *
 * (c) alan <alan1766447919@gmail.com>.
 *
 * 2020/12/21 11:10 下午
 */

namespace Anhoder\Annotation\Entity;

use Anhoder\Annotation\Contract\EntityInterface;
use Anhoder\Annotation\Exception\ReflectionErrorException;
use Attribute;
use ReflectionAttribute;
use ReflectionMethod;
use Reflector;

/**
 * Class MethodAttributeEntity
 * @package Anhoder\Annotation\Entity
 */
class MethodEntity implements EntityInterface
{
    /**
     * @var ReflectionAttribute[]
     */
    private array $attributes = [];

    /**
     * @var ReflectionMethod
     */
    private ReflectionMethod $reflection;

    /**
     * MethodAttributeEntity constructor.
     * @param Reflector $reflector
     * @throws ReflectionErrorException
     */
    public function __construct(Reflector $reflector)
    {
        if (!$reflector instanceof ReflectionMethod) {
            throw new ReflectionErrorException($reflector, ReflectionMethod::class);
        }

        $this->reflection = $reflector;
    }

    /**
     * @return ReflectionMethod
     */
    public function getReflection(): ReflectionMethod
    {
        return $this->reflection;
    }

    /**
     * @inheritDoc
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param \ReflectionAttribute $attribute
     */
    public function registerAttribute(ReflectionAttribute $attribute)
    {
        if (Attribute::TARGET_METHOD & $attribute->getTarget()) {
            $name = $attribute->getName();
            $this->attributes[$name] = $attribute;
        }
    }
}
