<?php
/**
 * The file is part of the annotation.
 *
 * (c) alan <alan1766447919@gmail.com>.
 *
 * 2020/12/21 10:51 下午
 */

namespace Anhoder\Annotation\Contract;

use Reflection;
use Reflector;

/**
 * Interface AttributeEntityInterface
 * The interface of attribute entity, like class, method, property.
 * @package Anhoder\Annotation\Contract
 * @internal
 */
interface EntityInterface
{
    /**
     * AttributeEntityInterface constructor.
     * @param Reflector $reflector
     */
    public function __construct(Reflector $reflector);

    /**
     * Get annotations.
     * @return \ReflectionAttribute[]
     */
    public function getAttributes(): array;

    /**
     * @return Reflector
     */
    public function getReflection(): Reflector;
}
