<?php
/**
 * The file is part of the annotation.
 *
 * (c) alan <alan1766447919@gmail.com>.
 *
 * 2020/12/21 9:37 上午
 */

namespace Anhoder\Annotation;

use Anhoder\Annotation\Annotation\AnnotationHandler;
use Anhoder\Annotation\Contract\AnnotationScannerInterface;
use Anhoder\Annotation\Entity\ClassAnnotationEntity;
use Anhoder\Annotation\Entity\ConstantAnnotationEntity;
use Anhoder\Annotation\Entity\MethodAnnotationEntity;
use Anhoder\Annotation\Entity\PropertyAnnotationEntity;
use Anhoder\Annotation\Exception\NotFoundException;
use Anhoder\Annotation\Registry\AnnotationRegistry;
use Attribute;
use Composer\Autoload\ClassLoader;
use Generator;
use RecursiveDirectoryIterator;
use ReflectionClass;

/**
 * Class AnnotationScanner
 * @package Anhoder\Annotation\Scanner
 */
class AnnotationScanner implements AnnotationScannerInterface
{
    /**
     * @var AnnotationScanner|null
     */
    private static ?AnnotationScanner $instance = null;

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
     * AnnotationScanner constructor.
     * @param AnnotationConfigCollector $configCollector
     * @param ClassLoader $composerLoader
     */
    private function __construct(private AnnotationConfigCollector $configCollector, private ClassLoader $composerLoader)
    {
        // init scanDirs
        foreach ($this->configCollector->getConfigs() as $parentNamespace => $configs) {

            if (!isset($configs['scanDirs']) || !is_array($configs['scanDirs'])) continue;

            foreach ($configs['scanDirs'] as $namespace => $scanDir) {
                $realpath = realpath($scanDir);
                if (false === $realpath || !is_dir($realpath)) {
                    AnnotationHelper::getLogHandler()->warningHandle("Path({$scanDir}) not exists or it is not dir.");
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
     * @return AnnotationScanner
     * @throws NotFoundException
     */
    public static function getInstance(): static
    {
        if (!static::$instance) {
            $configCollector = AnnotationConfigCollector::getInstance();
            $composerLoader = AnnotationHelper::getComposerLoader();
            static::$instance = new static($configCollector, $composerLoader);
        }

        return static::$instance;
    }

    /**
     * @throws Exception\ReflectionErrorException
     * @throws \ReflectionException
     */
    public function scan()
    {
        foreach ($this->scanDirs as $namespace => $dir) {
            $this->parseAnnotationClassesFromDir($namespace, $dir);
        }

        $logger = AnnotationHelper::getLogHandler();
        $logger->successHandle('Annotation scan success.');
    }

    /**
     * @param string $namespace
     * @param string $dir
     * @throws Exception\ReflectionErrorException
     * @throws \ReflectionException
     */
    private function parseAnnotationClassesFromDir(string $namespace, string $dir)
    {
        $reflectionClassGenerator = $this->getReflectionClassesFromDir($namespace, $dir);

        foreach ($reflectionClassGenerator as $reflectionClass) {
            /**
             * @var $reflectionClass ReflectionClass
             */

            $classEntity = new ClassAnnotationEntity($reflectionClass);

            // Classes
            $hasClassAnnotation = $this->parseAnnotationClasses($classEntity, $reflectionClass);

            // Constants
            $hasConstantAnnotation = $this->parseAnnotationConstants($classEntity, $reflectionClass);

            // Properties
            $hasPropertyAnnotation = $this->parseAnnotationProperties($classEntity, $reflectionClass);

            // Methods
            $hasMethodAnnotation = $this->parseAnnotationMethods($classEntity, $reflectionClass);

            if ($hasClassAnnotation || $hasConstantAnnotation || $hasPropertyAnnotation || $hasMethodAnnotation) {
                AnnotationRegistry::registerAnnotation($reflectionClass->getNamespaceName(), $reflectionClass->getName(), $classEntity);
            }
        }
    }

    /**
     * @param ClassAnnotationEntity $classEntity
     * @param ReflectionClass $reflectionClass
     * @return bool
     */
    private function parseAnnotationClasses(ClassAnnotationEntity $classEntity, ReflectionClass $reflectionClass)
    {
        $attributes = $reflectionClass->getAttributes();

        if (empty($attributes)) return false;

        foreach ($attributes as $attribute) {
            $classEntity->registerAnnotation($attribute);

            // Annotation Handler
            if ((Attribute::TARGET_CLASS & $attribute->getTarget()) && $attribute->getName() == AnnotationHandler::class) {
                $args = $attribute->getArguments();

                $handlerAnnotation = new AnnotationHandler(...$args);
                AnnotationRegistry::registerAnnotationHandler($handlerAnnotation->getAnnotationClass(), $reflectionClass->getName());
            }
        }

        return true;
    }

    /**
     * @param ClassAnnotationEntity $classEntity
     * @param ReflectionClass $reflectionClass
     * @return bool
     * @throws Exception\ReflectionErrorException
     */
    private function parseAnnotationConstants(ClassAnnotationEntity $classEntity, ReflectionClass $reflectionClass)
    {
        $hasAttribute = false;
        $constants = $reflectionClass->getReflectionConstants();

        foreach ($constants as $constant) {
            $constantEntity = new ConstantAnnotationEntity($constant);
            $attributes = $constant->getAttributes();

            if (empty($attributes)) continue;

            $hasAttribute = true;

            foreach ($attributes as $attribute) {
                $constantEntity->registerAnnotation($attribute);
            }

            $classEntity->registerConstant($constant->getName(), $constantEntity);
        }

        return $hasAttribute;
    }

    /**
     * @param ClassAnnotationEntity $classEntity
     * @param ReflectionClass $reflectionClass
     * @return bool
     * @throws Exception\ReflectionErrorException
     */
    private function parseAnnotationProperties(ClassAnnotationEntity $classEntity, ReflectionClass $reflectionClass)
    {
        $hasAttribute = false;
        $properties = $reflectionClass->getProperties();

        foreach ($properties as $property) {
            $propertyEntity = new PropertyAnnotationEntity($property);
            $attributes = $property->getAttributes();

            if (empty($attributes)) continue;

            $hasAttribute = true;

            foreach ($attributes as $attribute) {
                $propertyEntity->registerAnnotation($attribute);
            }

            $classEntity->registerProperty($property->getName(), $propertyEntity);

        }

        return $hasAttribute;
    }

    /**
     * @param ClassAnnotationEntity $classEntity
     * @param ReflectionClass $reflectionClass
     * @return bool
     * @throws Exception\ReflectionErrorException
     */
    private function parseAnnotationMethods(ClassAnnotationEntity $classEntity, ReflectionClass $reflectionClass)
    {
        $hasAttribute = false;
        $methods = $reflectionClass->getMethods();

        foreach ($methods as $method) {
            $methodEntity = new MethodAnnotationEntity($method);
            $attributes = $method->getAttributes();

            if (empty($attributes)) continue;

            $hasAttribute = true;

            foreach ($attributes as $attribute) {
                $methodEntity->registerAnnotation($attribute);
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
                if ($basename == '.' || $basename == '..' || $splFileInfo->getRealPath() == AnnotationHelper::getVendorPath()) {
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
