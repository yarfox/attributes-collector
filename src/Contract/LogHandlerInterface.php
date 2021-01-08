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
interface LogHandlerInterface
{
    /**
     * @param string $content
     * @return mixed
     */
    public function errorHandle(string $content);

    /**
     * @param string $content
     * @return mixed
     */
    public function infoHandle(string $content);

    /**
     * @param string $content
     * @return mixed
     */
    public function successHandle(string $content);

    /**
     * @param string $content
     * @return mixed
     */
    public function warningHandle(string $content);
}
