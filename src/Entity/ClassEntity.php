<?php
/**
 * The file is part of the attribute.
 *
 * (c) alan <anhoder@88.com>.
 *
 * 2020/12/21 11:04 下午
 */

namespace Yarfox\Attribute\Entity;

use Yarfox\Attribute\Contract\EntityInterface;
use Yarfox\Attribute\Exception\ReflectionErrorException;
use Attribute;
use Exception;
use ReflectionAttribute;
use ReflectionClass;
use Reflector;
use Serializable;

/**
 * Class ClassAttributeEntity
 * @package Yarfox\Attribute\Entity
 */
class ClassEntity implements EntityInterface
{
    /**
     * @var ReflectionAttribute[]
     */
    private array $attributes = [];

    /**
     * @var ?ReflectionClass
     */
    private ?ReflectionClass $reflection;

    /**
     * @var ConstantEntity[]
     * @example ['constantName' => ConstantAttributeEntity]
     */
    private array $constantEntities = [];

    /**
     * @var PropertyEntity[]
     * @example ['propertyName' => PropertyAttributeEntity]
     */
    private array $propertyEntities = [];

    /**
     * @var MethodEntity[]
     * @example ['methodName' => MethodAttributeEntity]
     */
    private array $methodEntities = [];

    /**
     * ClassAttributeEntity constructor.
     * @param Reflector $reflector
     * @throws ReflectionErrorException
     */
    public function __construct(Reflector $reflector)
    {
        if (!$reflector instanceof ReflectionClass) {
            throw new ReflectionErrorException($reflector, ReflectionClass::class);
        }

        $this->reflection = $reflector;
    }

    /**
     * @return ReflectionAttribute[]
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return ReflectionClass
     */
    public function getReflection(): ReflectionClass
    {
        return $this->reflection;
    }

    /**
     * @return ConstantEntity[]
     */
    public function getConstantEntities(): array
    {
        return $this->constantEntities;
    }

    /**
     * @return PropertyEntity[]
     */
    public function getPropertyEntities(): array
    {
        return $this->propertyEntities;
    }

    /**
     * @return MethodEntity[]
     */
    public function getMethodEntities(): array
    {
        return $this->methodEntities;
    }

    /**
     * @param \ReflectionAttribute $attribute
     */
    public function registerAttribute(ReflectionAttribute $attribute)
    {
        if (Attribute::TARGET_CLASS & $attribute->getTarget()) {
            $name = $attribute->getName();
            $this->attributes[$name] = $attribute;
        }
    }

    /**
     * @param string $constantName
     * @param ConstantEntity $constantAttributeEntity
     */
    public function registerConstant(string $constantName, ConstantEntity $constantAttributeEntity)
    {
        $this->constantEntities[$constantName] = $constantAttributeEntity;
    }

    /**
     * @param string $propertyName
     * @param PropertyEntity $propertyAttributeEntity
     */
    public function registerProperty(string $propertyName, PropertyEntity $propertyAttributeEntity)
    {
        $this->propertyEntities[$propertyName] = $propertyAttributeEntity;
    }

    /**
     * @param string $methodName
     * @param MethodEntity $methodAttributeEntity
     */
    public function registerMethod(string $methodName, MethodEntity $methodAttributeEntity)
    {
        $this->methodEntities[$methodName] = $methodAttributeEntity;
    }

}
