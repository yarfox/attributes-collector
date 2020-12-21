<?php
/**
 * The file is part of the annotation.
 *
 * (c) alan <alan1766447919@gmail.com>.
 *
 * 2020/12/21 11:04 下午
 */

namespace Anhoder\Annotation\Entity;

use Anhoder\Annotation\Contract\AnnotationEntityInterface;
use Anhoder\Annotation\Exception\ReflectionErrorException;
use ReflectionClass;
use Reflector;

class ClassAnnotationEntity implements AnnotationEntityInterface
{
    /**
     * @var array
     */
    private array $annotations;

    /**
     * @var ReflectionClass
     */
    private ReflectionClass $reflection;

    /**
     * @var ConstantAnnotationEntity[]
     * @example ['constantName' => ConstantAnnotationEntity]
     */
    private array $constantEntities;

    /**
     * @var PropertyAnnotationEntity[]
     * @example ['propertyName' => PropertyAnnotationEntity]
     */
    private array $propertyEntities;

    /**
     * @var MethodAnnotationEntity[]
     * @example ['methodName' => MethodAnnotationEntity]
     */
    private array $methodEntities;

    /**
     * ClassAnnotationEntity constructor.
     * @param Reflector $reflector
     * @throws ReflectionErrorException
     */
    public function __construct(Reflector $reflector)
    {
        if (!$reflector instanceof ReflectionClass) {
            throw new ReflectionErrorException($reflector, ReflectionClass::class);
        }

        $this->reflection = $reflector;
    }

    /**
     * @inheritDoc
     */
    public function getAnnotations(): array
    {
        return $this->annotations;
    }

    public function registerConstant(string $constantName, ConstantAnnotationEntity $constantAnnotationEntity)
    {

    }

    public function registerProperty(string $propertyName, PropertyAnnotationEntity $propertyAnnotationEntity)
    {

    }

    public function registerMethod(string $methodName, MethodAnnotationEntity $methodAnnotationEntity)
    {

    }
}
