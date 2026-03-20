@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-0">¡Hola, {{ Auth::user()->name }}!</h2>
                <p class="text-muted small">Echa un vistazo a lo que tenemos para ti hoy.</p>
            </div>
            @if(isset($search) && $search != '')
                <div class="alert alert-light border-0 shadow-sm py-2 px-3 mb-0 rounded-pill">
                    Resultados para: <strong>"{{ $search }}"</strong>
                    <a href="{{ route('home') }}" class="ms-2 text-dark"><i class="bi bi-x-circle-fill"></i></a>
                </div>
            @endif
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
                            <!-- Swiper navigation arrows -->
                            <div class="swiper-button-next swiper-button-sm"></div>
                            <div class="swiper-button-prev swiper-button-sm"></div>
                            <div class="position-absolute top-0 end-0 p-3 z-index-10">
                                <button class="btn btn-white btn-sm rounded-circle shadow-sm" type="button"><i class="bi bi-heart text-brand-green"></i></button>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <p class="text-uppercase text-muted x-small mb-1 fw-bold tracking-wider">YANA NATURAL</p>
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
                            <a href="{{ route('products.show', $product) }}" class="btn btn-outline-brand-green btn-sm rounded-pill flex-grow-1 fw-bold py-2">
                                <i class="bi bi-eye"></i> Detalles
                            </a>
                            <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form shadow-none flex-grow-1">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-brand-green btn-sm rounded-pill w-100 fw-bold text-white py-2">
                                    <i class="bi bi-cart-plus"></i> Añadir
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $products->appends(['search' => $search ?? ''])->links('vendor.pagination.bootstrap-5') }}
        </div>
        
        @if($products->isEmpty())
            <div class="card border-0 shadow-sm p-5 text-center my-5 rounded-4 bg-light">
                <div class="card-body">
                    <i class="bi bi-search fs-1 text-muted mb-3 d-block"></i>
                    <h3 class="fw-bold">No encontramos productos</h3>
                    <p class="text-muted">Intenta con otros términos de búsqueda o explora nuestras categorías.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-brand-green rounded-pill px-4 py-2 mt-2">Ver todo el catálogo</a>
                </div>
            </div>
        @endif
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
        background-color: #58624A;
        color: white;
        box-shadow: 0 4px 10px rgba(88, 98, 74, 0.3);
    }
    .pagination-modern .page-link:hover:not(.active) {
        background-color: #f8faf8;
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
});
</script>
@endpush
