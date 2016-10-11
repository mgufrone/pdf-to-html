<?php

namespace Gufy\PdfToHtml;

use Illuminate\Config\Repository;

class Config
{
    protected static $instance;

    public static function getInstance()
    {
        if (!(static::$instance instanceof Repository))
            static::$instance = new Repository;

        return static::$instance;
        // return static::$instance = $instance;
    }

    public static function __callStatic($function, $arguments)
    {
        return call_user_func_array([static::getInstance(), $function], $arguments);
    }
}
