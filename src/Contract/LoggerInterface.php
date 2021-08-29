<?php
/**
 * The file is part of the annotation.
 *
 * (c) alan <alan1766447919@gmail.com>.
 *
 * 2020/12/21 9:31 上午
 */

namespace Anhoder\Annotation\Contract;

/**
 * Interface HandlerInterface
 * @package Anhoder\Annotation\Contract
 */
interface LoggerInterface
{
    /**
     * @param string $content
     * @return void
     */
    public function error(string $content);

    /**
     * @param string $content
     * @return void
     */
    public function info(string $content);

    /**
     * @param string $content
     * @return void
     */
    public function success(string $content);

    /**
     * @param string $content
     * @return void
     */
    public function warning(string $content);
}
