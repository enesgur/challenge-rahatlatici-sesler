<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;

trait CacheTrait
{
    /**
     * @param string $cacheKey
     * @param bool $cache
     * @return mixed
     */
    public static function cacheControl($cacheKey, $cache = true)
    {
        if ($cache !== true) {
            return false;
        }

        $data = Cache::get($cacheKey, false);
        if ($data !== false) {
            return $data;
        }

        return false;
    }

    /**
     * @param string $method
     * @param array $args
     * @return string
     */
    public static function cacheKey($method, $args = [])
    {
        $args = count($args) !== 0 ? ':' . implode(':', $args) : '';
        return __CLASS__ . ':' . $method . $args;
    }

    /**
     * @param string $cacheName
     * @return bool
     */
    public static function cacheDelete($cacheName)
    {
        return Cache::forget($cacheName);
    }
}
