<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

    <h1>Login</h1>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('login.store') }}">

        @csrf

        <label>Email</label>
        <input type="email" name="email">

        <br><br>

        <label>Password</label>
        <input type="password" name="password">

        <label>
    <input type="checkbox" name="remember" value="1">
    Remember me
</label>//laravek andrbuiltin remember ka token hta

        <br><br>

        <button type="submit">Login</button>

    </form>

   
    <p>Or</p>

   <a href="{{ route('google.redirect') }}">
    Continue with Google
  </a>

    <p>
        Don't have an account?
        <a href="{{ route('register') }}">Register</a>
    </p>

</body>
</html>