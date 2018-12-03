<?php

namespace App\Handlers;

use GuzzleHttp\Client;
use Overtrue\Pinyin\Pinyin;

class SlugTranslator
{
    public function translate($text)
    {
        $http = new Client;

        //初始化配置信息
        $api = 'http://api.fanyi.baidu.com/api/trans/vip/translate?';
        $appid = config('services.baidu_translate.appid');
        $key = config('services.baidu_translate.key');
        $salt = time();

        $sign = md5($appid.$text.$salt.$key);

        $query = http_build_query([
            'q' => $text,
            'from' => 'zh',
            'to' => 'en',
            'appid' => $appid,
            'salt' => $salt,
            'sign' => $sign,
        ]);

        $response = $http->get($api.$query);

        $result = json_decode($response->getBody(), true);

        return isset($result['trans_result'][0]['dst']) ? str_slug($result['trans_result'][0]['dst']) : $this->pinyin($text);
    }


    protected function pinyin($text)
    {
        return str_slug(app(Pinyin::class)->permalink($text));
    }
}