<?php
/**
 * The file is part of the annotation.
 *
 * (c) alan <alan1766447919@gmail.com>.
 *
 * 2020/12/21 11:10 下午
 */

namespace Anhoder\Annotation\Entity;

use Anhoder\Annotation\Contract\AnnotationEntityInterface;
use Anhoder\Annotation\Exception\ReflectionErrorException;
use ReflectionMethod;
use Reflector;

/**
 * Class MethodAnnotationEntity
 * @package Anhoder\Annotation\Entity
 */
class MethodAnnotationEntity implements AnnotationEntityInterface
{
    /**
     * @var array
     */
    private array $annotations = [];

    /**
     * @var ReflectionMethod
     */
    private ReflectionMethod $reflection;

    /**
     * MethodAnnotationEntity constructor.
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
     * @inheritDoc
     */
    public function getAnnotations(): array
    {
        return $this->annotations;
    }

    /**
     * @param $annotation
     */
    public function registerAnnotation($annotation)
    {
        $this->annotations[] = $annotation;
    }
}
