<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * Get the Artist's songs.
     */
    public function songs()
    {
        return $this->hasMany('App\Models\Song', 'aid');
    }
}
