<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf1046de5e1bcd371a742604b854a9c43
{
    public static $prefixesPsr0 = array (
        'M' => 
        array (
            'Mailchimp' => 
            array (
                0 => __DIR__ . '/../..' . '/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInitf1046de5e1bcd371a742604b854a9c43::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
