<?php
/**
 * The file is part of the annotation.
 *
 * (c) alan <alan1766447919@gmail.com>.
 *
 * 2020/12/25 1:29 下午
 */

namespace Anhoder\Annotation\Contract;

use JetBrains\PhpStorm\ArrayShape;

/**
 * Interface AttributeConfigInterface
 * @package Anhoder\Annotation\Contract
 */
interface ConfigInterface
{
    /**
     * @return array
     */
    #[ArrayShape(['scanDirs' => 'array'])]
    public static function getAttributeConfigs(): array;
}
