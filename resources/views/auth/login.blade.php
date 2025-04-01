<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="png" href="{{ asset('foto/del.png') }}">
    <title>SIPA</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="main-container">
        <div class="form-wrapper">
            <img src="{{ asset('foto/del.png') }}" alt="del">
            <h1>Institut Teknologi Del</h1>
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                    @foreach ($errors->all() as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="field">
                    <input class="inp" type="text" value="{{ old('username') }}" name="username" required autocomplete="off">
                    <label class="label" for="username">Username</label>
                    <span class="bi bi-person"></span>
                </div>
                <div class="field">
                    <input class="inp" type="password" name="password" id="password" required>
                    <label class="label" for="password">Password</label>
                    <span class="toggle-pass bi bi-eye"></span>
                </div>
                <div class="action">
                    <label for="save-info">
                        <input type="checkbox" id="save-info">
                        Stay signed in</label>
                </div>
                <input type="submit" value="Login" id="login-btn">
            </form>
        </div>
        <div class="bg"></div>
   </div>
</body>
<script>
    const input = document.querySelector('#password');
const icon = document.querySelector('.toggle-pass');
icon.addEventListener('click', () => {
    icon.classList.toggle('bi-eye-slash');
    icon.classList.toggle('bi-eye');
    input.type = (input.type === 'password') ? 'text' : 'password';
});
</script>
</html>
