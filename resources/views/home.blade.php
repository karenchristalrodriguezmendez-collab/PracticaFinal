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

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            @foreach($products as $product)
                <div class="col">
                    <div class="card h-100 shadow-hover border-0 rounded-3 overflow-hidden">
                        <div class="position-relative">
                            @if($product->hasImage())
                                <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}" style="height: 220px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center card-img-top" style="height: 220px;">
                                    <i class="bi bi-image text-muted fs-1"></i>
                                </div>
                            @endif
                            <div class="position-absolute top-0 end-0 p-2">
                                <button class="btn btn-white btn-sm rounded-circle shadow-sm" type="button"><i class="bi bi-heart text-brand-green"></i></button>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <p class="text-uppercase text-muted x-small mb-1 fw-bold">YANA NATURAL</p>
                            <h6 class="card-title fw-bold mb-2">{{ $product->name }}</h6>
                            <div class="d-flex align-items-center mb-3 text-warning small">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                                <span class="ms-1 text-muted">(4.5)</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 mb-0 fw-bold text-dark">${{ number_format($product->price, 2) }}</span>
                                <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form shadow-none">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-brand-green btn-sm rounded-pill px-3 fw-bold text-white">
                                        <i class="bi bi-cart-plus"></i> Añadir
                                    </button>
                                </form>
                            </div>
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
                    <a href="{{ route('home') }}" class="btn btn-brand-green rounded-pill px-4 py-2 mt-2">Ver todo el catálogo</a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
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
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
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
                    const originalBg = btn.css('background-color');
                    
                    btn.html('<i class="bi bi-check-lg"></i> Listo')
                       .css('background-color', '#58624A');

                    setTimeout(() => {
                        btn.html(originalHtml)
                           .css('background-color', '#A2A58D');
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
