<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita55f623bbe62a8e749c74c68348dd894
{
    public static $classMap = array (
        'Feed' => __DIR__ . '/..' . '/dg/rss-php/src/Feed.php',
        'FeedException' => __DIR__ . '/..' . '/dg/rss-php/src/Feed.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInita55f623bbe62a8e749c74c68348dd894::$classMap;

        }, null, ClassLoader::class);
    }
}