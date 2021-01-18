<?php
/**
 * The file is part of the annotation.
 *
 * (c) anhoder <anhoder@88.com>.
 *
 * 2021/1/12 8:52 上午
 */

namespace Anhoder\Annotation\Test\Handler;

use Anhoder\Annotation\Annotation\AnnotationHandler;
use Anhoder\Annotation\Handler\AbstractAnnotationHandler;
use Anhoder\Annotation\Test\Annotation\ClassAnnotation;

#[AnnotationHandler(ClassAnnotation::class)]
class ClassAnnotationHandler extends AbstractAnnotationHandler
{
    public function handle()
    {
        /**
         * @var $annotation ClassAnnotation
         */
        var_dump($this);
        $annotation = $this->annotation;
        var_dump($annotation->getTest());
    }
}
