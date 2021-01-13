<?php
/**
 * The file is part of the annotation.
 *
 * (c) alan <alan1766447919@gmail.com>.
 *
 * 2020/12/21 1:33 下午
 */

namespace Anhoder\Annotation\Contract;

/**
 * Interface AnnotationRegistryInterface
 * The interface of class annotations container.
 * @package Anhoder\Annotation\Contract
 * @internal
 */
interface AnnotationRegistryInterface
{
    /**
     * Get annotations from container.
     * @param string|null $namespace
     * @return \ReflectionAttribute[]
     */
    public static function getAnnotations(string $namespace = null): array;

    /**
     * Get annotation handler by annotation class name.
     * @param string $annotation
     * @return AnnotationHandlerInterface|null
     */
    public static function getAnnotationHandler(string $annotation): ?string;
}
