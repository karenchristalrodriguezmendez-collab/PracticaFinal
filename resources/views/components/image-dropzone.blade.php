{{-- Ejemplo de uso:
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

--}}

@props([
    'name' => 'image',
    'id' => null,
    'currentImage' => null,
    'currentImages' => [],
    'currentImageAlt' => '',
    'required' => false,
    'multiple' => false,
    'maxSize' => 5,
    'accept' => 'image/*',
    'allowedTypes' => ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml', 'image/webp'],
    'showCurrentImage' => true,
    'currentimageclass' => 'col-12',
    'dropzoneclass' => 'col-12',
    'dropzoneHeight' => '200px',
    'title' => 'Arrastra tu imagen aquí',
    'subtitle' => 'o haz clic para seleccionar',
    'helpText' => 'Formatos: JPG, PNG, GIF, SVG, WEBP',
    'error' => null
])

@php
    $componentId = $id ?? 'imageDropzone_' . \Str::random(8);
    $inputId = $componentId . '_input';
    $dropzoneId = $componentId . '_dropzone';
    $contentId = $componentId . '_content';
    $previewId = $componentId . '_preview';
    $previewImageId = $componentId . '_previewImage';
    $overlayId = $componentId . '_overlay';
    $removeBtnId = $componentId . '_remove';
    $changeBtnId = $componentId . '_change';
    $maxSizeBytes = $maxSize * 1024 * 1024;

    // Asegurar que allowedTypes sea un array
    $allowedTypesArray = is_array($allowedTypes) ? $allowedTypes : ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml', 'image/webp'];
@endphp

