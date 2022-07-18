<?php
/**
 * The file is part of the attribute.
 *
 * (c) anhoder <anhoder@88.com>.
 *
 * 2021/1/12 8:57 上午
 */

namespace Yarfox\Attribute\Test;

use Yarfox\Attribute\Contract\ConfigInterface;
use JetBrains\PhpStorm\ArrayShape;

class AttributeConfig implements ConfigInterface
{
    #[ArrayShape(['scanDirs' => 'array'])]
    public static function getAttributeConfigs(): array
    {
        return [
            'scanDirs' => [
                __NAMESPACE__ => __DIR__,
            ],
        ];
    }
}
