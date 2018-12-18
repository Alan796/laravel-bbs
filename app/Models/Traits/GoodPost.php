<?php

namespace App\Models\Traits;

use DB;
use Auth;

trait GoodPost
{
    private $viewScore = 1; //一次浏览得1分
    private $likeScore = 100;   //一次点赞得100分
    private $replyScore = 10;   //一次评论得10分
    private $replyLikeScore = 10;   //一次评论的点赞得10分

    private $goodScore = 10000; //总分达到该分值时为精品贴

    private $posts = [];

    public function censusGoodPosts()
    {
        $this->censusViewAndLikeAndReplyScore();
        $this->censusReplyLikeScore();

        foreach ($this->posts as $post_id => $score) {
            if ($score >= $this->goodScore) {
                self::find($post_id)->setGood();
            }
        }
    }


    private function censusViewAndLikeAndReplyScore()
    {
        $data = DB::table('posts')
            ->select(['id', 'view_count', 'like_count', 'reply_count'])
            ->where('is_good', false)
            ->get();

        foreach ($data as $v) {
            if (!isset($this->posts[$v->id])) {
                $this->posts[$v->id] = 0;
            }

            $this->posts[$v->id] += $v->view_count * $this->viewScore + $v->like_count * $this->likeScore + $v->reply_count * $this->replyScore;
        }
    }


    private function censusReplyLikeScore()
    {
        $data = DB::table('replies')
            ->select(DB::raw('post_id, sum(replies.like_count) as like_count'))
            ->leftJoin('posts', 'replies.post_id', '=', 'posts.id')
            ->where('is_good', false)
            ->groupBy('post_id')
            ->get();

        foreach ($data as $v) {
            if (!isset($this->posts[$v->post_id])) {
                $this->posts[$v->post_id] = 0;
            }

            $this->posts[$v->post_id] += $v->like_count * $this->replyLikeScore;
        }
    }





    public function setGood()
    {
        $this->is_good = true;
        $this->set_good_at = now()->toDateTimeString();
        $this->set_good_by = Auth::check() ? Auth::user()->name : '系统';
        $this->save();
    }


    public function revokeGood()
    {
        $this->is_good = false;
        $this->set_good_at = null;
        $this->set_good_by = null;
        $this->save();
    }
}