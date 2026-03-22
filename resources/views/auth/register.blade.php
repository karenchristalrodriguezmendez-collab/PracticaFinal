@extends('layouts.app')

@push('styles')
<style>
    /* Premium Register Styles */
    .auth-container {
        min-height: calc(100vh - 200px);
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
        padding: 40px 0;
    }

    .auth-wrapper {
        display: flex;
        width: 100%;
        max-width: 1000px;
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    }

    .auth-sidebar {
        flex: 1;
        background-image: url('https://images.unsplash.com/photo-1570172619380-2aa061fa5230?auto=format&fit=crop&q=80&w=2070');
        background-size: cover;
        background-position: center;
        position: relative;
        min-height: 600px;
    }

    .auth-sidebar-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 40px;
        background: linear-gradient(to top, rgba(88, 98, 74, 0.8), transparent);
        color: white;
    }

    .auth-form-side {
        flex: 1;
        padding: 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .auth-title {
        font-family: 'Outfit', sans-serif;
        color: #58624A;
        font-weight: 700;
        margin-bottom: 10px;
        font-size: 2rem;
    }

    .auth-subtitle {
        color: #6c757d;
        margin-bottom: 30px;
    }

    .form-control {
        border-radius: 12px;
        padding: 10px 18px;
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
        margin-bottom: 6px;
        font-size: 0.9rem;
    }

    .btn-auth {
        background-color: #58624A;
        color: white;
        border: none;
        border-radius: 12px;
        padding: 14px;
        font-weight: 700;
        width: 100%;
        margin-top: 15px;
        transition: all 0.3s ease;
        letter-spacing: 0.5px;
    }

    .btn-auth:hover {
        background-color: #4a533e;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(88, 98, 74, 0.3);
        color: white;
    }

    .login-prompt {
        margin-top: 25px;
        font-size: 0.9rem;
        text-align: center;
        color: #6c757d;
    }

    .login-prompt a {
        color: #58624A;
        font-weight: 700;
        text-decoration: none;
    }

    @media (max-width: 991.98px) {
        .auth-sidebar {
            display: none;
        }
        .auth-wrapper {
            max-width: 500px;
            margin: 0 20px;
        }
        .auth-form-side {
            padding: 40px 30px;
        }
    }
</style>
@endpush

@section('content')
<div class="auth-container">
    <div class="auth-wrapper">
        <!-- Sidebar Image -->
        <div class="auth-sidebar d-none d-lg-block">
            <div class="auth-sidebar-overlay">
                <h3 class="fw-bold mb-2">Únete a nuestra comunidad.</h3>
                <p class="mb-0 opacity-75">Descubre una forma más natural de cuidar tu piel y el planeta.</p>
            </div>
        </div>

        <!-- Form Side -->
        <div class="auth-form-side">
            <div class="text-center d-lg-none mb-4">
                <span class="fw-bold fs-3 text-brand-green" style="letter-spacing: 1px; font-family: 'Outfit', sans-serif;">EcoSkin</span>
            </div>
            
            <h1 class="auth-title">Crear Cuenta</h1>
            <p class="auth-subtitle">Regístrate para empezar a disfrutar de beneficios exclusivos.</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('Nombre Completo') }}</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Tu nombre">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Correo Electrónico') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="ejemplo@correo.com">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Contraseña') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Mínimo 8 caracteres">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password-confirm" class="form-label">{{ __('Confirmar Contraseña') }}</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Repite tu contraseña">
                </div>

                <button type="submit" class="btn btn-auth">
                    {{ __('Registrarse') }}
                </button>

                <div class="login-prompt">
                    ¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
