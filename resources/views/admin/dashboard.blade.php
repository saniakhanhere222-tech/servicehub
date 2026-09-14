<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>

    <h1>Admin Dashboard</h1>

    <p>Welcome! You can manage the ServiceHub platform here.</p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button type="submit">
            Logout
        </button>
    </form>

</body>
</html>