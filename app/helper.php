<?php

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}


/**
 * 文本去除html标签，生成摘要
 *
 * @param $content 文本内容
 * @param int $length 摘要长度
 * @return string 摘要
 */
function makeExcerpt($content, $length = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($content)));
    return str_limit($excerpt, $length);
}


/**
 * 随机返回一个日期时间
 *
 * @param mixed $years 年数或Carbon实例
 * @return \Carbon\Carbon 实例
 */
function fakeDateTime($years = -10)
{
    $diff = $years instanceof \Carbon\Carbon ? strtotime($years) - time() : $years * 365 * 24 * 60 * 60;

    return now()->addSeconds($diff >= 0 ? mt_rand(0, $diff) : mt_rand($diff, 0));
}


/**
 * 返回带命名空间的模型全名
 *
 * @param $name 模型名
 * @return string 模型全名
 */
function modelFullName($name)
{
    return strpos($name, '\\') === false ? 'App\Models\\'.ucfirst($name) : $name;
}