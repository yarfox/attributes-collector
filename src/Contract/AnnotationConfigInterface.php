<?php
/**
 * The file is part of the annotation.
 *
 * (c) alan <alan1766447919@gmail.com>.
 *
 * 2020/12/25 1:29 下午
 */

namespace Anhoder\Annotation\Contract;

/**
 * Interface AnnotationConfigInterface
 * @package Anhoder\Annotation\Contract
 */
interface AnnotationConfigInterface
{
    /**
     * @return array
     */
    public static function getAnnotationConfigs(): array;
}
