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
use Anhoder\Annotation\Contract\AnnotationRegistryInterface;
use Anhoder\Annotation\Contract\AnnotationScannerInterface;
use Anhoder\Annotation\Entity\ClassAnnotationEntity;
use Anhoder\Annotation\Entity\ConstantAnnotationEntity;
use Anhoder\Annotation\Entity\MethodAnnotationEntity;
use Anhoder\Annotation\Entity\PropertyAnnotationEntity;
use Anhoder\Annotation\Exception\NotFoundException;
use Anhoder\Annotation\Registry\AnnotationRegistry;
use Attribute;
use Composer\Autoload\ClassLoader;
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
                    AnnotationHelper::getLogHandler()->infoHandle("Path({$scanDir}) not exists or it is not dir.");
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
    }

    /**
     * @param string $namespace
     * @param string $dir
     * @throws Exception\ReflectionErrorException
     * @throws \ReflectionException
     */
    private function parseAnnotationClassesFromDir(string $namespace, string $dir)
    {
        $reflectionClasses = $this->getReflectionClassesFromDir($namespace, $dir);

        foreach ($reflectionClasses as $reflectionClass) {
            /**
             * @var $reflectionClass ReflectionClass
             */

            // Class
            $classEntity = new ClassAnnotationEntity($reflectionClass);
            $attributes = $reflectionClass->getAttributes();

            foreach ($attributes as $attribute) {
                $classEntity->registerAnnotation($attribute);

                // Annotation Handler
                if ((Attribute::TARGET_CLASS & $attribute->getTarget()) && $attribute->getName() == AnnotationHandler::class) {
                    $args = $attribute->getArguments();

                    $handlerAnnotation = new AnnotationHandler(...$args);

//                    $handler = $reflectionClass->newInstanceWithoutConstructor();
//
//                    if (!$handler instanceof AnnotationHandlerInterface) {
//                        AnnotationHelper::getLogHandler()->errorHandle("{$reflectionClass->getName()} must be instance of AnnotationHandlerInterface.");
//                        continue;
//                    }
//
//                    $handler->setTarget(Attribute::TARGET_CLASS);
//                    $handler->setTargetName($reflectionClass->getName());
//                    $handler->setAnnotation($handlerAnnotation);
//                    $handler->setClassReflection($reflectionClass);

                    AnnotationRegistry::registerAnnotationHandler($handlerAnnotation->getAnnotationClass(), $reflectionClass->getName());
                }
            }

            // Constants
            $this->parseAnnotationConstants($classEntity, $reflectionClass);

            // Properties
            $this->parseAnnotationProperties($classEntity, $reflectionClass);

            // Methods
            $this->parseAnnotationMethods($classEntity, $reflectionClass);

            AnnotationRegistry::registerAnnotation($reflectionClass->getName(), $classEntity);
        }

    }

    /**
     * @param ClassAnnotationEntity $classEntity
     * @param ReflectionClass $reflectionClass
     * @throws Exception\ReflectionErrorException
     */
    private function parseAnnotationConstants(ClassAnnotationEntity $classEntity, ReflectionClass $reflectionClass)
    {
        $constants = $reflectionClass->getReflectionConstants();

        foreach ($constants as $constant) {
            $constantEntity = new ConstantAnnotationEntity($constant);
            $attributes = $constant->getAttributes();

            foreach ($attributes as $attribute) {
                $constantEntity->registerAnnotation($attribute);
            }

            $classEntity->registerConstant($constant->getName(), $constantEntity);
        }

    }

    /**
     * @param ClassAnnotationEntity $classEntity
     * @param ReflectionClass $reflectionClass
     * @throws Exception\ReflectionErrorException
     */
    private function parseAnnotationProperties(ClassAnnotationEntity $classEntity, ReflectionClass $reflectionClass)
    {
        $properties = $reflectionClass->getProperties();

        foreach ($properties as $property) {
            $propertyEntity = new PropertyAnnotationEntity($property);
            $attributes = $property->getAttributes();

            foreach ($attributes as $attribute) {
                $propertyEntity->registerAnnotation($attribute);
            }

            $classEntity->registerProperty($property->getName(), $propertyEntity);
        }
    }

    /**
     * @param ClassAnnotationEntity $classEntity
     * @param ReflectionClass $reflectionClass
     * @throws Exception\ReflectionErrorException
     */
    private function parseAnnotationMethods(ClassAnnotationEntity $classEntity, ReflectionClass $reflectionClass)
    {
        $methods = $reflectionClass->getMethods();

        foreach ($methods as $method) {
            $methodEntity = new MethodAnnotationEntity($method);
            $attributes = $method->getAttributes();

            foreach ($attributes as $attribute) {
                $methodEntity->registerAnnotation($attribute);
            }

            $classEntity->registerMethod($method->getName(), $methodEntity);
        }
    }

    /**
     * @param string $namespace
     * @param string $dir
     * @return array
     * @throws \ReflectionException
     */
    private function getReflectionClassesFromDir(string $namespace, string $dir)
    {
        $namespace = rtrim('\\', $namespace);
        $iterator = new RecursiveDirectoryIterator($dir);

        $reflectionClasses = [];
        foreach ($iterator as $splFileInfo) {

            $basename = $splFileInfo->getBasename();

            if ($splFileInfo->isDir() && $basename != '.' && $basename != '..') {
                // Directory

                $pathname = $splFileInfo->getRealPath();

                if (isset($this->realpathAssocNamespace[$pathname])) {
                    $curNamespace = $this->realpathAssocNamespace;
                } else {
                    $curNamespace = "{$namespace}\\{$basename}";
                }

                $reflectionClasses = array_merge($reflectionClasses, $this->getReflectionClassesFromDir($curNamespace, $splFileInfo->getPathname()));

            } elseif (!$splFileInfo->isFile() || !$splFileInfo->getExtension() != 'php') {
                // not php file
                continue;
            }

            // PHP File
            $class = "{$namespace}\\{$basename}";
            if (class_exists($class)) {
                $reflectionClasses[] = new ReflectionClass($class);
            }

        }

        return $reflectionClasses;
    }
}
