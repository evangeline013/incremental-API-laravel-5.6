<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $guarded = [];

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
