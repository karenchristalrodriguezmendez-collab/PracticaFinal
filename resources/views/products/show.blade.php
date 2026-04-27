@extends('layouts.app')

@push('styles')
<style>
    .product-detail-card {
        border: none;
        border-radius: 0;
        overflow: hidden;
        background: white;
    }
    .main-img-container {
        position: relative;
        overflow: hidden;
    }
    .main-img {
        width: 100%;
        height: 600px;
        object-fit: cover;
    }
    .ingredients-box {
        background-color: #f8fafc;
        border-left: 3px solid #D4AF37;
        padding: 25px;
        margin: 30px 0;
    }
    .price-tag {
        font-family: 'Outfit', sans-serif;
        font-size: 2.5rem;
        color: #1C2833;
        font-weight: 300;
    }
    .organic-stamp {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 8px 16px;
        background: #fffaf0;
        color: #D4AF37;
        font-size: 0.8rem;
        letter-spacing: 2px;
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 25px;
        border: 1px solid rgba(212, 175, 55, 0.2);
    }
    .breadcrumb-item a {
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .breadcrumb-item.active {
        color: #1C2833;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .availability-badge {
        font-size: 0.75rem;
        letter-spacing: 1px;
        text-transform: uppercase;
        padding: 8px 16px;
        border-radius: 0;
    }
</style>
@endpush

@section('content')
<div class="container py-5 mt-4">
    <nav aria-label="breadcrumb" class="mb-5">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Colección</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->category ?? 'Premium' }}</li>
        </ol>
    </nav>

    <div class="row g-5 align-items-center">
        <div class="col-lg-6">
            <div class="main-img-container shadow-sm">
                @if($product->hasImage())
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="main-img">
                @else
                    <img src="{{ 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?auto=format&fit=crop&q=80&w=800' }}" alt="{{ $product->name }}" class="main-img">
                @endif
            </div>
        </div>
        
        <div class="col-lg-6 ps-lg-5">
            @if($product->is_organic)
            <div class="organic-stamp">
                <i class="bi bi-star-fill small"></i> Esencia Natural
            </div>
            @endif

            <h1 class="display-4 fw-light text-dark mb-4" style="font-family: 'Outfit', sans-serif;">{{ $product->name }}</h1>
            
            <div class="price-tag mb-4">${{ number_format($product->price, 2) }}</div>
            
            <p class="lead text-muted mb-5" style="font-size: 1.1rem; line-height: 1.8;">{{ $product->description }}</p>

            <div class="d-flex align-items-center gap-3 mb-5 pb-4 border-bottom border-light">
                <span class="text-uppercase text-muted fw-bold" style="font-size: 0.75rem; letter-spacing: 1px;">Disponibilidad: </span>
                <span class="badge availability-badge {{ $product->stock > 0 ? 'bg-dark' : 'bg-danger' }}">
                    {{ $product->stock > 0 ? $product->stock . ' en stock' : 'Agotado' }}
                </span>
            </div>

            @if($product->ingredients)
            <div class="ingredients-box">
                <h6 class="fw-bold text-uppercase mb-3" style="font-size: 0.8rem; letter-spacing: 1px; color: #1C2833;"><i class="bi bi-stars me-2" style="color: #D4AF37;"></i>Ingredientes Clave</h6>
                <p class="mb-0 text-muted" style="line-height: 1.7; font-size: 0.95rem;">{{ $product->ingredients }}</p>
            </div>
            @endif

            <div class="mt-5 d-flex gap-3">
                <form action="{{ route('cart.add') }}" method="POST" class="flex-grow-1">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="input-group mb-4" style="width: 150px;">
                        <span class="input-group-text bg-white rounded-0 border-end-0 text-muted" style="border-color: #e2e8f0; font-size: 0.85rem;">Cant.</span>
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock > 0 ? $product->stock : 1 }}" class="form-control rounded-0 text-center shadow-none" style="border-color: #e2e8f0;">
                    </div>
                    
                    <button type="submit" class="btn btn-lg w-100 rounded-0 py-3 text-uppercase fw-bold shadow-sm" style="background-color: #1C2833; color: white; letter-spacing: 2px; font-size: 0.85rem; transition: all 0.3s;" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                        <i class="bi bi-cart-plus me-2"></i> {{ $product->stock > 0 ? 'Añadir al Carrito' : 'Sin Stock' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
