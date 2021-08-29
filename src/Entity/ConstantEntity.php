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
use ReflectionClassConstant;
use Reflector;

/**
 * Class ConstantAttributeEntity
 * @package Anhoder\Annotation\Entity
 */
class ConstantEntity implements EntityInterface
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
