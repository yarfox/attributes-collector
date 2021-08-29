<?php
/**
 * The file is part of the annotation.
 *
 * (c) alan <alan1766447919@gmail.com>.
 *
 * 2020/12/20 11:14 下午
 */

namespace Anhoder\Annotation\Registry;

use Anhoder\Annotation\Contract\RegistryInterface;
use Anhoder\Annotation\Entity\ClassEntity;

class Registry implements RegistryInterface
{

    /**
     * @var array
     * @example
     * [
     *     $namespace => [
     *         $className  => ClassAttributeEntity,
     *         $className2 => ClassAttributeEntity,
     *     ]
     * ]
     */
    private array $attributes = [];

    /**
     * @var array
     * @example
     * [
     *     $attributeClassName => HandlerClassName
     * ]
     */
    private array $attributeHandlers = [];

    /**
     * @param string|null $namespace
     * @return array
     */
    public function getAttributes(string $namespace = null): array
    {
        if (is_null($namespace)) return $this->attributes;

        return $this->attributes[$namespace] ?? [];
    }

    /**
     * @param string $attribute
     * @return string|null
     */
    public function getAttributeHandler(string $attribute): ?string
    {
        return $this->attributeHandlers[$attribute] ?? null;
    }

    /**
     * @param string $namespace
     * @param string $className
     * @param \Anhoder\Annotation\Entity\ClassEntity $classAttributeEntity
     */
    public function registerAttribute(string $namespace, string $className, ClassEntity $classAttributeEntity)
    {
        $this->attributes[$namespace][$className] = $classAttributeEntity;
    }

    /**
     * @param string $attributeName
     * @param string $attributeHandler
     */
    public function registerAttributeHandler(string $attributeName, string $attributeHandler)
    {
        $this->attributeHandlers[$attributeName] = $attributeHandler;
    }
}
