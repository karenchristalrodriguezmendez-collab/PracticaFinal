<x-layout>
    <div class="container">
        <h1>{{ isset($product) ? 'Editar' : 'Agregar' }} producto</h1>

        <form method='POST' action={{ url('/products') }}
            class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ isset($product) ? $product->id : '' }}">
            <div class="col-sm-8 col-md-8 col-lg-5">
                <label for="validationCustom01" class="form-label">Producto</label>
                <input name="name" type="text"
                    class="form-control {{ $errors->has('name')? 'is-invalid' : ''}}" id="validationCustom01"
                    value="{{ old('name', $product->name ?? '') }}" required maxlength="50">
                <div class="invalid-feedback">
                    {{ isset($errors) && $errors->has('name') ? $errors->first('name') : 'Campo requerido, máx. 40 caracteres.' }}
                </div>
            </div>
            <div class="col-sm-4 col-md-4 col-lg-2">
                <label for="validationCustomUsername" class="form-label">Precio</label>
                <div class="input-group has-validation">
                    <span class="input-group-text" id="inputGroupPrepend">$</span>
                    <input name="price" type="number" min="1" step=".01" max="9999999"
                        class="form-control {{ $errors->has('price')? 'is-invalid' : ''}}"
                    value="{{ old('price', $product->price ?? '') }}"
                    id="validationCustomUsername" aria-describedby="inputGroupPrepend" required>
                    <div class="invalid-feedback">
                        {{ isset($errors) && $errors->has('price') ? $errors->first('price') : 'Capture un precio válido' }}
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-8 col-lg-5">
                <label for="validationCustom02" class="form-label">Descripción</label>
                <textarea class="form-control {{ $errors->has('description')? 'is-invalid' : ''}}" name="description" id="validationCustom02" rows="3" required
                maxlength="100">{{ old('description', $product->description ?? '') }}</textarea>
                <div class="invalid-feedback">
                    {{ isset($errors) && $errors->has('description') ? $errors->first('description') : 'Campo requerido y debe tener como máx. 100 caracteres.' }}
                </div>
            </div>

            <x-image-dropzone
                name="image"
                :current-image="isset($product) && $product->hasImage() ? $product->image_url : null"
                :current-image-alt="isset($product) ? $product->name : ''"
                :error="$errors->first('image')"
                currentimageclass="col-sm-4 col-md-5 col-lg-4"
                dropzoneclass="col-sm-8 col-md-7 col-lg-8"
                title="Arrastra tu nueva imagen aquí"
                subtitle="o haz clic para seleccionar"
                help-text="Formatos: JPG, PNG, GIF, SVG, WEBP"
                :max-size="5"
                :show-current-image="true"
                dropzone-height="200px"
            />

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
