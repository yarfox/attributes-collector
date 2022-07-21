<?php
/**
 * The file is part of the attribute.
 *
 * (c) anhoder <anhoder@88.com>.
 *
 * 2020/12/20 10:43 下午
 */

namespace Yarfox\Attribute\Attribute;

use Attribute;

/**
 * AttributeHandler is an attribute used to mark the tagged class as an attribute handler.
 * @package Yarfox\Attribute
 */
#[Attribute(Attribute::TARGET_CLASS)]
class AttributeHandler
{
    /**
     * AttributeHandler constructor.
     * @param string $attributeClass
     */
    public function __construct(
        private string $attributeClass
    ) {}

    /**
     * Get attribute class.
     */
    public function getAttributeClass(): string
    {
        return $this->attributeClass;
    }
}
