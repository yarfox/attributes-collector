<?php
/**
 * The file is part of the annotation.
 *
 * (c) anhoder <anhoder@88.com>.
 *
 * 2021/1/12 8:52 上午
 */

namespace Anhoder\Annotation\Test\Handler;

use Anhoder\Annotation\Attribute\AttributeHandler;
use Anhoder\Annotation\Handler\AbstractHandler;
use Anhoder\Annotation\Test\Annotation\ClassAttribute;

#[AttributeHandler(ClassAttribute::class)]
class ClassAttributeHandler extends AbstractHandler
{
    public function handle()
    {
        /**
         * @var $attribute ClassAttribute
         */
        var_dump($this);
        $attribute = $this->attribute;
        var_dump($attribute->getTest());
    }
}
