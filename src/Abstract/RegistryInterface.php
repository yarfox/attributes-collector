<?php
/**
 * The file is part of the annotation.
 *
 * (c) alan <alan1766447919@gmail.com>.
 *
 * 2020/12/20 11:14 下午
 */

/**
 * Interface RegistryInterface
 */
interface RegistryInterface
{
    /**
     * Register data of annotation in the registry.
     * @param mixed ...$args
     * @return mixed
     */
    public static function register(...$args);
}
