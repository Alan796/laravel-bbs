<?php

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}


/**
 * 随机返回一个日期时间
 * @param mixed $years 年数或Carbon实例
 * @return \Carbon\Carbon 实例
 */
function fakeDateTime($years = -10)
{
    $diff = $years instanceof \Carbon\Carbon ? strtotime($years) - time() : $years * 365 * 24 * 60 * 60;

    return now()->addSeconds($diff >= 0 ? mt_rand(0, $diff) : mt_rand($diff, 0));
}