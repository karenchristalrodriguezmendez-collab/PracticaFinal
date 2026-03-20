<x-layout>
    @section('css')
    <style>
        .product-detail-card {
            border: none;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            background: white;
            margin-top: -50px;
        }
        .nature-header {
            background: linear-gradient(rgba(45, 90, 39, 0.7), rgba(45, 90, 39, 0.5)), url('https://images.unsplash.com/photo-1515377905703-c4788e51af15?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80');
            height: 300px;
            background-size: cover;
            background-position: center;
        }
        .main-img {
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            width: 100%;
            height: 450px;
            object-fit: cover;
        }
        .ingredients-box {
            background-color: #f9fbf9;
            border-left: 5px solid var(--brand-green);
            padding: 20px;
            border-radius: 0 15px 15px 0;
            margin: 20px 0;
        }
        .price-tag {
            font-size: 2.5rem;
            color: var(--brand-green);
            font-weight: 800;
        }
        .organic-stamp {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            background: #e8f5e9;
            color: #2e7d32;
            border-radius: 50px;
            font-weight: 700;
            margin-bottom: 20px;
        }
    </style>
    @endsection

    <div class="nature-header"></div>

    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div class="product-detail-card p-4 p-md-5">
                    <div class="row">
                        <div class="col-md-6 mb-4 mb-md-0">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="main-img">
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success text-decoration-none">Productos</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $product->category ?? 'Cosmética' }}</li>
                                </ol>
                            </nav>

                            <h1 class="display-5 fw-bold text-dark mb-3">{{ $product->name }}</h1>
                            
                            @if($product->is_organic)
                            <div class="organic-stamp">
                                <i class="bi bi-leaf-fill"></i> 100% Orgánico
                            </div>
                            @endif

                            <div class="price-tag mb-4">${{ number_format($product->price, 2) }}</div>
                            
                            <p class="lead text-muted mb-4">{{ $product->description }}</p>

                            @if($product->ingredients)
                            <div class="ingredients-box">
                                <h5 class="fw-bold"><i class="bi bi-droplet-fill me-2"></i>Ingredientes Naturales</h5>
                                <p class="mb-0 italic">{{ $product->ingredients }}</p>
                            </div>
                            @endif

                            <div class="d-flex align-items-center gap-3 mt-4">
                                <span class="text-muted">Disponibilidad: </span>
                                <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }} rounded-pill p-2 px-3">
                                    {{ $product->stock > 0 ? $product->stock . ' en stock' : 'Agotado' }}
                                </span>
                            </div>

                            <div class="mt-5 d-flex gap-3">
                                <form action="{{ route('cart.add') }}" method="POST" class="flex-grow-1">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="btn btn-success btn-lg w-100 rounded-pill py-3 shadow">
                                        <i class="bi bi-cart-plus me-2"></i> Añadir al Carrito
                                    </button>
                                </form>
                                @can('admin')
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-primary btn-lg rounded-circle px-3">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
