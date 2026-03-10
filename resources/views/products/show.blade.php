@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    .product-show-swiper {
        width: 100%;
        height: auto;
    }
</style>
@endpush
@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-brand-green">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                    @if($product->images->count() > 0)
                        <div class="swiper product-show-swiper">
                            <div class="swiper-wrapper">
                                @foreach($product->images as $image)
                                    <div class="swiper-slide text-center">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" 
                                             class="img-fluid" 
                                             alt="{{ $product->name }}"
                                             style="max-height: 500px; width: 100%; object-fit: contain; background-color: #f8f9fa;">
                                    </div>
                                @endforeach
                            </div>
                            <!-- Swiper navigation -->
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-pagination"></div>
                        </div>
                    @else
                        <img src="{{ $product->image_url ?? 'https://placehold.co/800x600?text=' . urlencode($product->name) }}" 
                             alt="{{ $product->name }}" 
                             class="img-fluid" 
                             style="max-height: 500px; width: 100%; object-fit: contain; background-color: #f8f9fa;">
                    @endif
                </div>
        </div>
        <div class="col-md-6">
            <div class="ps-md-4">
                <p class="text-uppercase text-muted fw-bold small mb-2">YANA NATURAL</p>
                <h1 class="fw-bold mb-3">{{ $product->name }}</h1>
                
                <div class="d-flex align-items-center mb-4">
                    <div class="text-warning me-2">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                    </div>
                    <span class="text-muted small">(4.5 valoración de clientes)</span>
                </div>

                <h2 class="display-6 fw-bold text-dark mb-4">${{ number_format($product->price, 2) }}</h2>

                <div class="mb-5">
                    <h5 class="fw-bold mb-3">Descripción</h5>
                    <p class="text-muted leading-relaxed">
                        {{ $product->description }}
                    </p>
                </div>

                <div class="d-grid gap-3 d-md-flex align-items-center">
                    <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form flex-grow-1">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="input-group mb-3 mb-md-0" style="max-width: 160px;">
                            <button class="btn btn-outline-secondary" type="button" onclick="decrement()">-</button>
                            <input type="number" name="quantity" id="quantity" class="form-control text-center" value="1" min="1">
                            <button class="btn btn-outline-secondary" type="button" onclick="increment()">+</button>
                        </div>
                        <button type="submit" class="btn btn-brand-green btn-lg rounded-pill px-5 py-3 text-white fw-bold shadow-sm w-100 mt-3">
                            <i class="bi bi-cart-plus me-2"></i> Añadir al carrito
                        </button>
                    </form>
                </div>

                <hr class="my-5 opacity-10">

                <div class="d-flex align-items-center gap-4 text-muted">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-truck fs-4 me-2"></i>
                        <span class="small text-nowrap">Envío gratuito</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-shield-check fs-4 me-2"></i>
                        <span class="small text-nowrap">Compra segura</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function increment() {
        document.getElementById('quantity').stepUp();
    }
    function decrement() {
        document.getElementById('quantity').stepDown();
    }
</script>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    $(document).ready(function() {
        new Swiper('.product-show-swiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });

        // AJAX Add to Cart logic
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
                        const btn = form.find('button[type="submit"]');
                        const originalHtml = btn.html();
                        
                        btn.html('<i class="bi bi-check-lg"></i> Añadido')
                           .addClass('btn-success').removeClass('btn-brand-green');

                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Añadido al carrito!',
                                text: 'El producto se ha añadido correctamente.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }

                        setTimeout(() => {
                            btn.html(originalHtml)
                               .addClass('btn-brand-green').removeClass('btn-success');
                        }, 2000);
                    }
                },
                error: function(xhr) {
                    if(xhr.status === 401) {
                        window.location.href = '/login';
                    } else {
                        alert('Ocurrió un error al añadir el producto.');
                    }
                }
            });
        });
    });
</script>
@endpush
