<?php
/**
 * The file is part of the annotation.
 *
 * (c) alan <alan1766447919@gmail.com>.
 *
 * 2020/12/25 3:04 下午
 */

namespace Anhoder\Annotation;

use Anhoder\Annotation\Contract\LogHandlerInterface;
use Anhoder\Annotation\Exception\NotFoundException;
use Anhoder\Annotation\LogHandler\AnnotationLogDefaultHandler;
use Composer\Autoload\ClassLoader;

/**
 * Class AnnotationHelper
 * @package Anhoder\Annotation
 */
class AnnotationHelper
{
    /**
     * @var ClassLoader
     */
    private static ClassLoader $classLoader;

    /**
     * @var LogHandlerInterface
     */
    private static LogHandlerInterface $logHandler;

    /**
     * 获取composer自动加载对象
     * @return ClassLoader
     * @throws NotFoundException
     */
    public static function getComposerLoader()
    {
        if (!static::$classLoader) {
            $loaders = spl_autoload_functions();

            foreach ($loaders as $loader) {
                if (is_array($loader) && isset($loader[0]) && $loader[0] instanceof ClassLoader) {
                    static::$classLoader = $loader[0];
                }
            }

            if (!static::$classLoader) throw new NotFoundException('Composer class loader');
        }


        return static::$classLoader;
    }

    /**
     * @return LogHandlerInterface
     */
    public static function getLogHandler(): LogHandlerInterface
    {
        if (!self::$logHandler) {
            self::$logHandler = new AnnotationLogDefaultHandler();
        }

        return self::$logHandler;
    }

    /**
     * @param LogHandlerInterface $logHandler
     */
    public static function registerLogHandler(LogHandlerInterface $logHandler): void
    {
        self::$logHandler = $logHandler;
    }
}
