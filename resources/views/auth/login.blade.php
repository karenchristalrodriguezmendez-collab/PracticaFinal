@extends('layouts.app')

@push('styles')
<style>
    /* Premium Login Styles */
    .login-container {
        min-height: calc(100vh - 200px); /* Adjust based on navbar/footer height */
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
        padding: 40px 0;
    }

    .login-wrapper {
        display: flex;
        width: 100%;
        max-width: 1000px;
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    }

    .login-sidebar {
        flex: 1;
        background-image: url('https://images.unsplash.com/photo-1612817288484-6f916006741a?auto=format&fit=crop&q=80&w=2070');
        background-size: cover;
        background-position: center;
        position: relative;
        min-height: 500px;
    }

    .login-sidebar-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 40px;
        background: linear-gradient(to top, rgba(88, 98, 74, 0.8), transparent);
        color: white;
    }

    .login-form-side {
        flex: 1;
        padding: 60px 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .login-title {
        font-family: 'Outfit', sans-serif;
        color: #58624A;
        font-weight: 700;
        margin-bottom: 10px;
        font-size: 2rem;
    }

    .login-subtitle {
        color: #6c757d;
        margin-bottom: 40px;
    }

    .form-control {
        border-radius: 12px;
        padding: 12px 20px;
        border: 1px solid #e1e4e1;
        background-color: #fcfdfc;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #58624A;
        box-shadow: 0 0 0 4px rgba(88, 98, 74, 0.1);
        background-color: #fff;
    }

    .form-label {
        font-weight: 600;
        color: #4a533e;
        margin-bottom: 8px;
    }

    .btn-login {
        background-color: #58624A;
        color: white;
        border: none;
        border-radius: 12px;
        padding: 14px;
        font-weight: 700;
        width: 100%;
        margin-top: 20px;
        transition: all 0.3s ease;
        letter-spacing: 0.5px;
    }

    .btn-login:hover {
        background-color: #4a533e;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(88, 98, 74, 0.3);
        color: white;
    }

    .forgot-link {
        color: #58624A;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.9rem;
        transition: color 0.3s ease;
    }

    .forgot-link:hover {
        color: #3d4433;
        text-decoration: underline;
    }

    .register-prompt {
        margin-top: 30px;
        font-size: 0.95rem;
        text-align: center;
        color: #6c757d;
    }

    .register-prompt a {
        color: #58624A;
        font-weight: 700;
        text-decoration: none;
    }

    .social-login {
        margin-top: 30px;
        padding-top: 30px;
        border-top: 1px solid #eee;
    }

    @media (max-width: 991.98px) {
        .login-sidebar {
            display: none;
        }
        .login-wrapper {
            max-width: 500px;
            margin: 0 20px;
        }
    }
</style>
@endpush

@section('content')
<div class="login-container">
    <div class="login-wrapper">
        <!-- Sidebar Image -->
        <div class="login-sidebar d-none d-lg-block">
            <div class="login-sidebar-overlay">
                <h3 class="fw-bold mb-2">Cuida tu piel, cuida tu esencia.</h3>
                <p class="mb-0 opacity-75">Productos naturales diseñados para realzar tu belleza de forma consciente.</p>
            </div>
        </div>

        <!-- Form Side -->
        <div class="login-form-side">
            <div class="text-center d-lg-none mb-4">
                <span class="fw-bold fs-3 text-brand-green" style="letter-spacing: 1px; font-family: 'Outfit', sans-serif;">EcoSkin</span>
            </div>
            
            <h1 class="login-title">Bienvenido</h1>
            <p class="login-subtitle">Introduce tus credenciales para acceder a tu cuenta.</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="form-label">{{ __('Correo Electrónico') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="ejemplo@correo.com">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <label for="password" class="form-label">{{ __('Contraseña') }}</label>
                        @if (Route::has('password.request'))
                            <a class="forgot-link" href="{{ route('password.request') }}">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="••••••••">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label text-muted" for="remember">
                            {{ __('Recordar mi sesión') }}
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-login">
                    {{ __('Iniciar Sesión') }}
                </button>

                <div class="register-prompt">
                    ¿No tienes una cuenta? <a href="{{ route('register') }}">Regístrate ahora</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
