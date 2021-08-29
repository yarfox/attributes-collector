<?php
/**
 * The file is part of the annotation.
 *
 * (c) alan <alan1766447919@gmail.com>.
 *
 * 2020/12/21 11:22 下午
 */

namespace Anhoder\Annotation\Exception;

use Exception;

/**
 * Class ReflectionErrorException
 * @package Anhoder\Annotation\Exception
 */
class ReflectionErrorException extends Exception
{
    /**
     * @var string
     */
    protected $message = 'Reflection error';

    /**
     * ReflectionErrorException constructor.
     * @param object $object
     * @param string $contract
     * @param int $code
     * @param null $previous
     */
    public function __construct(object $object, string $contract, int $code = 0, $previous = null)
    {
        $msg = sprintf('%s is not instance of %s', get_class($object), $contract);
        parent::__construct($msg, $code, $previous);
    }
}
