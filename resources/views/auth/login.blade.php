<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Absensi Sekolah</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="login-container">
        <h2>Sistem Absensi</h2>
        
        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.process') }}" method="POST">
            @csrf <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required placeholder="admin@sekolah.com">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" class="btn-login">Masuk</button>
        </form>
    </div>
</body>
</html>