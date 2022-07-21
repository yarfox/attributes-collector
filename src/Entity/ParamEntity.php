<?php
/**
 * The file is part of the attribute.
 *
 * (c) alan <anhoder@88.com>.
 *
 * 2020/12/21 11:10 下午
 */

namespace Yarfox\Attribute\Entity;

use ReflectionParameter;
use Yarfox\Attribute\Contract\EntityInterface;
use Yarfox\Attribute\Exception\ReflectionErrorException;
use Attribute;
use ReflectionAttribute;
use Reflector;

/**
 * Class ParamEntity
 * @package Yarfox\Attribute\Entity
 */
class ParamEntity implements EntityInterface
{
    /**
     * @var ReflectionAttribute[]
     */
    private array $attributes = [];

    /**
     * @var ReflectionParameter
     */
    private ReflectionParameter $reflection;

    /**
     * MethodAttributeEntity constructor.
     * @param Reflector $reflector
     * @throws ReflectionErrorException
     */
    public function __construct(Reflector $reflector)
    {
        if (!$reflector instanceof ReflectionParameter) {
            throw new ReflectionErrorException($reflector, ReflectionParameter::class);
        }

        $this->reflection = $reflector;
    }

    /**
     * @return ReflectionParameter
     */
    public function getReflection(): ReflectionParameter
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
        if (Attribute::TARGET_PARAMETER & $attribute->getTarget()) {
            $name = $attribute->getName();
            $this->attributes[$name] = $attribute;
        }
    }
}
