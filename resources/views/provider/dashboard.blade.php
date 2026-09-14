<!DOCTYPE html>
<html>
<head>
    <title>Provider Dashboard</title>
</head>
<body>

    <h1>Provider Dashboard</h1>

    <p>Welcome! You can manage your services and bookings here.</p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button type="submit">
            Logout
        </button>
    </form>

</body>
</html>