@extends('layouts.app')

@section('content')
<div class="container-fluid p-0 mb-5 mt-n4">
    <!-- Hero Banner -->
    <div class="hero-banner position-relative overflow-hidden" style="height: 450px; background: linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.2)), url('{{ asset('images/banner.png') }}'); background-size: cover; background-position: center;">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-md-6 text-white">
                    <span class="badge bg-white text-brand-green px-3 py-2 rounded-pill mb-3 fw-bold">NUEVA COLECCIÓN</span>
                    <h1 class="display-3 fw-bold mb-3">Naturalmente <br>Saludable</h1>
                    <p class="lead mb-4 shadow-sm text-shadow">Descubre nuestra selección premium de productos orgánicos y ecológicos para tu bienestar diario.</p>
                    <div class="d-flex gap-3">
                        <a href="#productos" class="btn btn-light btn-lg px-5 rounded-pill fw-bold text-brand-green">Ver Productos</a>
                        <a href="{{ route('companies.index') }}" class="btn btn-outline-light btn-lg px-5 rounded-pill fw-bold">Ver Marcas</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <!-- Categories Circle UI (Optional style) -->
    <div class="row mb-5 text-center g-4">
        <div class="col-6 col-md-2">
            <div class="cat-item shadow-sm rounded-circle p-4 mb-2 mx-auto" style="width: 100px; height: 100px; background: #f8faf8;">
                <i class="bi bi-droplet-fill fs-2 text-brand-green"></i>
            </div>
            <span class="fw-bold small">Aceites</span>
        </div>
        <div class="col-6 col-md-2">
            <div class="cat-item shadow-sm rounded-circle p-4 mb-2 mx-auto" style="width: 100px; height: 100px; background: #f8faf8;">
                <i class="bi bi-flower1 fs-2 text-brand-green"></i>
            </div>
            <span class="fw-bold small">Herbolaria</span>
        </div>
        <div class="col-6 col-md-2">
            <div class="cat-item shadow-sm rounded-circle p-4 mb-2 mx-auto" style="width: 100px; height: 100px; background: #f8faf8;">
                <i class="bi bi-egg-fill fs-2 text-brand-green"></i>
            </div>
            <span class="fw-bold small">Alimentos</span>
        </div>
        <div class="col-6 col-md-2">
            <div class="cat-item shadow-sm rounded-circle p-4 mb-2 mx-auto" style="width: 100px; height: 100px; background: #f8faf8;">
                <i class="bi bi-stars fs-2 text-brand-green"></i>
            </div>
            <span class="fw-bold small">Cosmética</span>
        </div>
        <div class="col-6 col-md-2">
            <div class="cat-item shadow-sm rounded-circle p-4 mb-2 mx-auto" style="width: 100px; height: 100px; background: #f8faf8;">
                <i class="bi bi-house-heart-fill fs-2 text-brand-green"></i>
            </div>
            <span class="fw-bold small">Hogar</span>
        </div>
        <div class="col-6 col-md-2">
            <div class="cat-item shadow-sm rounded-circle p-4 mb-2 mx-auto" style="width: 100px; height: 100px; background: #f8faf8;">
                <i class="bi bi-gift-fill fs-2 text-brand-green"></i>
            </div>
            <span class="fw-bold small">Regalos</span>
        </div>
    </div>

    <!-- Promo Card -->
    <div class="card border-0 rounded-4 mb-5 overflow-hidden shadow-sm" style="background-color: #f1f3f1;">
        <div class="row g-0 align-items-center">
            <div class="col-md-7 p-5">
                <h2 class="fw-bold mb-3">¡Sólo en la Web!</h2>
                <p class="mb-4">Consigue un 10% adicional en tu primer pedido usando el cupón <strong class="text-brand-green">YANA10</strong></p>
                <div class="d-flex align-items-center gap-3">
                    <span class="h1 mb-0 fw-bold text-brand-green">-10%</span>
                    <button class="btn btn-dark text-white rounded-pill px-4 py-2 fw-bold">Copiar Cupón</button>
                </div>
            </div>
            <div class="col-md-5 d-none d-md-block">
                <img src="{{ asset('images/promo_image.png') }}" alt="Promo" class="img-fluid h-100" style="object-fit: cover;">
            </div>
        </div>
    </div>

    <div id="productos" class="mt-5">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h3 class="fw-bold mb-0">Nuestros Productos</h3>
                <p class="text-muted small mb-0">Selección recomendada para ti</p>
            </div>
            <a href="#" class="text-brand-green fw-bold text-decoration-none small">Ver todos los productos <i class="bi bi-arrow-right"></i></a>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mb-5">
            @foreach($products as $product)
                <div class="col">
                    <div class="card h-100 shadow-hover border-0 rounded-4 overflow-hidden bg-white">
                        <!-- Image Carousel -->
                        <div class="swiper product-image-swiper">
                                <div class="swiper-wrapper">
                                    @if($product->images->count() > 0)
                                        @foreach($product->images as $image)
                                            <div class="swiper-slide">
                                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                                     class="card-img-top" 
                                                     alt="{{ $product->name }}"
                                                     style="height: 200px; object-fit: cover;">
                                            </div>
                                        @endforeach
                                    @else
                                        {{-- Fallback to legacy image or placeholder --}}
                                        <div class="swiper-slide">
                                            <img src="{{ $product->image_url ?? 'https://placehold.co/400x300?text=' . urlencode($product->name) }}" 
                                                 class="card-img-top" 
                                                 alt="{{ $product->name }}"
                                                 style="height: 200px; object-fit: cover;">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <!-- Swiper navigation arrows -->
                            <div class="swiper-button-next swiper-button-sm"></div>
                            <div class="swiper-button-prev swiper-button-sm"></div>
                            <div class="position-absolute top-0 end-0 p-3 z-index-10">
                                <button class="btn btn-white btn-sm rounded-circle shadow-sm" type="button"><i class="bi bi-heart text-brand-green"></i></button>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <p class="text-uppercase text-muted x-small mb-1 fw-bold tracking-wider">ECOSKIN NATURAL</p>
                            <h6 class="card-title fw-bold mb-2">{{ $product->name }}</h6>
                            <div class="d-flex align-items-center mb-3 text-warning small">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                                <span class="ms-1 text-muted">(4.5)</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 mb-0 fw-bold text-dark">${{ number_format($product->price, 2) }}</span>
                            </div>
                        </div>
                        <div class="card-footer-buttons d-flex gap-2">
                            <a href="{{ route('products.show', $product) }}" target="_blank" class="btn btn-outline-brand-green btn-sm rounded-pill flex-grow-1 fw-bold py-2">
                                <i class="bi bi-eye"></i> Detalles
                            </a>
                            @auth
                                <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form shadow-none flex-grow-1">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-brand-green btn-sm rounded-pill w-100 fw-bold text-white py-2">
                                        <i class="bi bi-cart-plus"></i> Añadir
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-brand-green btn-sm rounded-pill flex-grow-1 fw-bold text-white py-2">
                                    <i class="bi bi-cart-plus"></i> Añadir
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($products->isEmpty())
            <div class="card border-0 shadow-sm p-5 text-center my-5 rounded-4 bg-light">
                <div class="card-body">
                    <i class="bi bi-search fs-1 text-muted mb-3 d-block"></i>
                    <h3 class="fw-bold">No encontramos productos</h3>
                    <p class="text-muted">Estamos preparando nuestras mejores ofertas para ti. ¡Vuelve pronto!</p>
                </div>
            </div>
        @endif

        <div class="d-flex justify-content-center mt-5">
            {{ $products->appends(['search' => $search ?? ''])->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    .pagination-modern .page-link {
        border: none;
        color: #6c757d;
        margin: 0 2px;
        border-radius: 5px !important;
        transition: all 0.3s ease;
    }
    .pagination-modern .page-item.active .page-link {
        background-color: var(--brand-green);
        color: white;
        box-shadow: 0 4px 10px rgba(88, 98, 74, 0.3);
    }
    .pagination-modern .page-link:hover:not(.active) {
        background-color: #f8f9fa;
        color: var(--bs-primary);
    }

    /* Swiper custom styles */
    .product-image-swiper {
        position: relative;
    }
    .swiper-button-sm {
        width: 28px !important;
        height: 28px !important;
        background: rgba(255,255,255,0.8);
        border-radius: 50%;
        color: #58624A !important;
        opacity: 0;
        transition: opacity 0.3s;
    }
    .product-image-swiper:hover .swiper-button-sm {
        opacity: 1;
    }
    .swiper-button-sm:after {
        font-size: 12px !important;
        font-weight: bold;
    }
    .card-footer-buttons {
        background: transparent;
        border-top: 1px solid rgba(0,0,0,0.05);
        padding: 1rem;
    }
    .z-index-10 {
        z-index: 10;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize Swiper for each product card
    $('.product-image-swiper').each(function() {
        new Swiper(this, {
            slidesPerView: 1,
            spaceBetween: 0,
            navigation: {
                nextEl: $(this).find('.swiper-button-next')[0],
                prevEl: $(this).find('.swiper-button-prev')[0],
            },
            loop: true
        });
    });

    $('.add-to-cart-form').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const url = form.attr('action');
        const data = form.serialize();

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Update badge
                    let badge = $('#cart-badge');
                    if (badge.length === 0) {
                        $('.bi-cart3').parent().append('<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cart-badge">' + response.cart_count + '</span>');
                    } else {
                        badge.text(response.cart_count);
                    }
                    
                    // Visual feedback
                    const btn = form.find('button');
                    const originalHtml = btn.html();
                    
                    btn.html('<i class="bi bi-check-lg"></i> Listo')
                       .addClass('btn-success').removeClass('btn-brand-green');

                    setTimeout(() => {
                        btn.html(originalHtml)
                           .addClass('btn-brand-green').removeClass('btn-success');
                    }, 2000);
                }
            },
            error: function() {
                alert('Ocurrió un error al añadir el producto.');
            }
        });
    });

    @auth
        // Redireccionar si es necesario, pero manteniendo la navegación del carrusel funcional
    @endauth
});
</script>
@endpush
