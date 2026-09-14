<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

    <h1>Create Account</h1>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('register.store') }}">

        @csrf

        <label>Name</label>
        <input type="text" name="name">

        <br><br>

        <label>Email</label>
        <input type="email" name="email">

        <br><br>

        <label>Password</label>
        <input type="password" name="password">

        <br><br>

        <label>Confirm Password</label>
        <input type="password" name="password_confirmation">

        <p>I want to:</p>

        <label>
            <input
                type="radio"
                name="role"
                value="customer"
                {{ old('role', 'customer') === 'customer' ? 'checked' : '' }}
            >
            Book services
        </label>

        <br>

        <label>
            <input
                type="radio"
                name="role"
                value="provider"
                {{ old('role') === 'provider' ? 'checked' : '' }}
            >
            Offer my services
        </label>

        <br><br>

        <button type="submit">Register</button>

    </form>

    <p>Or</p>

    <a href="#" id="google-register">
        Continue with Google
    </a>

    <script>
        document.getElementById('google-register').addEventListener('click', function (event) {

            event.preventDefault();

            const selectedRole = document.querySelector('input[name="role"]:checked');

            if (!selectedRole) {
                alert('Please select what you want to do.');
                return;
            }

            window.location.href =
                "{{ route('google.redirect') }}" +
                "?from=register&role=" + selectedRole.value;
        });
    </script>

</body>
</html>

