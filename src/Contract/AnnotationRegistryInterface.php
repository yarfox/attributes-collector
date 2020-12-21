<?php
/**
 * The file is part of the annotation.
 *
 * (c) alan <alan1766447919@gmail.com>.
 *
 * 2020/12/21 1:33 下午
 */

namespace Anhoder\Annotation\Contract;

interface AnnotationRegistryInterface extends RegistryInterface
{
    public function getAnnotations(string $namespace = null): array;

    public function getAnnotationHandler(string $className): HandlerInterface;
}
