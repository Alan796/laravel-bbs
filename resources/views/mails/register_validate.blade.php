<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>注册确认</title>
    </head>
    <body>
        <h1>感谢您在 {{ config('app.name') }} 注册！</h1>

        <p>
            请在 {{ $expireAt }} 之前点击下面的链接完成注册：
            <a href="{{ route('users.validate_email', [$token, $email]) }}">
                {{ route('users.validate_email', [$token, $email]) }}
            </a>
        </p>

        <p>
            如果这不是您本人的操作，请忽略此邮件。
        </p>
    </body>
</html>