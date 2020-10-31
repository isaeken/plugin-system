<?php


namespace IsaEken\PluginSystem\Helpers;


class Str
{
    /**
     * @param string $haystack
     * @param string $needle
     * @return string
     */
    public static function startsWith(string $haystack, string $needle) : bool
    {
        $length = strlen($needle);
        return substr($haystack, 0, $length) === $needle;
    }

    /**
     * @param string $haystack
     * @param string $needle
     * @return string
     */
    public static function endsWith(string $haystack, string $needle) : bool
    {
        $length = strlen($needle);
        if(!$length) return true;
        return substr($haystack, -$length) === $needle;
    }
}