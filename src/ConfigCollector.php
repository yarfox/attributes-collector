<?php
/**
 * The file is part of the annotation.
 *
 * (c) alan <alan1766447919@gmail.com>.
 *
 * 2020/12/25 12:23 上午
 */

namespace Anhoder\Annotation;

use Anhoder\Annotation\Contract\ConfigInterface;
use Anhoder\Annotation\Contract\LoggerInterface;
use Composer\Autoload\ClassLoader;

/**
 * Class AttributeConfigCollector
 * Collect annotation configs from psr4 prefix dirs.
 * @package Anhoder\Annotation
 */
class ConfigCollector
{
    /**
     * @var string
     */
    private string $attributeConfigFile = 'AttributeConfig.php';

    /**
     * @var string
     */
    private string $attributeConfigClass = 'AttributeConfig';

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
     * AttributeConfigCollector constructor.
     * @param ClassLoader $composerLoader
     * @param LoggerInterface|null $logger
     */
    public function __construct(private ClassLoader $composerLoader, private ?LoggerInterface $logger)
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
    public function getAttributeConfigFile(): string
    {
        return $this->attributeConfigFile;
    }

    /**
     * @param string $attributeConfigFile
     */
    public function setAttributeConfigFile(string $attributeConfigFile): void
    {
        $this->attributeConfigFile = $attributeConfigFile;
    }

    /**
     * @return string
     */
    public function getAttributeConfigClass(): string
    {
        return $this->attributeConfigClass;
    }

    /**
     * @param string $attributeConfigClass
     */
    public function setAttributeConfigClass(string $attributeConfigClass): void
    {
        $this->attributeConfigClass = $attributeConfigClass;
    }

    /**
     * Collect attribute configs from psr4 prefix dirs.
     * @return void
     */
    protected function collect()
    {
        foreach ($this->scanDirs as $namespace => $dirs) {
            foreach ($dirs as $dir) {
                // check file
                $filepath = rtrim($dir, '/') . '/' . $this->attributeConfigFile;
                if (!file_exists($filepath)) {
                    $this->logger && $this->logger->warning("Attribute: file({$filepath}) not exists.");
                    continue;
                }

                // check class
                $className = $namespace . $this->attributeConfigClass;
                if (!class_exists($className)) {
                    $this->logger && $this->logger->warning("Attribute: class($className) not exists.");
                    continue;
                }

                // check interface
                $interfaces = class_implements($className);
                if (!isset($interfaces[ConfigInterface::class])) {
                    $this->logger && $this->logger->warning("Attribute: class({$className}) unimplemented AttributeConfigInterface");
                    continue;
                }

                $configs = $className::getAttributeConfigs();
                if ($configs) {
                    $this->configs[$namespace] = $configs;
                }
            }
        }
    }
}
