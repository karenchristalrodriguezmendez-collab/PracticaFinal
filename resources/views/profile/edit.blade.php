@extends('layouts.app')

@push('styles')
<style>
    .profile-header {
        background: linear-gradient(135deg, #1C2833 0%, #2C3E50 100%);
        padding: 60px 0;
        margin-bottom: -50px;
        position: relative;
    }
    .profile-card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        background: #fff;
    }
    .avatar-upload-wrapper {
        position: relative;
        width: 140px;
        height: 140px;
        margin: 0 auto;
    }
    .avatar-preview {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        border: 4px solid #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        object-fit: cover;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .avatar-edit {
        position: absolute;
        right: 5px;
        bottom: 5px;
        z-index: 1;
    }
    .avatar-edit input {
        display: none;
    }
    .avatar-edit label {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        margin-bottom: 0;
        border-radius: 50%;
        background: #D4AF37;
        color: white;
        box-shadow: 0 4px 10px rgba(212, 175, 55, 0.4);
        cursor: pointer;
        transition: all 0.2s;
    }
    .avatar-edit label:hover {
        background: #c19b28;
        transform: scale(1.05);
    }
    .form-control {
        border-radius: 8px;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        background-color: #f8fafc;
        transition: all 0.2s;
    }
    .form-control:focus {
        border-color: #D4AF37;
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
        background-color: #fff;
    }
    .form-label {
        font-weight: 600;
        color: #475569;
        font-size: 0.9rem;
        margin-bottom: 8px;
    }
    .btn-gold {
        background-color: #D4AF37;
        color: white;
        font-weight: 600;
        border: none;
        transition: all 0.3s;
    }
    .btn-gold:hover {
        background-color: #c19b28;
        color: white;
        transform: translateY(-2px);
    }
</style>
@endpush

@section('content')
<div class="profile-header">
    <div class="container">
        <h1 class="text-white fw-light mb-0" style="font-family: 'Outfit', sans-serif;">Mi <span class="fw-bold">Perfil</span></h1>
        <p class="text-white-50 mt-2">Gestiona tu información personal y seguridad</p>
    </div>
</div>

<div class="container position-relative" style="z-index: 10;">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card profile-card p-4 p-md-5 mb-5">
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-left: 4px solid #16a34a;">
                        <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="text-center mb-5">
                        <div class="avatar-upload-wrapper">
                            <div class="avatar-edit">
                                <input type='file' id="avatar" name="avatar" accept=".png, .jpg, .jpeg" />
                                <label for="avatar"><i class="bi bi-camera"></i></label>
                            </div>
                            <div class="avatar-preview">
                                @if($user->hasAvatar())
                                    <img src="{{ $user->avatar_url }}" alt="Profile" id="avatarPreview" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <i class="bi bi-person text-muted" style="font-size: 4rem;"></i>
                                    <img src="" alt="Profile" id="avatarPreview" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                                @endif
                            </div>
                        </div>
                        <p class="text-muted small mt-3 mb-0">Formatos permitidos: JPG, PNG. Max: 2MB.</p>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="col-12 mt-4 pt-3 border-top">
                            <h5 class="fw-bold text-dark mb-4" style="font-family: 'Outfit', sans-serif;">Seguridad</h5>
                            <p class="text-muted small mb-4">Deja los campos de contraseña en blanco si no deseas cambiarla.</p>
                        </div>

                        <div class="col-md-6">
                            <label for="password" class="form-label">Nueva Contraseña</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" placeholder="••••••••">
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="••••••••">
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password_confirmation">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 text-end">
                        <a href="{{ route('home') }}" class="btn btn-light px-4 py-2 me-2">Cancelar</a>
                        <button type="submit" class="btn btn-gold px-5 py-2 rounded-0 text-uppercase" style="letter-spacing: 1px;">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Image preview
        const avatarInput = document.getElementById('avatar');
        const avatarPreview = document.getElementById('avatarPreview');
        const iconPlaceholder = document.querySelector('.avatar-preview .bi-person');
        
        avatarInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    avatarPreview.src = e.target.result;
                    avatarPreview.style.display = 'block';
                    if (iconPlaceholder) iconPlaceholder.style.display = 'none';
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Password visibility toggle
        const toggleButtons = document.querySelectorAll('.toggle-password');
        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = this.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
            });
        });
    });
</script>
@endpush
@endsection
