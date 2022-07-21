<?php
/**
 * The file is part of the attribute.
 *
 * (c) alan <anhoder@88.com>.
 *
 * 2020/12/21 1:33 下午
 */

namespace Yarfox\Attribute\Contract;

use Yarfox\Attribute\Entity\ClassEntity;
use Yarfox\Attribute\Entity\FunctionEntity;

/**
 * Interface AttributeRegistryInterface
 * The interface of class attribute container.
 * @package Yarfox\Attribute\Contract
 * @internal
 */
interface RegistryInterface
{
    /**
     * Get attributes from container.
     * @param string|null $namespace
     * @return \ReflectionAttribute[]
     */
    public function getAttributes(string $namespace = null): array;

    /**
     * Get attribute handler by attribute class name.
     * @param string $attribute
     * @return HandlerInterface|null
     */
    public function getAttributeHandler(string $attribute): ?string;

    /**
     * @param string $namespace
     * @param string $name
     * @param ClassEntity|FunctionEntity $entity
     * @return void
     */
    public function registerAttribute(string $namespace, string $name, ClassEntity|FunctionEntity $entity): void;

    /**
     * @param string $attributeName
     * @param string $attributeHandler
     * @return void
     */
    public function registerAttributeHandler(string $attributeName, string $attributeHandler): void;
}
