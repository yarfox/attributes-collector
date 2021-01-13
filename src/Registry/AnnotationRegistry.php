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
use Anhoder\Annotation\Contract\AnnotationHandlerInterface;
use Anhoder\Annotation\Entity\ClassAnnotationEntity;

class AnnotationRegistry implements AnnotationRegistryInterface
{
    /**
     * @var array
     * @example
     * [
     *     $namespace => [
     *         $className  => ClassAnnotationEntity,
     *         $className2 => ClassAnnotationEntity,
     *     ]
     * ]
     */
    private static array $annotations = [];

    /**
     * @var array
     * @example
     * [
     *     $annotationClassName => HandlerClassName
     * ]
     */
    private static array $annotationHandlers = [];

    /**
     * @param string|null $namespace
     * @return array
     */
    public static function getAnnotations(string $namespace = null): array
    {
        if (is_null($namespace)) return static::$annotations;

        return static::$annotations[$namespace] ?? [];
    }

    /**
     * @param string $annotation
     * @return string|null
     */
    public static function getAnnotationHandler(string $annotation): ?string
    {
        if (!isset(static::$annotationHandlers[$annotation])) return null;
        return static::$annotationHandlers[$annotation];
    }

    /**
     * @param string $namespace
     * @param string $className
     * @param ClassAnnotationEntity $classAnnotationEntity
     */
    public static function registerAnnotation(string $namespace, string $className, ClassAnnotationEntity $classAnnotationEntity)
    {
        static::$annotations[$namespace][$className] = $classAnnotationEntity;
    }

    /**
     * @param string $annotationName
     * @param string $annotationHandler
     */
    public static function registerAnnotationHandler(string $annotationName, string $annotationHandler)
    {
        static::$annotationHandlers[$annotationName] = $annotationHandler;
    }
}
