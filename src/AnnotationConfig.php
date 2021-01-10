<?php
/**
 *  * The file is part of the annotation.
 *
 * (c) anhoder <anhoder@88.com>.
 *
 * 2021/1/11 12:01 上午
 */

namespace Anhoder\Annotation;

use Anhoder\Annotation\Contract\AnnotationConfigInterface;

/**
 * Class AnnotationConfig
 * @package Anhoder\Annotation
 */
class AnnotationConfig implements AnnotationConfigInterface
{

    /**
     * @inheritDoc
     */
    public static function getAnnotationConfigs(): array
    {

        return [
            'scanDirs' => [
                'Anhoder\\Annotation\\' => __DIR__,
            ],
        ];
    }
}
