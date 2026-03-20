<x-layout>
    @section('css')
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Inter', sans-serif;
        }
        .catalog-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }
        .page-title {
            font-size: 2rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 2rem;
        }
        
        /* Category Filters */
        .category-filters {
            display: flex;
            gap: 15px;
            overflow-x: auto;
            padding: 10px 5px;
            margin-bottom: 2rem;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .category-filters::-webkit-scrollbar {
            display: none;
        }
        .category-chip {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 25px;
            background: #ffffff;
            border-radius: 50px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            color: #58624A;
            font-weight: 500;
            white-space: nowrap;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            border: 1px solid transparent;
        }
        .category-chip:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08);
        }
        .category-chip.active {
            background-color: #58624A;
            color: white;
        }
        .category-icon {
            font-size: 1.2rem;
        }

        /* Search & Add */
        .action-bar {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            margin-bottom: 3rem;
        }
        .search-input-wrapper {
            position: relative;
            width: 100%;
            max-width: 400px;
        }
        .search-input {
            width: 100%;
            padding: 14px 25px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            background: white;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.2s;
        }
        .search-input:focus {
            border-color: #58624A;
        }
        .btn-add {
            background-color: #58624A;
            color: white;
            padding: 14px 30px;
            border-radius: 50px;
            font-weight: 600;
            border: none;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 15px -3px rgba(88, 98, 74, 0.3);
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-add:hover {
            background-color: #3d4433;
            transform: translateY(-2px);
            color: white;
        }

        /* Product Cards */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 25px;
        }
        .p-card {
            display: flex;
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            transition: transform 0.3s ease;
            height: 220px;
        }
        .p-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
        }
        .p-image-side {
            width: 40%;
            min-width: 150px;
            position: relative;
        }
        .p-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 15px;
            background: #fff;
        }
        .p-content-side {
            width: 60%;
            padding: 25px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .p-header {
            text-align: right;
        }
        .p-cat {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
            color: #f472b6;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
        .p-name {
            font-size: 1.4rem;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
        }
        .p-desc {
            color: #64748b;
            font-size: 0.95rem;
            margin: 10px 0;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-align: right;
        }
        .p-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #f1f5f9;
            padding-top: 15px;
        }
        .p-price {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0f172a;
        }
        .p-actions {
            display: flex;
            gap: 15px;
        }
        .action-icon {
            color: #3b82f6;
            font-size: 1.1rem;
            cursor: pointer;
            transition: color 0.2s;
            background: none;
            border: none;
            padding: 0;
        }
        .action-icon.edit { color: #60a5fa; }
        .action-icon.delete { color: #f87171; }
        .action-icon:hover { opacity: 0.7; }
    </style>
    @endsection

    <div class="catalog-container">
        <h2 class="page-title">Catálogo de Productos</h2>

        <div class="category-filters">
            <a href="?category=all" class="category-chip {{ request('category') == 'all' || !request('category') ? 'active' : '' }}">
                <span class="category-icon">🌿</span> Todos
            </a>
            <a href="?category=Bálsamos labiales" class="category-chip {{ request('category') == 'Bálsamos labiales' ? 'active' : '' }}">
                <span class="category-icon">💄</span> Bálsamos labiales
            </a>
            <a href="?category=Cremas naturales" class="category-chip {{ request('category') == 'Cremas naturales' ? 'active' : '' }}">
                <span class="category-icon">🧴</span> Cremas naturales
            </a>
            <a href="?category=Jabones artesanales" class="category-chip {{ request('category') == 'Jabones artesanales' ? 'active' : '' }}">
                <span class="category-icon">🧼</span> Jabones artesanales
            </a>
            <a href="?category=Mascarillas en polvo" class="category-chip {{ request('category') == 'Mascarillas en polvo' ? 'active' : '' }}">
                <span class="category-icon">🌺</span> Mascarillas en polvo
            </a>
        </div>

        <form action="{{ route('products.index') }}" method="GET" class="action-bar">
            <div class="search-input-wrapper">
                <input type="text" name="search" class="search-input" placeholder="Buscar producto..." value="{{ request('search') }}">
            </div>
            <a href="{{ route('products.create') }}" class="btn-add">
                <span>+ Agregar</span>
            </a>
        </form>

        <div class="product-grid">
            @foreach($products as $product)
                <div class="p-card">
                    <div class="p-image-side">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="p-image">
                    </div>
                    <div class="p-content-side">
                        <div class="p-header">
                            <div class="p-cat">
                                @if(Str::contains($product->category, 'labial')) 💄 @elseif(Str::contains($product->category, 'Crema')) 🧴 @else 🌿 @endif
                                {{ $product->name }}
                            </div>
                            <h3 class="p-name">{{ $product->name }}</h3>
                            <p class="p-desc">{{ $product->description }}</p>
                        </div>
                        <div class="p-footer">
                            <div class="p-price">${{ number_format($product->price, 2) }}</div>
                            <div class="p-actions">
                                <a href="{{ route('products.edit', $product) }}" class="action-icon edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="action-icon delete" onclick="confirmDelete('{{ route('products.destroy', $product) }}')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $products->links() }}
        </div>
    </div>

    @section('js')
    <script>
        function confirmDelete(url) {
            Swal.fire({
                title: '¿Eliminar producto?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f87171',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('<form>', {'action': url, 'method': 'POST'})
                    .append($('<input>', {type: 'hidden', name: '_token', value: '{{ csrf_token() }}'}))
                    .append($('<input>', {type: 'hidden', name: '_method', value: 'DELETE'}))
                    .appendTo('body')
                    .submit();
                }
            });
        }
    </script>
    @endsection
</x-layout>
