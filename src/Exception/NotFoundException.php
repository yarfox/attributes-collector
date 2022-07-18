<?php
/**
 * The file is part of the attribute.
 *
 * (c) alan <anhoder@88.com>.
 *
 * 2020/12/24 1:31 下午
 */

namespace Yarfox\Attribute\Exception;

use Exception;

/**
 * Class NotFoundException
 * @package Yarfox\Attribute\Exception
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
