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
use ReflectionClassConstant;
use Reflector;

/**
 * Class ConstantAnnotationEntity
 * @package Anhoder\Annotation\Entity
 */
class ConstantAnnotationEntity implements AnnotationEntityInterface
{
    /**
     * @var array
     */
    private array $annotations = [];

    /**
     * @var ReflectionClassConstant
     */
    private ReflectionClassConstant $reflection;

    /**
     * ConstantAnnotationEntity constructor.
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
     * @return array
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
