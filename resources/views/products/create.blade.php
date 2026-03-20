<x-layout>
    @section('css')
    <style>
        body {
            background-color: #f8fafc;
        }
        .form-container {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 15px;
        }
        .form-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 30px;
        }
        .form-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.03);
        }
        .section-subtitle {
            font-size: 1.25rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 25px;
        }
        .label-custom {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #475569;
            font-size: 0.9rem;
        }
        .label-custom span {
            color: #f87171;
        }
        .input-custom {
            width: 100%;
            padding: 12px 18px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            background: #fbfcfe;
            color: #1e293b;
            font-size: 0.95rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .input-custom:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .input-group-custom {
            display: flex;
            align-items: center;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            background: #fbfcfe;
            overflow: hidden;
        }
        .input-group-text-custom {
            padding: 12px 18px;
            background: white;
            color: #94a3b8;
            border-right: 1px solid #e2e8f0;
            font-size: 1.1rem;
        }
        .input-group-custom .input-custom {
            border: none;
            background: transparent;
        }
        .file-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            background: #fbfcfe;
            overflow: hidden;
            width: 100%;
        }
        .file-input-btn {
            padding: 12px 20px;
            background: #f1f5f9;
            color: #475569;
            border-right: 1px solid #e2e8f0;
            font-weight: 500;
            cursor: pointer;
            white-space: nowrap;
        }
        .file-input-text {
            padding: 12px 18px;
            color: #94a3b8;
            font-size: 0.9rem;
            flex-grow: 1;
        }
        .hidden-file {
            position: absolute;
            left: 0; top: 0; width: 100%; height: 100%;
            opacity: 0; cursor: pointer;
        }
        .form-hint {
            font-size: 0.8rem;
            color: #94a3b8;
            margin-top: 8px;
        }
        .textarea-custom {
            width: 100%;
            padding: 15px 18px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            background: #fbfcfe;
            min-height: 120px;
            resize: vertical;
        }
        .form-actions {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 25px;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid #f1f5f9;
        }
        .btn-cancel {
            color: #64748b;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.2s;
        }
        .btn-cancel:hover {
            color: #334155;
        }
        .btn-submit {
            background-color: #2563eb;
            color: white;
            padding: 14px 35px;
            border-radius: 50px;
            font-weight: 600;
            border: none;
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
            transition: all 0.2s;
        }
        .btn-submit:hover {
            background-color: #1d4ed8;
            transform: translateY(-2px);
        }
    </style>
    @endsection

    <div class="form-container">
        <h1 class="form-title">Agregar Producto</h1>

        <div class="form-card">
            <h2 class="section-subtitle">Información General</h2>

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-4">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label class="label-custom">Nombre del Producto <span>*</span></label>
                        <input type="text" name="name" class="input-custom" placeholder="Ej. Crema Hidratante" required value="{{ old('name') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="label-custom">Categoría <span>*</span></label>
                        <select name="category" class="input-custom" required>
                            <option value="">Selecciona una opción...</option>
                            <option value="Bálsamos labiales">Bálsamos labiales</option>
                            <option value="Cremas naturales" selected>Cremas naturales</option>
                            <option value="Jabones artesanales">Jabones artesanales</option>
                            <option value="Mascarillas en polvo">Mascarillas en polvo</option>
                            <option value="Accesorios y empaques eco">Accesorios y empaques eco</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="label-custom">Precio <span>*</span></label>
                        <div class="input-group-custom">
                            <span class="input-group-text-custom">$</span>
                            <input type="number" step="0.01" name="price" class="input-custom" placeholder="0.00" required value="{{ old('price') }}">
                        </div>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="label-custom">Stock Inicial <span>*</span></label>
                        <input type="number" name="stock" class="input-custom" placeholder="1" required value="{{ old('stock', 1) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="label-custom">Imagen del Producto</label>
                        <div class="file-input-wrapper">
                            <div class="file-input-btn">Elegir archivo</div>
                            <div class="file-input-text" id="file-name">No se ha seleccionado ningún archivo</div>
                            <input type="file" name="image" class="hidden-file" id="image-input" accept="image/*">
                        </div>
                        <p class="form-hint">Formatos: JPG, PNG, JPEG. Máx 2MB.</p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <label class="label-custom">Descripción</label>
                        <textarea name="description" class="textarea-custom" placeholder="Describe brevemente el producto...">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <div class="form-check form-switch custom-switch">
                            <input class="form-check-input" type="checkbox" name="is_organic" id="is_organic" value="1" {{ old('is_organic') ? 'checked' : '' }}>
                            <label class="form-check-label ms-2 fw-semibold text-secondary" for="is_organic">¿Es un producto orgánico?</label>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('products.index') }}" class="btn-cancel">Cancelar</a>
                    <button type="submit" class="btn-submit">Guardar Producto</button>
                </div>
            </form>
        </div>
    </div>

    @section('js')
    <script>
        document.getElementById('image-input').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'No se ha seleccionado ningún archivo';
            document.getElementById('file-name').textContent = fileName;
        });
    </script>
    @endsection
</x-layout>
