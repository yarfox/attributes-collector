<?php
/**
 * The file is part of the attribute.
 *
 * (c) alan <anhoder@88.com>.
 *
 * 2020/12/20 11:14 下午
 */

namespace Yarfox\Attribute\Registry;

use Yarfox\Attribute\Contract\RegistryInterface;
use Yarfox\Attribute\Entity\ClassEntity;
use Yarfox\Attribute\Entity\FunctionEntity;

class Registry implements RegistryInterface
{

    /**
     * @var array
     * @example
     * [
     *     $namespace => [
     *         $className  => ClassEntity,
     *         $className2 => ClassEntity,
     *         $funcName   => FunctionEntity,
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
     * @param string $name class or function name
     * @param ClassEntity|FunctionEntity $entity
     */
    public function registerAttribute(string $namespace, string $name, ClassEntity|FunctionEntity $entity): void
    {
        $this->attributes[$namespace][$name] = $entity;
    }

    /**
     * @param string $attributeName
     * @param string $attributeHandler
     */
    public function registerAttributeHandler(string $attributeName, string $attributeHandler): void
    {
        $this->attributeHandlers[$attributeName] = $attributeHandler;
    }
}
