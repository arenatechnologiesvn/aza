<!DOCTYPE html>
<html>
<head>
    <title>Xác thực tài khoản AZA</title>
</head>
 
<body>
    <h2>Xin chào {{$user['name']}}</h2>
    <br/>
        Bạn vừa được tạo tài khoản hệ thống AZA là: Email: {{$user['email']}} / Mật khẩu: {{$user['randomPassword']}}
    <br/>
        Làm ơn click vào link bên dưới để xác thực tài khoản của bạn
    <br/>
    <br/>
    <a href="{{ url('user/verify', $user->verifyUser->token) }}">Xác thực >></a>
</body>
 
</html>