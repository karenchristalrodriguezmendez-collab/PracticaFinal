<x-layout>
    <div class="container">
        <h1>{{ isset($user) ? 'Editar' : 'Agregar' }} usuario</h1>

        <form method='POST' action={{ isset($user) ? route('users.store') : route('users.store') }}
            class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ isset($user) ? $user->id : '' }}">
            
            <div class="col-md-6">
                <label for="name" class="form-label">Nombre</label>
                <input name="name" type="text"
                    class="form-control {{ $errors->has('name')? 'is-invalid' : ''}}" id="name"
                    value="{{ old('name', $user->name ?? '') }}" required maxlength="255">
                <div class="invalid-feedback">
                    {{ isset($errors) && $errors->has('name') ? $errors->first('name') : 'Campo requerido.' }}
                </div>
            </div>

            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input name="email" type="email"
                    class="form-control {{ $errors->has('email')? 'is-invalid' : ''}}" id="email"
                    value="{{ old('email', $user->email ?? '') }}" required maxlength="255">
                <div class="invalid-feedback">
                    {{ isset($errors) && $errors->has('email') ? $errors->first('email') : 'Campo requerido y debe ser un email válido.' }}
                </div>
            </div>

            <div class="col-md-6">
                <label for="password" class="form-label">Contraseña {{ isset($user) ? '(Dejar en blanco para mantener actual)' : '' }}</label>
                <input name="password" type="password"
                    class="form-control {{ $errors->has('password')? 'is-invalid' : ''}}" id="password"
                    {{ !isset($user) ? 'required' : '' }} minlength="8">
                <div class="invalid-feedback">
                    {{ isset($errors) && $errors->has('password') ? $errors->first('password') : 'Mínimo 8 caracteres.' }}
                </div>
            </div>

            <div class="col-md-6">
                <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                <input name="password_confirmation" type="password"
                    class="form-control" id="password_confirmation"
                    {{ !isset($user) ? 'required' : '' }} minlength="8">
            </div>

            <x-image-dropzone
                name="avatar"
                :current-image="isset($user) && $user->hasAvatar() ? $user->avatar_url : null"
                :current-image-alt="isset($user) ? $user->name : ''"
                :error="$errors->first('avatar')"
                currentimageclass="col-sm-4 col-md-5 col-lg-4"
                dropzoneclass="col-sm-8 col-md-7 col-lg-8"
                title="Arrastra tu avatar aquí"
                subtitle="o haz clic para seleccionar"
                help-text="Formatos: JPG, PNG, GIF, SVG, WEBP"
                :max-size="5"
                :show-current-image="true"
                dropzone-height="200px"
            />

            <div class="col-12">
                <button class="btn btn-primary" type="submit">Guardar Usuario</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
            </div>
        </form>
    </div>

    @section('styles')
        @stack('styles')
    @endsection()

    @section('js')
        <script>
            (function() {
                'use strict';
                var forms = document.querySelectorAll('.needs-validation');
                Array.prototype.slice.call(forms).forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
            })()
        </script>
        @stack('scripts')
    @endsection
</x-layout>
