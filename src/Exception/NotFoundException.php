<?php
/**
 * The file is part of the annotation.
 *
 * (c) alan <alan1766447919@gmail.com>.
 *
 * 2020/12/24 1:31 下午
 */

namespace Anhoder\Annotation\Exception;

use Exception;

/**
 * Class NotFoundException
 * @package Anhoder\Annotation\Exception
 */
class NotFoundException extends Exception
{
    /**
     * @var string
     */
    protected $message = 'Not found';

    /**
     * NotFoundException constructor.
     * @param string $thing
     * @param int $code
     * @param null $previous
     */
    public function __construct(string $thing = "", int $code = 0, $previous = null)
    {
        $msg = $thing ? "{$thing} not found" : $this->message;

        parent::__construct($msg, $code, $previous);
    }
}
