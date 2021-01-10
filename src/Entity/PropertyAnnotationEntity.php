<?php
/**
 * The file is part of the annotation.
 *
 * (c) alan <alan1766447919@gmail.com>.
 *
 * 2020/12/21 11:09 下午
 */

namespace Anhoder\Annotation\Entity;

use Anhoder\Annotation\Contract\AnnotationEntityInterface;
use Anhoder\Annotation\Exception\ReflectionErrorException;
use Attribute;
use ReflectionAttribute;
use ReflectionProperty;
use Reflector;

/**
 * Class PropertyAnnotationEntity
 * @package Anhoder\Annotation\Entity
 */
class PropertyAnnotationEntity implements AnnotationEntityInterface
{
    /**
     * @var ReflectionAttribute[]
     */
    private array $annotations = [];

    /**
     * @var ReflectionProperty
     */
    private ReflectionProperty $reflection;

    /**
     * PropertyAnnotationEntity constructor.
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
    public function getAnnotations(): array
    {
        return $this->annotations;
    }

    /**
     * @param $annotation
     */
    public function registerAnnotation(ReflectionAttribute $annotation)
    {
        if (Attribute::TARGET_PROPERTY & $annotation->getTarget()) {
            $name = $annotation->getName();
            $this->annotations[$name] = $annotation;
        }
    }
}
