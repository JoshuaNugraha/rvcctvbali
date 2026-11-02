<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sign In - RV CCTV Bali</title>
    <!-- Favicon & Touch Icons -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <link rel="icon" type="image/png" sizes="64x64" href="{{ asset('favicon-64.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            background: linear-gradient(145deg, var(--burgundy-darkest) 0%, var(--burgundy-900) 40%, var(--burgundy-850) 100%);
        }
        .login-card {
            width: 100%;
            max-width: 440px;
            background: #FFFFFF;
            border-radius: var(--radius-card);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.45);
            padding: 2.5rem;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }
        .login-brand {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-brand .brand-monogram {
            width: 56px;
            height: 56px;
            font-size: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 8px 20px rgba(122, 23, 43, 0.35);
        }
        .login-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--burgundy-900);
            margin-bottom: 0.25rem;
        }
        .login-subtitle {
            font-size: 0.85rem;
            color: var(--text-muted);
        }
        .form-floating-custom {
            margin-bottom: 1.25rem;
        }
        .form-floating-custom label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 0.4rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .form-floating-custom input {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: var(--radius-btn);
            border: 1px solid var(--card-border);
            outline: none;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            background-color: #FAFAFA;
        }
        .form-floating-custom input:focus {
            border-color: var(--burgundy-600);
            background-color: #FFFFFF;
            box-shadow: 0 0 0 4px rgba(122, 23, 43, 0.12);
        }
        .login-btn {
            width: 100%;
            padding: 0.85rem;
            border-radius: var(--radius-btn);
            font-weight: 600;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            background-color: var(--burgundy-800);
            color: #FFFFFF;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(75, 12, 24, 0.3);
        }
        .login-btn:hover {
            background-color: var(--burgundy-700);
            transform: translateY(-1px);
        }
        .demo-credential-box {
            margin-top: 1.75rem;
            padding: 0.85rem 1rem;
            background-color: var(--canvas-bg);
            border-radius: var(--radius-btn);
            font-size: 0.8rem;
            border: 1px dashed var(--card-border);
            color: var(--text-muted);
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-brand">
                <img src="{{ asset('images/logo.jpg') }}" alt="RV CCTV Bali" style="width: 110px; height: auto; margin-bottom: 0.75rem; border-radius: 12px; background: #fff; padding: 6px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                <h1 class="login-title">RV CCTV Bali</h1>
                <p class="login-subtitle">Security Systems Administration Portal</p>
            </div>

            @if(session('successMessage'))
                <div class="alert alert-success py-2 px-3 mb-3" style="font-size: 0.85rem; border-radius: 8px;">
                    {{ session('successMessage') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger py-2 px-3 mb-3" style="font-size: 0.85rem; border-radius: 8px;">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="form-floating-custom">
                    <label for="loginInput">Email or Username</label>
                    <input type="text" id="loginInput" name="login" value="{{ old('login', 'admin') }}" required autofocus placeholder="admin or admin@admin.com">
                </div>

                <div class="form-floating-custom">
                    <label for="passwordInput">Password</label>
                    <input type="password" id="passwordInput" name="password" required value="admin123" placeholder="Enter your password">
                </div>

                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="rememberMe" checked>
                        <label class="form-check-label" for="rememberMe" style="font-size: 0.85rem; color: var(--text-muted);">
                            Remember me
                        </label>
                    </div>
                </div>

                <button type="submit" class="login-btn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                        <polyline points="10 17 15 12 10 7"></polyline>
                        <line x1="15" y1="12" x2="3" y2="12"></line>
                    </svg>
                    <span>Sign In to Admin Panel</span>
                </button>

                <div class="demo-credential-box">
                    <div class="fw-bold mb-1" style="color: var(--burgundy-900);">Default Access Credentials:</div>
                    <div>Username: <code>admin</code> or <code>admin@admin.com</code></div>
                    <div>Password: <code>admin123</code></div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
