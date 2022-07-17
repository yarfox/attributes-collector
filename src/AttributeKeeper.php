<?php
/**
 * The file is part of the annotation.
 *
 * (c) alan <alan1766447919@gmail.com>.
 *
 * 2020/12/25 3:04 下午
 */

namespace Anhoder\Annotation;

use Anhoder\Annotation\Contract\HandlerSchedulerInterface;
use Anhoder\Annotation\Contract\LoggerInterface;
use Anhoder\Annotation\Contract\RegistryInterface;
use Anhoder\Annotation\Contract\ScannerInterface;
use Anhoder\Annotation\Exception\NotFoundException;
use Anhoder\Annotation\Logger\DefaultLogger;
use Anhoder\Annotation\Registry\Registry;
use Anhoder\Container\Facade\Container;
use Composer\Autoload\ClassLoader;

/**
 * Class AttributeKeeper
 * @package Anhoder\Annotation
 */
class AttributeKeeper
{
    /**
     * @var string|null
     */
    private static ?string $vendorPath = null;

    /**
     * Get composer class autoloader.
     * @return ClassLoader
     * @throws NotFoundException
     */
    public static function getClassLoader(): ClassLoader
    {
        $loaders = spl_autoload_functions();

        foreach ($loaders as $loader) {
            if (is_array($loader) && isset($loader[0]) && $loader[0] instanceof ClassLoader) {
                return $loader[0];
            }
        }

        throw new NotFoundException('Composer class loader');
    }

    /**
     * @param LoggerInterface $logHandler
     */
    public static function registerLogHandler(LoggerInterface $logHandler): void
    {
        Container::registerInstance(LoggerInterface::class, $logHandler);
    }

    /**
     * @return string
     */
    public static function getVendorPath(): string
    {
        if (!static::$vendorPath) {
            static::$vendorPath = dirname(__DIR__, 3);
        }

        return static::$vendorPath;
    }

    /**
     * boot.
     * @throws NotFoundException
     */
    public static function bootloader(): void
    {
        if (!Container::getInstance(LoggerInterface::class)) {
            Container::registerInstance(LoggerInterface::class, new DefaultLogger());
        }
        Container::registerInstance(ClassLoader::class, static::getClassLoader());
        Container::registerSingletonProducer(ConfigCollector::class, ConfigCollector::class);
        Container::registerSingletonProducer(RegistryInterface::class, Registry::class);
        Container::registerSingletonProducer(ScannerInterface::class, Scanner::class);
        Container::registerSingletonProducer(HandlerSchedulerInterface::class, HandlerScheduler::class);
    }

    /**
     * start collect.
     */
    public static function collect(): void
    {
        /**
         * @var ScannerInterface $scanner
         */
        $scanner = Container::getInstance(ScannerInterface::class);
        $scanner->scan();

        /**
         * @var HandlerSchedulerInterface $scheduler
         */
        $scheduler = Container::getInstance(HandlerSchedulerInterface::class);
        $scheduler->schedule();
    }
}
