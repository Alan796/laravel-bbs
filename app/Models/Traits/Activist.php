<?php

namespace App\Models\Traits;

use DB;
use Cache;
use App\Models\User;
use App\Models\Post;
use App\Models\Reply;

trait Activist
{
    private $postScore = 4;   //帖子分数
    private $goodPostScore = 10;  //精品帖分数
    private $replyScore = 1;  //评论分数
    private $pastDays = 90;    //统计过去几天
    private $activistsCount = 6;  //统计得出多少人

    private $cacheKey = 'users.activists';  //缓存键名
    private $cacheExpireInMinute = 65;    //缓存失效时间(分)，若更改，同时要改app/Console/Kernel.php的定时任务时间

    private $users = [];

    /**
     * 获取活跃用户集合
     */
    public function getActivists()
    {
        return Cache::remember($this->cacheKey, $this->cacheExpireInMinute, function() {
            return $this->censusAndGetActivists();
        });
    }


    /**
     * 统计活跃用户并缓存
     */
    public function censusActivistsAndCache()
    {
        $activists = $this->censusAndGetActivists();
        Cache::put($this->cacheKey, $activists, $this->cacheExpireInMinute);
    }


    /**
     * 统计得出活跃用户
     *
     * @return \Illuminate\Support\Collection 活跃用户集合
     */
    private function censusAndGetActivists()
    {
        $this->censusPostScore();
        $this->censusGoodPostScore();
        $this->censusReplyScore();

        $this->sort();

        $activists = collect(); //活跃用户集合
        $activistsCount = 0;
        foreach ($this->users as $user_id => $score) {
            if ($user = User::find($user_id)) {
                $activists->push($user);
                ++$activistsCount;

                if ($activistsCount >= $this->activistsCount) {
                    break;
                }
            }
        }

        return $activists;
    }


    /**
     * 统计帖子分数
     */
    private function censusPostScore()
    {
        $data = Post::query()
            ->select(DB::raw('user_id, count(*) as post_count'))
            ->where('is_good', false)
            ->where('created_at', '>=', now()->subDays($this->pastDays))
            ->groupBy('user_id')
            ->get();

        foreach ($data as $v) {
            //初始化分数
            if (!isset($this->users[$v->user_id])) {
                $this->users[$v->user_id] = 0;
            }

            $this->users[$v->user_id] += $v->post_count * $this->postScore;
        }
    }


    /**
     * 统计精品贴分数
     */
    private function censusGoodPostScore()
    {
        $data = Post::query()
            ->select(DB::raw('user_id, count(*) as good_post_count'))
            ->where('is_good', true)
            ->where('created_at', '>=', now()->subDays($this->pastDays))
            ->groupBy('user_id')
            ->get();

        foreach ($data as $v) {
            //初始化分数
            if (!isset($this->users[$v->user_id])) {
                $this->users[$v->user_id] = 0;
            }

            $this->users[$v->user_id] += $v->good_post_count * $this->goodPostScore;
        }
    }


    /**
     * 统计评论分数
     */
    private function censusReplyScore()
    {
        $data = Reply::query()
            ->select(DB::raw('user_id, count(*) as reply_count'))
            ->where('created_at', '>=', now()->subDays($this->pastDays))
            ->groupBy('user_id')
            ->get();

        foreach ($data as $v) {
            //初始化分数
            if (!isset($this->users[$v->user_id])) {
                $this->users[$v->user_id] = 0;
            }

            $this->users[$v->user_id] += $v->reply_count * $this->replyScore;
        }
    }


    /**
     * 用户集合按照分数高低排序
     */
    private function sort()
    {
        asort($this->users);
        $this->users = array_reverse($this->users, true);
    }
}