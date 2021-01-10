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
 * The Interface of annotation scanner.
 * @package Anhoder\Annotation\Contract
 * @internal
 */
interface AnnotationScannerInterface
{
    /**
     * Load annotation by scanning all psr4 prefix namespace from composer loader.
     */
    public function scan();
}
