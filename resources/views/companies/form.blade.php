<x-layout>
    <div class="container">
        <h1>{{ isset($company) ? 'Editar' : 'Agregar' }} Empresa</h1>

        <form method="POST" action={{ url('/companies') }} 
            class="row g-3 needs-validation" novalidate>
            @csrf
            <input type="hidden" name="id" value="{{ isset($company) ? $company->id : '' }}">
            
            <div class="col-sm-8 col-md-8 col-lg-5">
                <label for="validationCustom01" class="form-label">Nombre</label>
                <input name="name" type="text"
                    class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="validationCustom01"
                    value="{{ old('name', $company->name ?? '') }}" required maxlength="100">
                <div class="invalid-feedback">
                    {{ isset($errors) && $errors->has('name') ? $errors->first('name') : 'Campo requerido, máx. 100 caracteres.' }}
                </div>
            </div>

            <div class="col-sm-12 col-md-8 col-lg-5">
                <label for="validationCustom02" class="form-label">Descripción</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" 
                    name="description" id="validationCustom02" rows="3"
                    maxlength="255">{{ old('description', $company->description ?? '') }}</textarea>
                <div class="invalid-feedback">
                    {{ isset($errors) && $errors->has('description') ? $errors->first('description') : 'Máximo 255 caracteres.' }}
                </div>
            </div>

            <div class="col-12">
                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-save"></i> {{ isset($company) ? 'Actualizar' : 'Guardar' }} Empresa
                </button>
                <a href="{{ route('companies.index') }}" class="btn btn-secondary ms-2">
                    <i class="bi bi-x-lg"></i> Cancelar
                </a>
            </div>
        </form>
    </div>

    @section('styles')
        {{-- Estilos de componentes --}}
        @stack('styles')
    @endsection()

    @section('js')
        <script>
            // Validación de formulario Bootstrap
            (function() {
                'use strict';

                // Obtener todos los formularios que requieren validación
                var forms = document.querySelectorAll('.needs-validation');

                // Iterar y prevenir envío si hay campos inválidos
                Array.prototype.slice.call(forms).forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }

                        form.classList.add('was-validated');
                    }, false);
                });
            })();

            // Validaciones adicionales en tiempo real con jquery
            // --------------------------------------------------
            // $("#validationCustom01").keyup(function() {
            //     let length = $(this).val().length;
            //     if (length > 0 && length <= 100) {
            //         $(this).removeClass("is-invalid");
            //     } else {
            //         $(this).addClass("is-invalid");
            //     }
            // });

            // $("#validationCustom02").keyup(function() {
            //     let length = $(this).val().length;
            //     if (length <= 255) {
            //         $(this).removeClass("is-invalid");
            //     } else {
            //         $(this).addClass("is-invalid");
            //     }
            // });
        </script>
        {{-- Scripts de componentes --}}
        @stack('scripts')
    @endsection
</x-layout>
