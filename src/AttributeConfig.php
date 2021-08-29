<?php
/**
 * The file is part of the annotation.
 *
 * (c) anhoder <anhoder@88.com>.
 *
 * 2021/1/11 12:01 上午
 */

namespace Anhoder\Annotation;

use Anhoder\Annotation\Contract\ConfigInterface;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class AttributeConfig
 * @package Anhoder\Annotation
 */
class AttributeConfig implements ConfigInterface
{
    /**
     * @inheritDoc
     */
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
