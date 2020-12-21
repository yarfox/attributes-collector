<?php
/**
 * The file is part of the annotation.
 *
 * (c) alan <alan1766447919@gmail.com>.
 *
 * 2020/12/21 9:35 上午
 */

namespace Anhoder\Annotation\Contract;

use Composer\Autoload\ClassLoader;

/**
 * Interface ScannerInterface
 * @package Anhoder\Annotation\Contract
 */
interface AnnotationScannerInterface
{
    /**
     * @param ClassLoader $composerLoader
     * @return mixed
     */
    public function scan(ClassLoader $composerLoader): AnnotationRegistryInterface;
}
