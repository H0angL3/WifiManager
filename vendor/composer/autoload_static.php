<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7e711c76e46bc39d8830f06400f5dd63
{
    public static $prefixLengthsPsr4 = array (
        'U' => 
        array (
            'UniFi_API\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'UniFi_API\\' => 
        array (
            0 => __DIR__ . '/..' . '/art-of-wifi/unifi-api-client/src',
        ),
    );

    public static $classMap = array (
        'UniFi_API\\Client' => __DIR__ . '/..' . '/art-of-wifi/unifi-api-client/src/Client.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit7e711c76e46bc39d8830f06400f5dd63::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit7e711c76e46bc39d8830f06400f5dd63::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit7e711c76e46bc39d8830f06400f5dd63::$classMap;

        }, null, ClassLoader::class);
    }
}