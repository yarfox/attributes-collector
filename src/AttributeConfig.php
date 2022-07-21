<?php
/**
 * The file is part of the attribute.
 *
 * (c) anhoder <anhoder@88.com>.
 *
 * 2021/1/11 12:01 上午
 */

namespace Yarfox\Attribute;

use Yarfox\Attribute\Contract\ConfigInterface;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class AttributeConfig
 * @package Yarfox\Attribute
 */
class AttributeConfig implements ConfigInterface
{
    /**
     * @inheritDoc
     */
    #[ArrayShape(['scanDirs' => 'array', 'functions' => 'array'])]
    public static function getAttributeConfigs(): array
    {
        return [
            'scanDirs' => [
                __NAMESPACE__ => __DIR__,
            ],
            'functions' => [],
        ];
    }
}
