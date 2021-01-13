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
use Anhoder\Annotation\Test\Annotation\ClassAnnotation;

#[AnnotationHandler(ClassAnnotation::class)]
class ClassAnnotationHandler
{

}
