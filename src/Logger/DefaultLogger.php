<?php
/**
 * The file is part of the annotation.
 *
 * (c) alan <alan1766447919@gmail.com>.
 *
 * 2020/12/24 2:04 下午
 */

namespace Anhoder\Annotation\Logger;

use Anhoder\Annotation\Contract\LoggerInterface;
use PHP_Parallel_Lint\PhpConsoleColor\ConsoleColor;

/**
 * Class DefaultLogger
 * @package Anhoder\Annotation\Logger
 */
class DefaultLogger implements LoggerInterface
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
    public function error(string $content)
    {
        $txt = $this->console->apply(['red', 'bold'], "[ERROR] {$content}\n");
        fputs(STDERR, $txt);
    }

    /**
     * @inheritDoc
     */
    public function info(string $content)
    {
        $txt = $this->console->apply(['bold', 'default'], "[INFO] {$content}\n");
        fputs(STDOUT, $txt);
    }

    /**
     * @inheritDoc
     */
    public function success(string $content)
    {
        $txt = $this->console->apply(['bold', 'green'], "[SUCCESS] {$content}\n");
        fputs(STDOUT, $txt);
    }

    /**
     * @inheritDoc
     */
    public function warning(string $content)
    {
        $txt = $this->console->apply(['bold', 'yellow'], "[WARNING] {$content}\n");
        fputs(STDOUT, $txt);
    }
}
