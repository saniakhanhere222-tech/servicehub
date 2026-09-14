<!DOCTYPE html>
<html>
<head>
    <title>Google Account</title>
</head>
<body>

    <h1>Google Account</h1>

    <p>
        {{ $message }}
    </p>

    <br>

    <a href="{{ route('google.redirect') }}">
        Try another Google account
    </a>

   
    <br><br>

    <a href="{{ route('login') }}">
        Login with email and password
    </a>

</body>
</html>