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
     * @var ClassLoader
     */
    private ClassLoader $composerLoader;

    /**
     * @var string
     */
    private string $autoScannerFile = 'AnnotationScanner.php';

    /**
     * @var string
     */
    private string $autoScannerClass = 'AnnotationScanner';

    /**
     * @var array
     * @example
     * [
     *     $namespace => ['dir1', 'dir2']
     * ]
     */
    private array $scanDirs = [];

    /**
     * AnnotationAnnotationScanner constructor.
     * @param ClassLoader $composerLoader
     */
    private function __construct(ClassLoader $composerLoader)
    {

    }

    /**
     * @return AnnotationScanner
     * @throws NotFoundException
     */
    public static function getInstance()
    {
        if (!static::$instance) {
            $composerLoader = static::getComposerLoader();

            static::$instance = new static($composerLoader);
        }

        return static::$instance;
    }



    /**
     * @return AnnotationRegistryInterface
     */
    public function scan(): AnnotationRegistryInterface
    {
        foreach ($this->scanDirs as $namespace => $dirs) {
            foreach ($dirs as $dir) {
                // check file
                $filepath = rtrim($dir, '/') . '/' . $this->autoScannerFile;
                if (!file_exists($filepath)) continue;

                // check class
                $className = $namespace . $this->autoScannerClass;
                if (!class_exists($className)) continue;


            }
        }
    }
}
