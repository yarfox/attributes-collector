<?php
/**
 * The file is part of the attribute.
 *
 * (c) alan <anhoder@88.com>.
 *
 * 2020/12/21 11:10 下午
 */

namespace Yarfox\Attribute\Entity;

use Yarfox\Attribute\Contract\EntityInterface;
use Yarfox\Attribute\Exception\ReflectionErrorException;
use Attribute;
use ReflectionAttribute;
use ReflectionMethod;
use Reflector;

/**
 * Class MethodAttributeEntity
 * @package Yarfox\Attribute\Entity
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
     * @var ParamEntity[]
     * @example ['paramName' => ParamAttributeEntity]
     */
    private array $paramEntities = [];

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
     * @return ParamEntity[]
     */
    public function getParamEntities(): array
    {
        return $this->paramEntities;
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

    /**
     * @param string $paramName
     * @param ParamEntity $paramAttributeEntity
     */
    public function registerParam(string $paramName, ParamEntity $paramAttributeEntity)
    {
        $this->paramEntities[$paramName] = $paramAttributeEntity;
    }
}
