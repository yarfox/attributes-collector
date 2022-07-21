<?php
/**
 * The file is part of the attribute.
 *
 * (c) anhoder <anhoder@88.com>.
 *
 * 2020/12/21 9:31 上午
 */

namespace Yarfox\Attribute\Contract;

/**
 * Interface HandlerInterface
 * @package Yarfox\Attribute\Contract
 */
interface LoggerInterface
{
    public const LEVEL_INFO    = 1;
    public const LEVEL_WARNING = 2;
    public const LEVEL_SUCCESS = 3;
    public const LEVEL_ERROR   = 4;

    /**
     * @param int $level
     * @return void
     */
    public function setLevel(int $level = self::LEVEL_INFO): void;

    /**
     * @param string $content
     * @return void
     */
    public function error(string $content): void;

    /**
     * @param string $content
     * @return void
     */
    public function info(string $content): void;

    /**
     * @param string $content
     * @return void
     */
    public function success(string $content): void;

    /**
     * @param string $content
     * @return void
     */
    public function warning(string $content): void;
}
