@extends('layouts.app')

@section('content')
<div class="container-fluid p-0 mb-5 mt-n4">
    <!-- Hero Banner Elegant -->
    <div class="hero-section position-relative overflow-hidden d-flex align-items-center" style="min-height: 650px; background: url('{{ asset('images/elegant_hero_banner.png') }}') center/cover no-repeat;">
        <div class="hero-overlay position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(90deg, rgba(252,252,252,0.85) 0%, rgba(252,252,252,0.4) 50%, rgba(252,252,252,0) 100%);"></div>
        
        <div class="container position-relative z-index-1">
            <div class="row">
                <div class="col-lg-6">
                    <div class="hero-content p-4 animate-fade-in-up">
                        <p class="text-uppercase mb-3 fw-bold tracking-wider" style="color: #D4AF37; letter-spacing: 3px; font-size: 0.85rem;">Esencia de Lujo</p>
                        <h1 class="display-3 fw-light mb-4 text-dark" style="font-family: 'Outfit', sans-serif; line-height: 1.2;">
                            Belleza Pura <br><span class="fw-bold" style="color: #1C2833;">y Elegante</span>
                        </h1>
                        <p class="lead mb-5 fw-normal" style="max-width: 480px; color: #4A5568; font-size: 1.1rem; line-height: 1.6;">
                            Descubre nuestra exclusiva colección de cosmética premium. Ingredientes de la más alta calidad seleccionados para realzar tu belleza natural.
                        </p>
                        <div class="d-flex flex-wrap gap-4 animate-fade-in-delay">
                            <a href="#productos" class="btn btn-brand-green px-5 py-3 rounded-0 text-uppercase shadow-hover-vibrant" style="letter-spacing: 2px; font-size: 0.85rem;">
                                Ver Colección
                            </a>
                            <a href="{{ route('companies.index') }}" class="btn btn-outline-dark px-5 py-3 rounded-0 text-uppercase bg-white-hover" style="letter-spacing: 2px; font-size: 0.85rem; border-color: #1C2833; color: #1C2833;">
                                Descubrir Marcas
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <div id="productos" class="mt-5">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h3 class="fw-bold mb-0">Nuestros Productos</h3>
                <p class="text-muted small mb-0">Selección recomendada para ti</p>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mb-5">
            @foreach($products as $product)
                <div class="col">
                    <div class="card h-100 product-card border-0 bg-white shadow-sm transition-all">
                        <!-- Image Carousel -->
                        <div class="swiper product-image-swiper">
                                <div class="swiper-wrapper">
                                    @if($product->images->count() > 0)
                                        @foreach($product->images as $image)
                                            <div class="swiper-slide">
                                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                                     class="card-img-top rounded-0" 
                                                     alt="{{ $product->name }}"
                                                     style="height: 250px; object-fit: cover;">
                                            </div>
                                        @endforeach
                                    @else
                                        {{-- Fallback to legacy image or placeholder --}}
                                        <div class="swiper-slide">
                                            <img src="{{ $product->image_url ?? 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?auto=format&fit=crop&q=80&w=800' }}" 
                                                 class="card-img-top rounded-0" 
                                                 alt="{{ $product->name }}"
                                                 style="height: 250px; object-fit: cover;">
                                        </div>
                                    @endif
                                </div>
                            <!-- Swiper navigation arrows -->
                            <div class="swiper-button-next swiper-button-sm"></div>
                            <div class="swiper-button-prev swiper-button-sm"></div>
                            <div class="position-absolute top-0 end-0 p-3 z-index-10">
                                <button class="btn btn-light btn-sm rounded-circle shadow-sm text-muted heart-btn" type="button"><i class="bi bi-heart"></i></button>
                            </div>
                        </div>

                        <div class="card-body p-4 text-center d-flex flex-column justify-content-center">
                            <h5 class="card-title mb-2 text-dark" style="font-family: 'Outfit', sans-serif; letter-spacing: 0.5px; font-weight: 500;">{{ $product->name }}</h5>
                            <div class="d-flex justify-content-center align-items-center mb-3" style="color: #D4AF37;">
                                <i class="bi bi-star-fill small"></i><i class="bi bi-star-fill small"></i><i class="bi bi-star-fill small"></i><i class="bi bi-star-fill small"></i><i class="bi bi-star-half small"></i>
                                <span class="ms-2 text-muted" style="font-size: 0.75rem; letter-spacing: 1px;">(4.5)</span>
                            </div>
                            <div class="mb-3 mt-auto">
                                <span class="h5 mb-0 fw-semibold" style="color: #1C2833;">${{ number_format($product->price, 2) }}</span>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0 px-4 pb-4 pt-0 d-flex gap-2">
                            <a href="{{ route('products.show', $product) }}" class="btn btn-outline-brand-green rounded-0 flex-grow-1 text-uppercase py-2" style="font-size: 0.75rem; letter-spacing: 1.5px;">
                                Detalles
                            </a>
                            @auth
                                <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form shadow-none flex-grow-1">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-brand-green rounded-0 w-100 text-uppercase py-2" style="font-size: 0.75rem; letter-spacing: 1.5px;">
                                        Añadir
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-brand-green rounded-0 flex-grow-1 text-uppercase py-2" style="font-size: 0.75rem; letter-spacing: 1.5px;">
                                    Añadir
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
                    <h3 class="fw-bold">No encontramos tus productos</h3>
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
    .z-index-1 {
        z-index: 1;
    }

    /* Hero Redesign Styles */
    .hero-section {
        background-attachment: scroll;
    }
    @media (min-width: 992px) {
        .hero-section {
            background-attachment: fixed;
        }
    }
    .glass-morphism {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.4);
    }
    .text-muted-dark {
        color: #4a4a4a;
        font-size: 1.1rem;
    }
    .animate-fade-in-up {
        animation: fadeInUp 1s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .animate-slide-in {
        animation: slideInLeft 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .animate-fade-in-delay {
        animation: fadeIn 1.5s ease-out;
    }
    .shadow-hover-vibrant:hover {
        box-shadow: 0 15px 30px rgba(88, 98, 74, 0.3);
        transform: translateY(-3px) scale(1.02);
    }
    .bg-white-hover:hover {
        background-color: #fff !important;
        transform: translateY(-3px);
    }
    
    .product-card {
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border: 1px solid rgba(0,0,0,0.03) !important;
    }
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.08) !important;
        border-color: transparent !important;
    }
    .heart-btn {
        transition: all 0.3s ease;
    }
    .heart-btn:hover {
        color: #e74c3c !important;
        transform: scale(1.1);
    }
    
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-60px); }
        to { opacity: 1; transform: translateX(0); }
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
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
