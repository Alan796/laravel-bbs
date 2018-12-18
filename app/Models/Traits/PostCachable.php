<?php

namespace App\Models\Traits;

use DB;
use Redis;

trait PostCachable
{
    protected $view_count_hash_table = 'post_view_count';

    public function getViewCountHashFieldAttribute($value)
    {
        return $this->id;
    }


    public function setViewCountAttribute($value)
    {
        $view_count = Redis::hExists($this->view_count_hash_table, $this->view_count_hash_field) ? Redis::hGet($this->view_count_hash_table, $this->view_count_hash_field) : $value;
        Redis::hSet($this->view_count_hash_table, $this->view_count_hash_field, ++$view_count);
    }


    public function getViewCountAttribute($value)
    {
        if (!Redis::hExists($this->view_count_hash_table, $this->view_count_hash_field)) {
            Redis::hSet($this->view_count_hash_table, $this->view_count_hash_field, $value);
        }

        return Redis::hGet($this->view_count_hash_table, $this->view_count_hash_field);
    }


    public function syncCacheToDatabase()
    {
        $data = Redis::hGetAll($this->view_count_hash_table);

        $sql = 'update `posts` set view_count = case id ';
        foreach ($data as $post_id => $view_count) {
            $sql .= 'when '.$post_id.' then '.$view_count.' ';
        }
        $sql .= 'else view_count end';

        DB::update($sql);

        Redis::del($this->view_count_hash_table);
    }
}