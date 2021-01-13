<?php
/**
 * The file is part of the annotation.
 *
 * (c) alan <alan1766447919@gmail.com>.
 *
 * 2020/12/24 2:04 下午
 */

namespace Anhoder\Annotation\LogHandler;

use Anhoder\Annotation\Contract\LogHandlerInterface;
use PHP_Parallel_Lint\PhpConsoleColor\ConsoleColor;

/**
 * Class AnnotationLogDefaultHandler
 * @package Anhoder\Annotation\Handler
 */
class AnnotationLogDefaultHandler implements LogHandlerInterface
{
    /**
     * @var ConsoleColor
     */
    private ConsoleColor $console;

    public function __construct()
    {
        $this->console = new ConsoleColor();
    }

    /**
     * @inheritDoc
     */
    public function errorHandle(string $content)
    {
        $txt = $this->console->apply(['red', 'bold'], "[ERROR] {$content}\n");
        fputs(STDERR, $txt);
    }

    /**
     * @inheritDoc
     */
    public function infoHandle(string $content)
    {
        $txt = $this->console->apply(['bold', 'default'], "[INFO] {$content}\n");
        fputs(STDOUT, $txt);
    }

    /**
     * @inheritDoc
     */
    public function successHandle(string $content)
    {
        $txt = $this->console->apply(['bold', 'green'], "[SUCCESS] {$content}\n");
        fputs(STDOUT, $txt);
    }

    /**
     * @inheritDoc
     */
    public function warningHandle(string $content)
    {
        $txt = $this->console->apply(['bold', 'yellow'], "[WARNING] {$content}\n");
        fputs(STDOUT, $txt);
    }
}
