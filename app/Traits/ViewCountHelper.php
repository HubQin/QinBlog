<?php


namespace App\Traits;


use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;

trait ViewCountHelper
{
    public $viewCountPrefix = 'posts';

    public function incrViewCount($id)
    {
        $hash = sprintf($this->viewCountPrefix . 'view_count:%s', Carbon::now()->toDateString());
        Redis::hincrBy($hash, $id, 1);
        return Redis::hGet($hash, $id);
    }

    public function syncYesterdayViewCount()
    {
        $hash = sprintf($this->viewCountPrefix . 'view_count:%s', Carbon::yesterday()->toDateString());
        $data = Redis::hGetAll($hash);
        foreach ($data as $k => $v) {
            \DB::table('posts')->where('id', (int)$k)->increment('view_count', (int)$v);
        }
        Redis::del([$hash]);
    }
}
