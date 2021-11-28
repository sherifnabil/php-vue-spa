<?php

namespace App\Core;

class App
{
    protected static $keys = [];

    public static function bind($key, $val)
    {
        static::$keys[$key] = $val;
    }

    public static function get($key)
    {
        if (array_key_exists($key, static::$keys)) {
            return static::$keys[$key];
        }
        throw new \Exception("No {$key} is bound in the Container");
    }
}
