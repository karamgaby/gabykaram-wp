<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitefc2c9e699968c41d9f965da4b38f9dd
{
    public static $prefixLengthsPsr4 = array (
        'X' =>
        array (
            'X_UI\\Modules\\' => 13,
            'X_UI\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'X_UI\\Modules\\' =>
        array (
            0 => __DIR__ . '/../..' . '/modules',
        ),
        'X_UI\\' =>
        array (
            0 => __DIR__ . '/../..' . '/inc',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'X_UI\\Core\\AbstractComponent' => __DIR__ . '/../..' . '/inc/Core/AbstractComponent.php',
        'X_UI\\Core\\AbstractTemplateLoader' => __DIR__ . '/../..' . '/inc/Core/AbstractTemplateLoader.php',
        'X_UI\\Core\\AbstractTokens' => __DIR__ . '/../..' . '/inc/Core/AbstractTokens.php',
        'X_UI\\Core\\Config' => __DIR__ . '/../..' . '/inc/Core/Config.php',
        'X_UI\\Core\\Tokens\\Colors' => __DIR__ . '/../..' . '/inc/Core/Tokens/Colors.php',
        'X_UI\\Core\\Tokens\\Grid' => __DIR__ . '/../..' . '/inc/Core/Tokens/Grid.php',
        'X_UI\\Core\\Tokens\\Typographies' => __DIR__ . '/../..' . '/inc/Core/Tokens/Typographies.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitefc2c9e699968c41d9f965da4b38f9dd::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitefc2c9e699968c41d9f965da4b38f9dd::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitefc2c9e699968c41d9f965da4b38f9dd::$classMap;

        }, null, ClassLoader::class);
    }
}
