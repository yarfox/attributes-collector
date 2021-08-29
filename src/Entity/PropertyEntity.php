<?php
/**
 * The file is part of the annotation.
 *
 * (c) alan <alan1766447919@gmail.com>.
 *
 * 2020/12/21 11:09 下午
 */

namespace Anhoder\Annotation\Entity;

use Anhoder\Annotation\Contract\EntityInterface;
use Anhoder\Annotation\Exception\ReflectionErrorException;
use Attribute;
use ReflectionAttribute;
use ReflectionProperty;
use Reflector;

/**
 * Class PropertyAttributeEntity
 * @package Anhoder\Annotation\Entity
 */
class PropertyEntity implements EntityInterface
{
    /**
     * @return ReflectionProperty
     */
    public function getReflection(): ReflectionProperty
    {
        return $this->reflection;
    }
    /**
     * @var ReflectionAttribute[]
     */
    private array $attributes = [];

    /**
     * @var ReflectionProperty
     */
    private ReflectionProperty $reflection;

    /**
     * PropertyAttributeEntity constructor.
     * @param Reflector $reflector
     * @throws ReflectionErrorException
     */
    public function __construct(Reflector $reflector)
    {
        if (!$reflector instanceof ReflectionProperty) {
            throw new ReflectionErrorException($reflector, ReflectionProperty::class);
        }

        $this->reflection = $reflector;
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
        if (Attribute::TARGET_PROPERTY & $attribute->getTarget()) {
            $name = $attribute->getName();
            $this->attributes[$name] = $attribute;
        }
    }
}
