<?php
/**
 * The file is part of the annotation.
 *
 * (c) alan <alan1766447919@gmail.com>.
 *
 * 2020/12/20 10:43 下午
 */

namespace Anhoder\Annotation\Attribute;

use Attribute;

/**
 * AttributeHandler is an annotation used to mark the tagged class as an annotation handler.
 * @package Anhoder\Annotation
 */
#[Attribute(Attribute::TARGET_CLASS)]
class AttributeHandler
{
    /**
     * @var string
     */
    private string $attributeClass;

    /**
     * AttributeHandler constructor.
     * @param string $attributeClass
     */
    public function __construct(string $attributeClass)
    {
        $this->attributeClass = $attributeClass;
    }

    /**
     * Get annotation class.
     */
    public function getAttributeClass(): string
    {
        return $this->attributeClass;
    }
}
