<?php

namespace Fmk;

class Lang
{
    private static $textes;

    public static function load($textes)
    {
        self::$textes = $textes;
    }

    public static function get($key, ...$params)
    {
        if (isset(self::$textes[$key])) {
            if (!empty($params)) {
                return call_user_func_array('sprintf', array_merge((array) self::$textes[$key], $params));
            } else {
                return self::$textes[$key];
            }
        }
        // TODO : save inexisting key
        return $key;
    }
}
