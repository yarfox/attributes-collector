<?php
/**
 * The file is part of the annotation.
 *
 * (c) alan <alan1766447919@gmail.com>.
 *
 * 2020/12/25 12:23 上午
 */

namespace Anhoder\Annotation;

use Anhoder\Annotation\Contract\AnnotationConfigInterface;
use Composer\Autoload\ClassLoader;

/**
 * Class AnnotationConfigCollector
 * Collect annotation configs from psr4 prefix dirs.
 * @package Anhoder\Annotation
 */
class AnnotationConfigCollector
{
    /**
     * @var AnnotationConfigCollector|null
     */
    private static ?AnnotationConfigCollector $instance = null;

    /**
     * @var string
     */
    private string $annotationConfigFile = 'AnnotationConfig.php';

    /**
     * @var string
     */
    private string $annotationConfigClass = 'AnnotationConfig';

    /**
     * @var array
     * @example [
     *     namespace => configs
     * ]
     * keys: scanDirs(array)
     */
    private array $configs = [];

    /**
     * @var array
     */
    private array $scanDirs = [];

    /**
     * AnnotationConfigCollector constructor.
     * @param ClassLoader $composerLoader
     */
    private function __construct(private ClassLoader $composerLoader)
    {
        $prefixes = $this->composerLoader->getPrefixesPsr4();

        foreach ($prefixes as $namespace => $dirs) {
            $this->scanDirs[$namespace] = [];
            foreach ($dirs as $dir) {
                $this->scanDirs[$namespace][] = realpath($dir);
            }
        }
    }

    /**
     * @return AnnotationConfigCollector
     * @throws \Anhoder\Annotation\Exception\NotFoundException
     */
    public static function getInstance(): static
    {
        if (!static::$instance) {
            $composerLoader = AnnotationHelper::getComposerLoader();
            static::$instance = new static($composerLoader);
        }

        return static::$instance;
    }

    /**
     * @return array
     */
    public function getConfigs(): array
    {
        if (!$this->configs) {
            $this->collect();
        }

        return $this->configs;
    }

    /**
     * @return string
     */
    public function getAnnotationConfigFile(): string
    {
        return $this->annotationConfigFile;
    }

    /**
     * @param string $annotationConfigFile
     */
    public function setAnnotationConfigFile(string $annotationConfigFile): void
    {
        $this->annotationConfigFile = $annotationConfigFile;
    }

    /**
     * @return string
     */
    public function getAnnotationConfigClass(): string
    {
        return $this->annotationConfigClass;
    }

    /**
     * @param string $annotationConfigClass
     */
    public function setAnnotationConfigClass(string $annotationConfigClass): void
    {
        $this->annotationConfigClass = $annotationConfigClass;
    }

    /**
     * Collect annotation configs from psr4 prefix dirs.
     * @return void
     */
    protected function collect()
    {
        $logHandler = AnnotationHelper::getLogHandler();

        foreach ($this->scanDirs as $namespace => $dirs) {
            foreach ($dirs as $dir) {
                // check file
                $filepath = rtrim($dir, '/') . '/' . $this->annotationConfigFile;
                if (!file_exists($filepath)) {
                    $logHandler->warningHandle("Annotation: file({$filepath}) not exists.");
                    continue;
                }

                // check class
                $className = $namespace . $this->annotationConfigClass;
                if (!class_exists($className)) {
                    $logHandler->warningHandle("Annotation: class($className) not exists.");
                    continue;
                }

                // check interface
                $interfaces = class_implements($className);
                if (!isset($interfaces[AnnotationConfigInterface::class])) {
                    $logHandler->warningHandle("Annotation: class({$className}) unimplemented AnnotationConfigInterface");
                    continue;
                }

                $configs = $className::getAnnotationConfigs();
                if ($configs) {
                    $this->configs[$namespace] = $configs;
                }
            }
        }
    }
}
