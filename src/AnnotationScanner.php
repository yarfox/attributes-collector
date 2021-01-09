<?php
/**
 * The file is part of the annotation.
 *
 * (c) alan <alan1766447919@gmail.com>.
 *
 * 2020/12/21 9:37 上午
 */

namespace Anhoder\Annotation;

use Anhoder\Annotation\Contract\AnnotationRegistryInterface;
use Anhoder\Annotation\Contract\AnnotationScannerInterface;
use Anhoder\Annotation\Exception\NotFoundException;
use Composer\Autoload\ClassLoader;

/**
 * Class AnnotationScanner
 * @package Anhoder\Annotation\Scanner
 */
class AnnotationScanner implements AnnotationScannerInterface
{
    /**
     * @var AnnotationScanner
     */
    private static AnnotationScanner $instance;

    /**
     * @var AnnotationConfigCollector
     */
    private AnnotationConfigCollector $configCollector;

    /**
     * @var array
     * @example
     * [
     *     $namespace => ['dir1', 'dir2']
     * ]
     */
    private array $scanDirs = [];

    /**
     * AnnotationScanner constructor.
     * @throws NotFoundException
     */
    private function __construct()
    {
        $this->configCollector = AnnotationConfigCollector::getInstance();

        foreach ($this->configCollector->getConfigs() as $parentNamespace => $configs) {

            if (isset($configs['scanDirs']) && is_array($configs['scanDirs'])) {

                foreach ($configs['scanDirs'] as $namespace => $scanDir) {
                    $realpath = realpath($scanDir);
                    if (false !== $realpath) continue;

                    $this->scanDirs[$namespace] = $realpath;
                }

            }

        }
    }

    /**
     * @return AnnotationScanner
     */
    public static function getInstance(): static
    {
        if (!static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * @param array $dirs
     * @return AnnotationRegistryInterface
     */
    public function scan(array $dirs): AnnotationRegistryInterface
    {

    }
}
