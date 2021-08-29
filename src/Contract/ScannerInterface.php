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
 * Interface AttributeScannerInterface
 * The Interface of attribute scanner.
 * @package Anhoder\Annotation\Contract
 * @internal
 */
interface ScannerInterface
{
    /**
     * Load attribute by scanning all psr4 prefix namespace from composer loader.
     */
    public function scan();
}
