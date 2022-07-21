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
use ReflectionClassConstant;
use Reflector;

/**
 * Class ConstantAttributeEntity
 * @package Yarfox\Attribute\Entity
 */
class ClassConstantEntity implements EntityInterface
{
    /**
     * @return ReflectionClassConstant
     */
    public function getReflection(): ReflectionClassConstant
    {
        return $this->reflection;
    }
    /**
     * @var ReflectionAttribute[]
     */
    private array $attributes = [];

    /**
     * @var ReflectionClassConstant
     */
    private ReflectionClassConstant $reflection;

    /**
     * ConstantAttributeEntity constructor.
     * @param Reflector $reflector
     * @throws ReflectionErrorException
     */
    public function __construct(Reflector $reflector)
    {
        if (!$reflector instanceof ReflectionClassConstant) {
            throw new ReflectionErrorException($reflector, ReflectionClassConstant::class);
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
     * @param \ReflectionAttribute $attribute
     */
    public function registerAttribute(ReflectionAttribute $attribute)
    {
        if (Attribute::TARGET_CLASS_CONSTANT & $attribute->getTarget()) {
            $name = $attribute->getName();
            $this->attributes[$name] = $attribute;
        }
    }
}
