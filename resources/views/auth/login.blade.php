<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - عيادات القافلة الطبية</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        * {
            font-family: 'Cairo', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }

        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }

        .login-header i {
            font-size: 4rem;
            margin-bottom: 15px;
        }

        .login-header h2 {
            font-weight: 700;
            margin: 0;
            font-size: 1.8rem;
        }

        .login-header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
        }

        .login-body {
            padding: 40px 30px;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .input-group-text {
            border-radius: 10px 0 0 10px;
            background: #f8f9fa;
            border: 2px solid #e0e0e0;
            border-left: none;
        }

        .input-group .form-control {
            border-radius: 0 10px 10px 0;
            border-right: none;
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }

        .alert {
            border-radius: 10px;
            border: none;
        }

        label {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <i class="bi bi-hospital"></i>
                <h2>عيادات القافلة الطبية</h2>
                <p>تسجيل الدخول</p>
            </div>

            <div class="login-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">البريد الإلكتروني</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email') }}" required autofocus
                                placeholder="example@clinic.com">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">كلمة المرور</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" required placeholder="••••••••">
                        </div>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember" style="font-weight: 400;">
                            تذكرني
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-login">
                        <i class="bi bi-box-arrow-in-left me-2"></i>
                        تسجيل الدخول
                    </button>
                </form>
            </div>
        </div>

        <div class="text-center mt-3 text-white">
            <small>© 2025 عيادات القافلة الطبية. جميع الحقوق محفوظة.</small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>