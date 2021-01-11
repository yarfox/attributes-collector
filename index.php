<?php
/**
 *  * The file is part of the annotation.
 *
 * (c) anhoder <anhoder@88.com>.
 *
 * 2021/1/10 2:17 下午
 */

use Anhoder\Annotation\AnnotationScanner;
use Anhoder\Annotation\Registry\AnnotationRegistry;

require './vendor/autoload.php';

$scanner = AnnotationScanner::getInstance();
$scanner->scan();

foreach (AnnotationRegistry::getAnnotations() as $namespace => $annotations) {
    foreach ($annotations as $className => $annotation) {
        /**
         * @var $annotation \Anhoder\Annotation\Entity\ClassAnnotationEntity
         */
        dump($className, $annotation->getAnnotations());
    }
}

