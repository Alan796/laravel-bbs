<?php

namespace App\Models;

use Baum\Node as Model;

class Reply extends Model
{
    use Traits\Scope;
    use Traits\Extensions\Baum;

    protected $fillable = ['body', 'post_id', 'reply_id'];

    protected $scoped = ['post_id'];

    protected $parentColumn = 'reply_id';

    protected $leftColumn = 'left_id';

    protected $rightColumn = 'right_id';


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function post()
    {
        return $this->belongsTo(Post::class);
    }


    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }
}
