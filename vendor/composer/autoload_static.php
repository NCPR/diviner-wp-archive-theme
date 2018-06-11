<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9e1380a933d64783bab17a277da85526
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Tonik\\Gin\\' => 10,
            'Tonik\\CLI\\' => 10,
        ),
        'S' => 
        array (
            'Symfony\\Component\\Finder\\' => 25,
            'Symfony\\Component\\Filesystem\\' => 29,
            'Seld\\CliPrompt\\' => 15,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
            'Psr\\Container\\' => 14,
        ),
        'L' => 
        array (
            'League\\CLImate\\' => 15,
        ),
        'C' => 
        array (
            'Carbon_Fields\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Tonik\\Gin\\' => 
        array (
            0 => __DIR__ . '/..' . '/tonik/gin/src/Gin',
        ),
        'Tonik\\CLI\\' => 
        array (
            0 => __DIR__ . '/..' . '/tonik/cli/src/CLI',
        ),
        'Symfony\\Component\\Finder\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/finder',
        ),
        'Symfony\\Component\\Filesystem\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/filesystem',
        ),
        'Seld\\CliPrompt\\' => 
        array (
            0 => __DIR__ . '/..' . '/seld/cli-prompt/src',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Psr\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/container/src',
        ),
        'League\\CLImate\\' => 
        array (
            0 => __DIR__ . '/..' . '/league/climate/src',
        ),
        'Carbon_Fields\\' => 
        array (
            0 => __DIR__ . '/..' . '/htmlburger/carbon-fields/core',
        ),
    );

    public static $prefixesPsr0 = array (
        'P' => 
        array (
            'Pimple' => 
            array (
                0 => __DIR__ . '/..' . '/pimple/pimple/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9e1380a933d64783bab17a277da85526::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9e1380a933d64783bab17a277da85526::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit9e1380a933d64783bab17a277da85526::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
