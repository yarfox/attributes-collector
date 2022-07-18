<?php
/**
 * The file is part of the attribute.
 *
 * (c) alan <anhoder@88.com>.
 *
 * 2020/12/21 9:35 上午
 */

namespace Yarfox\Attribute\Contract;

use Composer\Autoload\ClassLoader;

/**
 * Interface AttributeScannerInterface
 * The Interface of attribute scanner.
 * @package Yarfox\Attribute\Contract
 * @internal
 */
interface ScannerInterface
{
    /**
     * Load attribute by scanning all psr4 prefix namespace from composer loader.
     */
    public function scan();
}
