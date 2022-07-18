<?php
/**
 * The file is part of the attribute.
 *
 * (c) alan <anhoder@88.com>.
 *
 * 2020/12/24 2:04 下午
 */

namespace Yarfox\Attribute\Logger;

use Yarfox\Attribute\Contract\LoggerInterface;
use PHP_Parallel_Lint\PhpConsoleColor\ConsoleColor;

/**
 * Class DefaultLogger
 * @package Yarfox\Attribute\Logger
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
    public function error(string $content): void
    {
        $txt = $this->console->apply(['red', 'bold'], "[ERROR] {$content}\n");
        fputs(STDERR, $txt);
    }

    /**
     * @inheritDoc
     */
    public function info(string $content): void
    {
        $txt = $this->console->apply(['bold', 'default'], "[INFO] {$content}\n");
        fputs(STDOUT, $txt);
    }

    /**
     * @inheritDoc
     */
    public function success(string $content): void
    {
        $txt = $this->console->apply(['bold', 'green'], "[SUCCESS] {$content}\n");
        fputs(STDOUT, $txt);
    }

    /**
     * @inheritDoc
     */
    public function warning(string $content): void
    {
        $txt = $this->console->apply(['bold', 'yellow'], "[WARNING] {$content}\n");
        fputs(STDOUT, $txt);
    }
}
