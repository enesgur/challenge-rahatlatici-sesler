<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use CacheTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'cover_image_url'
    ];

    /**
     * @param bool $cache
     * @return array|mixed
     */
    public static function allData($cache = true)
    {
        $cacheName = self::cacheKey(__FUNCTION__);
        $data = self::cacheControl($cacheName, $cache);
        if ($data !== false) {
            return $data;
        }

        $data = self::query()->from((new self)->getTable(), 'ct')
            ->leftJoin((new CategorySong)->getTable() . ' AS cts', 'ct.id', '=', 'cts.cid')
            ->groupBy('ct.id')
            ->get(['ct.*', DB::raw('count(cts.id) as songCount')])->toArray();

        Cache::put($cacheName, $data, (60 * 60));
        return $data;
    }

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

        $data = self::query()->from((new self)->getTable(), 'ct')
            ->join((new CategorySong)->getTable() . ' AS cts', 'ct.id', '=', 'cts.cid')
            ->join((new Song)->getTable() . ' AS sg', 'sg.id', '=', 'cts.sid')
            ->join((new Artist)->getTable() . ' AS at', 'sg.aid', '=', 'at.id')
            ->where('ct.id', $id)
            ->get([
                'sg.*',
                'at.id AS artistID',
                'at.name as artistName'
            ])->toArray();

        Cache::put($cacheName, $data, (60 * 60));
        return $data;
    }
}
