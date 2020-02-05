<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Favorite extends Model
{
    use CacheTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sid', 'uid'
    ];

    /**
     * @param int $id
     * @param bool $cache
     * @return array|mixed
     */
    public static function songs($id, $cache = true)
    {
        $cacheName = self::cacheKey(__FUNCTION__, [$id]);
        $data = self::cacheControl($cacheName, $cache);
        if ($data !== false) {
            return $data;
        }

        $data = self::query()->from((new self)->getTable(), 'fav')
            ->leftJoin((new Song)->getTable() . ' AS sg', 'sg.id', '=', 'fav.sid')
            ->join((new Artist)->getTable() . ' AS at', 'sg.aid', '=', 'at.id')
            ->where('fav.uid', $id)
            ->get([
                'sg.*',
                'at.id AS artistID',
                'at.name as artistName'
            ])->toArray();

        Cache::put($cacheName, $data, (60 * 60));
        return $data;
    }

    /**
     * @param int $sid
     * @param int $uid
     */
    public static function add($sid, $uid)
    {
        self::create([
            'sid' => $sid,
            'uid' => $uid
        ]);

        $cacheName = self::cacheKey('songs', [$uid]);
        self::cacheDelete($cacheName);
    }

    /**
     * @param int $sid
     * @param int $uid
     */
    public static function remove($sid, $uid)
    {
        self::where('uid', $uid)->where('sid', $sid)->delete();
        $cacheName = self::cacheKey('songs', [$uid]);
        self::cacheDelete($cacheName);
    }
}
