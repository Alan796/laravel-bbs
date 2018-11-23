<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'description'];


    public function posts()
    {
        return $this->hasMany(Post::class);
    }


    public static function cache()
    {
        return \Cache::forever('categories', $categories = self::all());
    }


    public static function allFromCache()
    {
        if (!$categories = \Cache::get('categories')) {
            $categories = self::cache();
        }

        return $categories;
    }
}
