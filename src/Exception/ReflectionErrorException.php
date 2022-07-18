<?php
/**
 * The file is part of the attribute.
 *
 * (c) alan <anhoder@88.com>.
 *
 * 2020/12/21 11:22 下午
 */

namespace Yarfox\Attribute\Exception;

use Exception;

/**
 * Class ReflectionErrorException
 * @package Yarfox\Attribute\Exception
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
