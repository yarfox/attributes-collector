<?php
/**
 * The file is part of the annotation.
 *
 * (c) alan <alan1766447919@gmail.com>.
 *
 * 2020/12/21 10:51 下午
 */

namespace Anhoder\Annotation\Contract;

use Reflector;

/**
 * Interface AnnotationEntityInterface
 * The interface of annotation entity, like class, method, property.
 * @package Anhoder\Annotation\Contract
 * @internal
 */
interface AnnotationEntityInterface
{
    /**
     * AnnotationEntityInterface constructor.
     * @param Reflector $reflector
     */
    public function __construct(Reflector $reflector);

    /**
     * Get annotations.
     * @return \ReflectionAttribute[]
     */
    public function getAnnotations(): array;
}
