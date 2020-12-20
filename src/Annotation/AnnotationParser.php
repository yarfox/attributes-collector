<?php
/**
 * The file is part of the annotation.
 *
 * (c) alan <alan1766447919@gmail.com>.
 *
 * 2020/12/20 10:43 下午
 */

namespace Anhoder\Annotation;

use Attribute;

/**
 * AnnotationParser is an annotation used to mark the tagged class as an annotation parser.
 * @package Anhoder\Annotation
 */
#[Attribute(Attribute::TARGET_CLASS)]
class AnnotationParser
{
    /**
     * @var string
     */
    private string $annotationClass;

    /**
     * AnnotationParser constructor.
     * @param string $annotationClass
     */
    public function __construct(string $annotationClass)
    {
        $this->annotationClass = $annotationClass;
    }

    /**
     * Get annotation class.
     */
    public function getAnnotationClass()
    {
        return $this->annotationClass;
    }
}
