<!DOCTYPE html>
<html>
<head>
    <title>Customer Dashboard</title>
</head>
<body>

    <h1>Customer Dashboard</h1>

    <p>Welcome! You can search and book services here.</p>
     <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button type="submit">
            Logout
        </button>
    </form>

</body>
</html>