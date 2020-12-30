<?php
/**
 * Plugin System
 * @version v1.0
 * @author İsa Eken
 * @license MIT
 */

namespace IsaEken\PluginSystem\Helpers;

/**
 * Class Str
 * @package IsaEken\PluginSystem\Helpers
 */
class Str
{
    /**
     * Check if string starts with
     *
     * @param string $haystack
     * @param string $needle
     * @return bool
     */
    public static function startsWith(string $haystack, string $needle) : bool
    {
        return substr($haystack, 0, strlen($needle)) === $needle;
    }

    /**
     * Check if string ends with
     *
     * @param string $haystack
     * @param string $needle
     * @return bool
     */
    public static function endsWith(string $haystack, string $needle) : bool
    {
        if (!strlen($needle)) return true;
        return substr($haystack, -strlen($needle)) === $needle;
    }

    /**
     * Convert to array and get last.
     *
     * @param string $string
     * @param string $separator
     * @return string
     */
    public static function afterLast(string $string, string $separator = '.'): string
    {
        $exploded = explode($separator, $string);
        return $exploded[count($exploded) - 1];
    }
}