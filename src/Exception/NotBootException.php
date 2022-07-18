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
 * Class NotBootException
 * @package Yarfox\Attribute\Exception
 */
class NotBootException extends Exception
{
    /**
     * @var string
     */
    protected $message = 'Not boot';

    /**
     * NotBootException constructor.
     */
    public function __construct(int $code = 0, $previous = null)
    {
        parent::__construct('AttributeKeeper not boot, please call AttributeKeeper::bootloader()', $code, $previous);
    }
}
