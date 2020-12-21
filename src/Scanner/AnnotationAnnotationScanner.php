<?php
/**
 * The file is part of the annotation.
 *
 * (c) alan <alan1766447919@gmail.com>.
 *
 * 2020/12/21 9:37 上午
 */

namespace Anhoder\Annotation\Scanner;

use Anhoder\Annotation\Contract\AnnotationRegistryInterface;
use Anhoder\Annotation\Contract\AnnotationScannerInterface;
use Composer\Autoload\ClassLoader;

class AnnotationAnnotationScanner implements AnnotationScannerInterface
{
    /**
     * @var ClassLoader
     */
    private ClassLoader $composerLoader;

    /**
     * @param \Composer\Autoload\ClassLoader $composerLoader
     * @return \Anhoder\Annotation\Contract\AnnotationRegistryInterface
     */
    public function scan(ClassLoader $composerLoader): AnnotationRegistryInterface
    {

    }
}
