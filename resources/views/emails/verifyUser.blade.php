<!DOCTYPE html>
<html>
<head>
    <title>Xác thực tài khoản AZA</title>
</head>
 
<body>
    <h2>AZA xin chào {{$user['name']}}</h2>
    <br/>
        Bạn vừa được tạo tài khoản trên hệ thống AZA với Email: {{$user['email']}} / Mật khẩu: {{$user['randomPassword']}}
    <br/>
        Làm ơn đăng nhập hệ thống để thay đổi mật khẩu sớm nhất có thể
    <br/>
    <!-- <br/>
    <a href="{{ url('user/verify', $user->verifyUser->token) }}">Xác thực >></a> -->
</body>
 
</html>