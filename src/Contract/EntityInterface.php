<?php
/**
 * The file is part of the attribute.
 *
 * (c) alan <anhoder@88.com>.
 *
 * 2020/12/21 10:51 下午
 */

namespace Yarfox\Attribute\Contract;

use Reflection;
use Reflector;

/**
 * Interface AttributeEntityInterface
 * The interface of attribute entity, like class, method, property.
 * @package Yarfox\Attribute\Contract
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
     * Get attributes.
     * @return \ReflectionAttribute[]
     */
    public function getAttributes(): array;

    /**
     * @return Reflector
     */
    public function getReflection(): Reflector;
}
