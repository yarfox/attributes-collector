<?php
/**
 * The file is part of the attribute.
 *
 * (c) alan <anhoder@88.com>.
 *
 * 2020/12/21 9:37 上午
 */

namespace Yarfox\Attribute;

use Yarfox\Attribute\Attribute\AttributeHandler;
use Yarfox\Attribute\Contract\LoggerInterface;
use Yarfox\Attribute\Contract\RegistryInterface;
use Yarfox\Attribute\Contract\ScannerInterface;
use Yarfox\Attribute\Entity\ClassEntity;
use Yarfox\Attribute\Entity\ConstantEntity;
use Yarfox\Attribute\Entity\MethodEntity;
use Yarfox\Attribute\Entity\PropertyEntity;
use Attribute;
use Composer\Autoload\ClassLoader;
use Generator;
use RecursiveDirectoryIterator;
use ReflectionClass;

/**
 * Class AttributeScanner
 * @package Yarfox\Attribute\Scanner
 */
class Scanner implements ScannerInterface
{
    /**
     * @var array
     * @example
     * [
     *     $namespace => 'dir'
     * ]
     */
    private array $scanDirs = [];

    /**
     * @var array
     * @example
     * [
     *     $realpath => $namespace
     * ]
     */
    private array $realpathAssocNamespace = [];

    /**
     * AttributeScanner constructor.
     * @param ConfigCollector $configCollector
     * @param ClassLoader $composerLoader
     * @param \Yarfox\Attribute\Contract\RegistryInterface $registry
     * @param \Yarfox\Attribute\Contract\LoggerInterface|null $logger
     */
    public function __construct(
        private ConfigCollector $configCollector,
        private ClassLoader $composerLoader,
        private RegistryInterface $registry,
        private ?LoggerInterface $logger
    ) {
        // init scanDirs
        foreach ($this->configCollector->getConfigs() as $parentNamespace => $configs) {

            if (!isset($configs['scanDirs']) || !is_array($configs['scanDirs'])) continue;

            foreach ($configs['scanDirs'] as $namespace => $scanDir) {
                $realpath = realpath($scanDir);
                if (false === $realpath || !is_dir($realpath)) {
                    $this->logger && $this->logger->warning("Path({$scanDir}) not exists or it is not dir.");
                    continue;
                }

                $this->scanDirs[$namespace] = $realpath;
            }

        }

        // init realpathAssocNamespace
        foreach ($this->composerLoader->getPrefixesPsr4() as $namespace => $dirs) {
            foreach ($dirs as $dir) {
                $realpath = realpath($dir);
                if (false !== $realpath) $this->realpathAssocNamespace[$realpath] = $namespace;
            }
        }
    }

    /**
     * @throws Exception\ReflectionErrorException
     * @throws \ReflectionException
     */
    public function scan()
    {
        foreach ($this->scanDirs as $namespace => $dir) {
            $this->parseAttributeClassesFromDir($namespace, $dir);
        }

        $this->logger && $this->logger->success('Attribute scan success.');
    }

    /**
     * @param string $namespace
     * @param string $dir
     * @throws Exception\ReflectionErrorException
     * @throws \ReflectionException
     */
    private function parseAttributeClassesFromDir(string $namespace, string $dir)
    {
        $reflectionClassGenerator = $this->getReflectionClassesFromDir($namespace, $dir);

        foreach ($reflectionClassGenerator as $reflectionClass) {
            /**
             * @var $reflectionClass ReflectionClass
             */

            $classEntity = new ClassEntity($reflectionClass);

            // Classes
            $hasClassAttribute = $this->parseAttributeClasses($classEntity, $reflectionClass);

            // Constants
            $hasConstantAttribute = $this->parseAttributeConstants($classEntity, $reflectionClass);

            // Properties
            $hasPropertyAttribute = $this->parseAttributeProperties($classEntity, $reflectionClass);

            // Methods
            $hasMethodAttribute = $this->parseAttributeMethods($classEntity, $reflectionClass);

            if ($hasClassAttribute || $hasConstantAttribute || $hasPropertyAttribute || $hasMethodAttribute) {
                $this->registry->registerAttribute($reflectionClass->getNamespaceName(), $reflectionClass->getName(), $classEntity);
            }
        }
    }