{{-- <div class="" data-image-dropzone-component="{{ $componentId }}"> --}}
    <!-- Mostrar imágenes actuales si existen -->
    @if($showCurrentImage && ($currentImage || !empty($currentImages)))
        <div class="{{ $currentimageclass }} mb-3">
            <label class="form-label text-muted mb-2">
                <i class="bi bi-image-fill text-primary me-2"></i>Imágenes actuales:
            </label>
            <div class="d-flex flex-wrap gap-2">
                @if($currentImage && empty($currentImages))
                    <div class="card border-0 shadow-sm position-relative overflow-hidden" style="width: 100px; height: 100px;">
                        <img src="{{ $currentImage }}"
                             alt="{{ $currentImageAlt }}"
                             class="w-100 h-100 object-fit-cover rounded">
                    </div>
                @endif

                @foreach($currentImages as $img)
                    <div class="card border-0 shadow-sm position-relative overflow-hidden" style="width: 100px; height: 100px;">
                        <img src="{{ asset('storage/' . $img->image_path) }}"
                             alt="Imagen de producto"
                             class="w-100 h-100 object-fit-cover rounded">
                        <div class="position-absolute top-0 end-0 p-1">
                            <button type="button" class="btn btn-danger btn-xs rounded-circle p-1 leading-none delete-existing-img"
                                    data-id="{{ $img->id }}" style="width: 20px; height: 20px; font-size: 10px;">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Campo de imagen con drag & drop -->
    <div class="{{ $dropzoneclass }}">
        <div id="{{ $dropzoneId }}"
             class="border border-2 border-dashed border-secondary rounded-3 p-4 text-center bg-light position-relative image-dropzone {{ $error ? 'border-danger' : '' }}"
             style="min-height: {{ $dropzoneHeight }}; cursor: pointer; transition: all 0.3s ease;">

            <div id="{{ $contentId }}" class="d-flex flex-column align-items-center justify-content-center h-100 dropzone-content">
                <div class="mb-3">
                    <i class="bi bi-cloud-upload display-1 text-primary dropzone-icon"></i>
                </div>
                <h5 class="text-primary fw-bold mb-2">{{ $title }}</h5>
                <p class="text-muted mb-2">{{ $subtitle }}</p>
                <small class="text-muted">{{ $helpText }} (máx. {{ $maxSize }}MB por imagen)</small>
            </div>

            <!-- Contenedor para múltiples vistas previas -->
            <div id="{{ $previewId }}" class="d-none d-flex flex-wrap gap-3 justify-content-center w-100 h-100">
                <!-- Se llenará vía JS -->
            </div>
        </div>

        <div class="mt-2 d-none" id="{{ $componentId }}_actions">
            <button type="button" id="{{ $removeBtnId }}" class="btn btn-danger btn-sm rounded-pill px-3">
                <i class="bi bi-trash-fill me-1"></i> Eliminar todas
            </button>
            <button type="button" id="{{ $changeBtnId }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 ms-2">
                <i class="bi bi-plus-circle-fill me-1"></i> Agregar más
            </button>
        </div>

        <!-- Input file oculto -->
        <input type="file"
               id="{{ $inputId }}"
               name="{{ $name }}{{ $multiple ? '[]' : '' }}"
               accept="{{ $accept }}"
               class="d-none"
               {{ $required ? 'required' : '' }}
               {{ $multiple ? 'multiple' : '' }}
               {{ $attributes }}>

        <!-- Mensaje de error -->
        @if($error)
            <div class="invalid-feedback d-block">
                {{ $error }}
            </div>
        @endif
    </div>

    @push('styles')
        <style>
            /* Efecto hover para el dropzone */
            [data-image-dropzone-component="{{ $componentId }}"] .image-dropzone:hover {
                border-color: #0d6efd !important;
                background-color: rgba(13, 110, 253, 0.05) !important;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            }

            /* Estado dragover */
            [data-image-dropzone-component="{{ $componentId }}"] .image-dropzone.dragover {
                border-color: #0d6efd !important;
                background-color: rgba(13, 110, 253, 0.1) !important;
                box-shadow: 0 0 20px rgba(13, 110, 253, 0.3);
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            $(document).ready(function() {
                const $dropzone = $('#{{ $dropzoneId }}');
                const $imageInput = $('#{{ $inputId }}');
                const $dropzoneContent = $('#{{ $contentId }}');
                const $imagePreviewArea = $('#{{ $previewId }}');
                const $removeImageBtn = $('#{{ $removeBtnId }}');
                const $changeImageBtn = $('#{{ $changeBtnId }}');
                const $actions = $('#{{ $componentId }}_actions');

                let selectedFiles = [];

                const config = {
                    allowedTypes: {!! json_encode($allowedTypesArray) !!},
                    maxSize: {{ $maxSizeBytes }},
                    multiple: {{ $multiple ? 'true' : 'false' }}
                };

                $dropzone.on('click', function(e) {
                    if (!$(e.target).closest('button').length) {
                        $imageInput.click();
                    }
                });

                $imageInput.on('change', function(e) {
                    processFiles(e.target.files);
                });

                $dropzone.on('dragover', function(e) {
                    e.preventDefault();
                    $(this).addClass('dragover');
                }).on('dragleave', function(e) {
                    e.preventDefault();
                    $(this).removeClass('dragover');
                }).on('drop', function(e) {
                    e.preventDefault();
                    $(this).removeClass('dragover');
                    processFiles(e.originalEvent.dataTransfer.files);
                });

                function processFiles(files) {
                    if (!config.multiple) {
                        selectedFiles = [files[0]];
                    } else {
                        Array.from(files).forEach(file => {
                            if (!selectedFiles.some(f => f.name === file.name && f.size === file.size)) {
                                selectedFiles.push(file);
                            }
                        });
                    }
                    updateInputFiles();
                    renderPreviews();
                }

                function updateInputFiles() {
                    const dt = new DataTransfer();
                    selectedFiles.forEach(file => dt.items.add(file));
                    $imageInput[0].files = dt.files;
                }

                function renderPreviews() {
                    $imagePreviewArea.empty();
                    if (selectedFiles.length === 0) {
                        $imagePreviewArea.addClass('d-none');
                        $dropzoneContent.show();
                        $actions.addClass('d-none');
                        return;
                    }

                    $dropzoneContent.hide();
                    $imagePreviewArea.removeClass('d-none');
                    $actions.removeClass('d-none');

                    selectedFiles.forEach((file, index) => {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const html = `
                                <div class="position-relative" style="width: 120px; height: 120px;">
                                    <img src="${e.target.result}" class="w-100 h-100 object-fit-cover rounded border shadow-sm">
                                    <button type="button" class="btn btn-danger btn-xs rounded-circle position-absolute top-0 end-0 m-n1 remove-preview"
                                            data-index="${index}" style="width: 22px; height: 22px; padding: 0;">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                            `;
                            $imagePreviewArea.append(html);
                        };
                        reader.readAsDataURL(file);
                    });
                }

                $(document).on('click', '.remove-preview', function(e) {
                    e.stopPropagation();
                    const index = $(this).data('index');
                    selectedFiles.splice(index, 1);
                    updateInputFiles();
                    renderPreviews();
                });

                $removeImageBtn.on('click', function() {
                    selectedFiles = [];
                    updateInputFiles();
                    renderPreviews();
                });

                $changeImageBtn.on('click', function() {
                    $imageInput.click();
                });

                $('.delete-existing-img').on('click', function() {
                    const id = $(this).data('id');
                    const $card = $(this).closest('.card');
                    if (confirm('¿Desea eliminar esta imagen permanentemente?')) {
                        // Aquí podrías agregar un campo oculto para marcar como eliminada
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'deleted_images[]',
                            value: id
                        }).appendTo($card.closest('form'));
                        $card.parent().fadeOut();
                    }
                });
            });
        </script>
    @endpush
{{-- </div> --}}

