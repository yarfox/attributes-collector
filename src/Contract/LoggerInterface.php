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
