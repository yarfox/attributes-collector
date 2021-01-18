<?php
/**
 * The file is part of the annotation.
 *
 * (c) anhoder <anhoder@88.com>.
 *
 * 2021/1/11 11:01 下午
 */

namespace Anhoder\Annotation;

use Anhoder\Annotation\Annotation\AnnotationHandler;
use Anhoder\Annotation\Contract\AnnotationEntityInterface;
use Anhoder\Annotation\Contract\AnnotationHandlerInterface;
use Anhoder\Annotation\Contract\HandlerSchedulerInterface;
use Anhoder\Annotation\Entity\ClassAnnotationEntity;
use Anhoder\Annotation\Entity\ConstantAnnotationEntity;
use Anhoder\Annotation\Entity\MethodAnnotationEntity;
use Anhoder\Annotation\Entity\PropertyAnnotationEntity;
use Anhoder\Annotation\Registry\AnnotationRegistry;
use Attribute;
use JetBrains\PhpStorm\ExpectedValues;
use ReflectionClass;
use Throwable;

/**
 * Class AnnotationHandlerScheduler
 * @package Anhoder\Annotation
 */
class AnnotationHandlerScheduler implements HandlerSchedulerInterface
{
    /**
     * @var string[]
     */
    public static $ignoreAnnotation = [
        Attribute::class         => Attribute::class,
        AnnotationHandler::class => AnnotationHandler::class,
    ];

    /**
     * @inheritDoc
     */
    public function schedule()
    {
        foreach (AnnotationRegistry::getAnnotations() as $namespace => $classEntities) {

            foreach ($classEntities as $className => $classEntity) {

                /**
                 * @var $classEntity ClassAnnotationEntity
                 */
                $annotations = $classEntity->getAnnotations();
                $this->handleAnnotations(Attribute::TARGET_CLASS, $classEntity->getReflection(), $classEntity, $annotations);

                // Constants
                $this->handleConstantEntities($classEntity->getReflection(), $classEntity->getConstantEntities());

                // Properties
                $this->handlePropertyEntities($classEntity->getReflection(), $classEntity->getPropertyEntities());

                // Methods
                $this->handleMethodEntities($classEntity->getReflection(), $classEntity->getMethodEntities());
            }

        }

        AnnotationHelper::getLogHandler()->successHandle('Annotation handle success.');
    }

    /**
     * @param ReflectionClass $reflectionClass
     * @param array $constantEntities
     */
    private function handleConstantEntities(ReflectionClass $reflectionClass, array $constantEntities)
    {
        foreach ($constantEntities as $constantEntity) {
            /**
             * @var $constantEntity ConstantAnnotationEntity
             */
            $annotations = $constantEntity->getAnnotations();
            $this->handleAnnotations(Attribute::TARGET_CLASS_CONSTANT, $reflectionClass, $constantEntity, $annotations);
        }
    }

    /**
     * @param ReflectionClass $reflectionClass
     * @param array $propertyEntities
     */
    private function handlePropertyEntities(ReflectionClass $reflectionClass, array $propertyEntities)
    {
        foreach ($propertyEntities as $propertyEntity) {
            /**
             * @var $propertyEntity PropertyAnnotationEntity
             */
            $annotations = $propertyEntity->getAnnotations();
            $this->handleAnnotations(Attribute::TARGET_PROPERTY, $reflectionClass, $propertyEntity, $annotations);
        }
    }

    /**
     * @param ReflectionClass $reflectionClass
     * @param array $methodEntities
     */
    private function handleMethodEntities(ReflectionClass $reflectionClass, array $methodEntities)
    {
        foreach ($methodEntities as $methodEntity) {
            /**
             * @var $methodEntity MethodAnnotationEntity
             */
            $annotations = $methodEntity->getAnnotations();
            $this->handleAnnotations(Attribute::TARGET_METHOD, $reflectionClass, $methodEntity, $annotations);
        }
    }

    /**
     * @param int $target
     * @param ReflectionClass $reflectionClass
     * @param AnnotationEntityInterface $entity
     * @param array $annotations
     */
    private function handleAnnotations(#[ExpectedValues(valuesFromClass: Attribute::class)] int $target, ReflectionClass $reflectionClass, AnnotationEntityInterface $entity, array $annotations)
    {
        foreach ($annotations as $annotation) {
            /**
             * @var $annotation \ReflectionAttribute
             */
            if (isset(static::$ignoreAnnotation[$annotation->getName()]))
                continue;

            $handlerName = AnnotationRegistry::getAnnotationHandler($annotation->getName());
            if (!$handlerName) {
                AnnotationHelper::getLogHandler()->warningHandle("{$annotation->getName()} don't has handler.");
                continue;
            }

            if (!class_exists($handlerName)) {
                AnnotationHelper::getLogHandler()->warningHandle("Class {$handlerName} not exists.");
                continue;
            }

            $handler = new $handlerName();
            if (!$handler instanceof AnnotationHandlerInterface) {
                AnnotationHelper::getLogHandler()
                    ->warningHandle("{$handlerName} unimplemented AnnotationHandlerInterface.");
                continue;
            }

            try {
                $handler->setTarget($target);
                $handler->setTargetName($entity->getReflection()->getName());
                $handler->setClassReflection($reflectionClass);

                $attributeClass = $annotation->getName();
                $attributeObject = new $attributeClass(...$annotation->getArguments());
                $handler->setAnnotation($attributeObject);

                $handler->handle();
            } catch (Throwable $e) {
                AnnotationHelper::getLogHandler()
                    ->errorHandle("{$annotation->getName()} handle() execute fails: {$e->getMessage()}");
            }
        }
    }
}
