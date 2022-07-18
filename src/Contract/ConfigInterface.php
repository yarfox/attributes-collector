<?php
/**
 * The file is part of the attribute.
 *
 * (c) alan <anhoder@88.com>.
 *
 * 2020/12/25 1:29 下午
 */

namespace Yarfox\Attribute\Contract;

use JetBrains\PhpStorm\ArrayShape;

/**
 * Interface AttributeConfigInterface
 * @package Yarfox\Attribute\Contract
 */
interface ConfigInterface
{
    /**
     * @return array
     */
    #[ArrayShape(['scanDirs' => 'array'])]
    public static function getAttributeConfigs(): array;
}
