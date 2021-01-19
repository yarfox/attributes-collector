<?php
/**
 * The file is part of the annotation.
 *
 * (c) anhoder <anhoder@88.com>.
 *
 * 2021/1/12 8:57 上午
 */

namespace Anhoder\Annotation\Test;

use Anhoder\Annotation\Contract\AnnotationConfigInterface;
use JetBrains\PhpStorm\ArrayShape;

class AnnotationConfig implements AnnotationConfigInterface
{

    #[ArrayShape(['scanDirs' => 'array'])] public static function getAnnotationConfigs(): array
    {
        return [
            'scanDirs' => [
                __NAMESPACE__ => __DIR__,
            ],
        ];
    }
}