    /**
     * @param ClassEntity $classEntity
     * @param ReflectionClass $reflectionClass
     * @return bool
     */
    private function parseAttributeClasses(ClassEntity $classEntity, ReflectionClass $reflectionClass): bool
    {
        $attributes = $reflectionClass->getAttributes();

        if (empty($attributes)) return false;

        foreach ($attributes as $attribute) {
            $classEntity->registerAttribute($attribute);

            // Attribute Handler
            if ((Attribute::TARGET_CLASS & $attribute->getTarget()) && $attribute->getName() == AttributeHandler::class) {
                $handlerAttribute = $attribute->newInstance();

                $this->registry->registerAttributeHandler($handlerAttribute->getAttributeClass(), $reflectionClass->getName());
            }
        }

        return true;
    }

    /**
     * @param ClassEntity $classEntity
     * @param ReflectionClass $reflectionClass
     * @return bool
     * @throws Exception\ReflectionErrorException
     */
    private function parseAttributeConstants(ClassEntity $classEntity, ReflectionClass $reflectionClass): bool
    {
        $hasAttribute = false;
        $constants = $reflectionClass->getReflectionConstants();

        foreach ($constants as $constant) {
            $constantEntity = new ConstantEntity($constant);
            $attributes = $constant->getAttributes();

            if (empty($attributes)) continue;

            $hasAttribute = true;

            foreach ($attributes as $attribute) {
                $constantEntity->registerAttribute($attribute);
            }

            $classEntity->registerConstant($constant->getName(), $constantEntity);
        }

        return $hasAttribute;
    }

    /**
     * @param ClassEntity $classEntity
     * @param ReflectionClass $reflectionClass
     * @return bool
     * @throws Exception\ReflectionErrorException
     */
    private function parseAttributeProperties(ClassEntity $classEntity, ReflectionClass $reflectionClass): bool
    {
        $hasAttribute = false;
        $properties = $reflectionClass->getProperties();

        foreach ($properties as $property) {
            $propertyEntity = new PropertyEntity($property);
            $attributes = $property->getAttributes();

            if (empty($attributes)) continue;

            $hasAttribute = true;

            foreach ($attributes as $attribute) {
                $propertyEntity->registerAttribute($attribute);
            }

            $classEntity->registerProperty($property->getName(), $propertyEntity);

        }

        return $hasAttribute;
    }

    /**
     * @param ClassEntity $classEntity
     * @param ReflectionClass $reflectionClass
     * @return bool
     * @throws Exception\ReflectionErrorException
     */
    private function parseAttributeMethods(ClassEntity $classEntity, ReflectionClass $reflectionClass): bool
    {
        $hasAttribute = false;
        $methods = $reflectionClass->getMethods();

        foreach ($methods as $method) {
            $methodEntity = new MethodEntity($method);
            $attributes = $method->getAttributes();

            if (empty($attributes)) continue;

            $hasAttribute = true;

            foreach ($attributes as $attribute) {
                $methodEntity->registerAttribute($attribute);
            }

            $classEntity->registerMethod($method->getName(), $methodEntity);
        }

        return $hasAttribute;
    }

    /**
     * @param string $namespace
     * @param string $dir
     * @return Generator
     * @throws \ReflectionException
     */
    private function getReflectionClassesFromDir(string $namespace, string $dir): Generator
    {
        $namespace = rtrim($namespace, '\\');
        $iterator = new RecursiveDirectoryIterator($dir);

        foreach ($iterator as $splFileInfo) {

            $basename = $splFileInfo->getBasename();

            if ($splFileInfo->isDir()) {
                if ($basename == '.' || $basename == '..' || $splFileInfo->getRealPath() == AttributeKeeper::getVendorPath()) {
                    // ignore . or .. or vendor
                    continue;
                }

                // Directory
                $pathname = $splFileInfo->getRealPath();

                if (isset($this->realpathAssocNamespace[$pathname])) {
                    $curNamespace = $this->realpathAssocNamespace;
                } else {
                    $curNamespace = "{$namespace}\\{$basename}";
                }

                foreach ($this->getReflectionClassesFromDir($curNamespace, $splFileInfo->getPathname()) as $reflectionClass) {
                    yield $reflectionClass;
                }

                continue;
            }

            if (!$splFileInfo->isFile() || $splFileInfo->getExtension() != 'php') {
                // not php file
                continue;
            }

            // PHP File
            $className = $splFileInfo->getBasename('.' . $splFileInfo->getExtension());
            $class = "{$namespace}\\{$className}";
            if (class_exists($class)) {
                yield new ReflectionClass($class);
            }

        }
    }
}
