<?php

namespace App\Models\Traits;

use DB;
use Redis;

trait LastActive
{
    private $last_active_at_hash_table = 'user_last_active_at';

    public function getLastActiveAtHashFieldAttribute($value)
    {
        return $this->id;
    }


    public function getLastActiveAtAttribute($value)
    {
        return Redis::hExists($this->last_active_at_hash_table, $this->last_active_at_hash_field) ?
            Redis::hGet($this->last_active_at_hash_table, $this->last_active_at_hash_field) : $value;
    }


    public function setLastActiveAtAttribute($value)
    {
        Redis::hSet($this->last_active_at_hash_table, $this->last_active_at_hash_field, $value);
    }


    public function syncLastActiveAtCacheToDatabase()
    {
        $data = Redis::hGetAll($this->last_active_at_hash_table);

        $sql = 'update `users` set last_active_at = case id ';
        foreach ($data as $user_id => $last_active_at) {
            $sql .= 'when '.$user_id.' then "'.$last_active_at.'" ';
        }
        $sql .= 'else last_active_at end';

        DB::update($sql);
    }
}