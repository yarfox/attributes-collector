<?php
/**
 * The file is part of the annotation.
 *
 * (c) alan <alan1766447919@gmail.com>.
 *
 * 2020/12/20 11:14 下午
 */

namespace Anhoder\Annotation\Registry;

use Anhoder\Annotation\Contract\AnnotationRegistryInterface;
use Anhoder\Annotation\Contract\HandlerInterface;

class AnnotationRegistry implements AnnotationRegistryInterface
{
    /**
     * @var array
     * @example
     * [
     *     $namespace => [
     *         $className => [
     *             'annotations' => ReflectionAttribute[],
     *             'properties'  => [],
     *             'methods'     => [],
     *             'constans'    => [],
     *         ]
     *     ]
     * ]
     */
    private array $annotations = [];

    /**
     * @var array
     * @example
     * [
     *     $annotationClassName => HandlerInterface
     * ]
     */
    private array $annotationHandlers = [];

    public function getAnnotations(string $namespace = null): array
    {
        // TODO: Implement getAnnotations() method.
    }

    public function getAnnotationHandler(string $annotation): HandlerInterface
    {
        // TODO: Implement getAnnotationHandler() method.
    }
}
