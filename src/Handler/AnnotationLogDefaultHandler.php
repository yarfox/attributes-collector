<?php
/**
 * The file is part of the annotation.
 *
 * (c) alan <alan1766447919@gmail.com>.
 *
 * 2020/12/24 2:04 下午
 */

namespace Anhoder\Annotation\Handler;

use Anhoder\Annotation\Contract\LogHandlerInterface;
use Wujunze\Colors;

/**
 * Class AnnotationLogDefaultHandler
 * @package Anhoder\Annotation\Handler
 */
class AnnotationLogDefaultHandler implements LogHandlerInterface
{
    /**
     * @inheritDoc
     */
    public function errorHandle(string $content)
    {
        Colors::error($content);
    }

    /**
     * @inheritDoc
     */
    public function infoHandle(string $content)
    {
        Colors::notice($content);
    }

    /**
     * @inheritDoc
     */
    public function successHandle(string $content)
    {
        Colors::success($content);
    }

    /**
     * @inheritDoc
     */
    public function warningHandle(string $content)
    {
        Colors::warn($content);
    }
}
