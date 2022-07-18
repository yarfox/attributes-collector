<?php
/**
 * The file is part of the attribute.
 *
 * (c) alan <anhoder@88.com>.
 *
 * 2020/12/25 3:04 下午
 */

namespace Yarfox\Attribute;

use Yarfox\Attribute\Contract\HandlerSchedulerInterface;
use Yarfox\Attribute\Contract\LoggerInterface;
use Yarfox\Attribute\Contract\RegistryInterface;
use Yarfox\Attribute\Contract\ScannerInterface;
use Yarfox\Attribute\Exception\NotBootException;
use Yarfox\Attribute\Exception\NotFoundException;
use Yarfox\Attribute\Logger\DefaultLogger;
use Yarfox\Attribute\Registry\Registry;
use Yarfox\Container\Facade\Container;
use Composer\Autoload\ClassLoader;

/**
 * Class AttributeKeeper
 * @package Yarfox\Attribute
 */
class AttributeKeeper
{
    /**
     * @var string|null
     */
    private static ?string $vendorPath = null;

    /**
     * @var bool
     */
    private static bool $hasBooted = false;

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

        self::$hasBooted = true;
    }

    /**
     * start collect.
     * @throws NotBootException
     */
    public static function collect(): void
    {
        if (!self::$hasBooted) {
            throw new NotBootException();
        }

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
