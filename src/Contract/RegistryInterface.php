<?php
/**
 * The file is part of the annotation.
 *
 * (c) alan <alan1766447919@gmail.com>.
 *
 * 2020/12/21 1:33 下午
 */

namespace Anhoder\Annotation\Contract;

use Anhoder\Annotation\Entity\ClassEntity;

/**
 * Interface AttributeRegistryInterface
 * The interface of class attribute container.
 * @package Anhoder\Annotation\Contract
 * @internal
 */
interface RegistryInterface
{
    /**
     * Get annotations from container.
     * @param string|null $namespace
     * @return \ReflectionAttribute[]
     */
    public function getAttributes(string $namespace = null): array;

    /**
     * Get attribute handler by annotation class name.
     * @param string $attribute
     * @return HandlerInterface|null
     */
    public function getAttributeHandler(string $attribute): ?string;

    /**
     * @param string $namespace
     * @param string $className
     * @param ClassEntity $classAttributeEntity
     * @return void
     */
    public function registerAttribute(string $namespace, string $className, ClassEntity $classAttributeEntity);

    /**
     * @param string $attributeName
     * @param string $attributeHandler
     * @return void
     */
    public function registerAttributeHandler(string $attributeName, string $attributeHandler);
}
