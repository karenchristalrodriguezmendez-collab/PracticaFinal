<x-layout>
    <div class="container">
        <h1>{{ isset($product) ? 'Editar' : 'Agregar' }} producto</h1>

        <form method='POST' action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}"
            class="row g-4 needs-validation" novalidate enctype="multipart/form-data">
            @csrf
            @if(isset($product))
                @method('PUT')
            @endif

            <div class="col-md-4">
                <label for="name" class="form-label fw-bold text-secondary">Producto</label>
                <input name="name" type="text"
                    class="form-control form-control-lg border-2 {{ $errors->has('name')? 'is-invalid' : ''}}" id="name"
                    value="{{ old('name', $product->name ?? '') }}" required placeholder="Nombre del producto">
                <div class="invalid-feedback">
                    {{ $errors->first('name') ?? 'Campo requerido.' }}
                </div>
            </div>

            <div class="col-md-2">
                <label for="price" class="form-label fw-bold text-secondary">Precio</label>
                <div class="input-group input-group-lg has-validation">
                    <span class="input-group-text bg-white border-2 border-end-0">$</span>
                    <input name="price" type="number" min="1" step=".01"
                        class="form-control form-control-lg border-2 border-start-0 {{ $errors->has('price')? 'is-invalid' : ''}}"
                        value="{{ old('price', $product->price ?? '') }}"
                        id="price" required placeholder="0.00">
                    <div class="invalid-feedback">
                        {{ $errors->first('price') ?? 'Precio válido requerido.' }}
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <label for="description" class="form-label fw-bold text-secondary">Descripción</label>
                <textarea class="form-control form-control-lg border-2 {{ $errors->has('description')? 'is-invalid' : ''}}"
                    name="description" id="description" rows="1" required
                    placeholder="Breve descripción del producto">{{ old('description', $product->description ?? '') }}</textarea>
                <div class="invalid-feedback">
                    {{ $errors->first('description') ?? 'Descripción requerida.' }}
                </div>
            </div>

            <div class="col-12">
                <x-image-dropzone
                    name="image"
                    :current-images="isset($product) ? $product->images : []"
                    :multiple="true"
                    :error="$errors->first('image')"
                    title="Arrastra tus imágenes aquí"
                    subtitle="puedes seleccionar varias fotos para el carrusel"
                    help-text="JPG, PNG, WEBP"
                    dropzone-height="250px"
                />
            </div>

            <div class="col-12">
                <button class="btn btn-primary" type="submit">Guardar Producto</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
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

                        form.classList.add('was-validated')
                    }, false)
                })
            })()
            // @if (session()->has('errors'))
            //     @foreach (session('errors')->all() as $error)
            //         console.log("{{ $error }}");
            //     @endforeach
            // @endif
            // Validaciones adicionales en tiempo real con jquery
            // --------------------------------------------------
            // $("#validationCustom01").keyup(function () {
            //     let length = $(this).val().length;
            //     console.log(length);
            //     if (length > 0 && length <= 40) {
            //         $(this).addClass("is-invalid");
            //     } else {
            //         $(this).removeClass("is-invalid");
            //     }
            // });

        </script>

        {{-- Scripts de componentes --}}
        @stack('scripts')
    @endsection
</x-layout>
