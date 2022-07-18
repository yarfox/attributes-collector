<?php
/**
 * The file is part of the attribute.
 *
 * (c) anhoder <anhoder@88.com>.
 *
 * 2021/1/11 11:37 下午
 */

namespace Yarfox\Attribute\Contract;

/**
 * Interface HandlerSchedulerInterface
 * @package Yarfox\Attribute\Contract
 */
interface HandlerSchedulerInterface
{
    /**
     * @return void
     */
    public function schedule(): void;
}
