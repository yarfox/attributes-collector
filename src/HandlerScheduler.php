<?php
/**
 * The file is part of the attribute.
 *
 * (c) anhoder <anhoder@88.com>.
 *
 * 2021/1/11 11:01 下午
 */

namespace Yarfox\Attribute;

use Yarfox\Attribute\Attribute\AttributeHandler;
use Yarfox\Attribute\Contract\EntityInterface;
use Yarfox\Attribute\Contract\HandlerInterface;
use Yarfox\Attribute\Contract\HandlerSchedulerInterface;
use Yarfox\Attribute\Contract\LoggerInterface;
use Yarfox\Attribute\Contract\RegistryInterface;
use Yarfox\Attribute\Entity\ClassEntity;
use Yarfox\Attribute\Entity\ConstantEntity;
use Yarfox\Attribute\Entity\MethodEntity;
use Yarfox\Attribute\Entity\PropertyEntity;
use Attribute;
use JetBrains\PhpStorm\ExpectedValues;
use ReflectionClass;
use Throwable;

/**
 * Class AttributeHandlerScheduler
 * @package Yarfox\Attribute
 */
class HandlerScheduler implements HandlerSchedulerInterface
{
    /**
     * @var string[]
     */
    public static array $ignoreAttributes = [
        Attribute::class        => Attribute::class,
        AttributeHandler::class => AttributeHandler::class,
    ];

    /**
     * @param RegistryInterface $registry
     * @param LoggerInterface|null $logger
     */
    public function __construct(private RegistryInterface $registry, private ?LoggerInterface $logger)
    {
    }

    /**
     * @inheritDoc
     */
    public function schedule(): void
    {
        foreach ($this->registry->getAttributes() as $namespace => $classEntities) {

            foreach ($classEntities as $className => $classEntity) {

                /**
                 * @var $classEntity ClassEntity
                 */
                $attributes = $classEntity->getAttributes();
                $this->handleAttributes(Attribute::TARGET_CLASS, $classEntity->getReflection(), $classEntity, $attributes);

                // Constants
                $this->handleConstantEntities($classEntity->getReflection(), $classEntity->getConstantEntities());

                // Properties
                $this->handlePropertyEntities($classEntity->getReflection(), $classEntity->getPropertyEntities());

                // Methods
                $this->handleMethodEntities($classEntity->getReflection(), $classEntity->getMethodEntities());
            }

        }

        $this->logger && $this->logger->success('Attribute handle success.');
    }

    /**
     * @param ReflectionClass $reflectionClass
     * @param array $constantEntities
     */
    private function handleConstantEntities(ReflectionClass $reflectionClass, array $constantEntities)
    {
        foreach ($constantEntities as $constantEntity) {
            /**
             * @var $constantEntity ConstantEntity
             */
            $attributes = $constantEntity->getAttributes();
            $this->handleAttributes(Attribute::TARGET_CLASS_CONSTANT, $reflectionClass, $constantEntity, $attributes);
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
             * @var $propertyEntity PropertyEntity
             */
            $attributes = $propertyEntity->getAttributes();
            $this->handleAttributes(Attribute::TARGET_PROPERTY, $reflectionClass, $propertyEntity, $attributes);
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
             * @var $methodEntity MethodEntity
             */
            $attributes = $methodEntity->getAttributes();
            $this->handleAttributes(Attribute::TARGET_METHOD, $reflectionClass, $methodEntity, $attributes);
        }
    }

    /**
     * @param int $target
     * @param ReflectionClass $reflectionClass
     * @param EntityInterface $entity
     * @param array $attributes
     */
    private function handleAttributes(#[ExpectedValues(valuesFromClass: Attribute::class)] int $target, ReflectionClass $reflectionClass, EntityInterface $entity, array $attributes)
    {
        foreach ($attributes as $attribute) {
            /**
             * @var $attribute \ReflectionAttribute
             */
            if (isset(static::$ignoreAttributes[$attribute->getName()]))
                continue;

            $handlerName = $this->registry->getAttributeHandler($attribute->getName());
            if (!$handlerName) {
                $this->logger && $this->logger->warning("{$attribute->getName()} don't has handler.");
                continue;
            }

            if (!class_exists($handlerName)) {
                $this->logger && $this->logger->warning("Class {$handlerName} not exists.");
                continue;
            }

            $handler = new $handlerName();
            if (!$handler instanceof HandlerInterface) {
                $this->logger && $this->logger->warning("{$handlerName} unimplemented AttributeHandlerInterface.");
                continue;
            }

            try {
                $handler->setTarget($target);
                $handler->setTargetName($entity->getReflection()->getName());
                $handler->setClassReflection($reflectionClass);

                $attributeObject = $attribute->newInstance();
                $handler->setAttribute($attributeObject);

                $handler->handle();
            } catch (Throwable $e) {
                $this->logger && $this->logger->error("{$attribute->getName()} handle() execute fails: {$e->getMessage()}");
            }
        }
    }
}
