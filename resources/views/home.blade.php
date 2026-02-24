@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm bg-primary bg-gradient text-white">
                <div class="card-body p-4">
                    <h2 class="h4 mb-3">¡Hola, {{ Auth::user()->name }}! ¿Qué estás buscando hoy?</h2>
                    <form action="{{ route('home') }}" method="GET" class="d-flex gap-2">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-0"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control border-0" 
                                placeholder="Busca por nombre o descripción..." 
                                value="{{ $search ?? '' }}">
                            <button class="btn btn-light" type="submit">Buscar</button>
                        </div>
                        @if(isset($search) && $search != '')
                            <a href="{{ route('home') }}" class="btn btn-outline-light"><i class="bi bi-x-lg"></i></a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <h3 class="mb-4">Nuestros Productos</h3>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($products as $product)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0">
                        @if($product->hasImage())
                            <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center card-img-top" style="height: 200px;">
                                <i class="bi bi-image text-muted fs-1"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title text-primary">{{ $product->name }}</h5>
                            <p class="card-text text-muted small">{{ Str::limit($product->description, 80) }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="h5 mb-0 text-success">${{ number_format($product->price, 2) }}</span>
                                <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form shadow-none">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm rounded-pill px-3">
                                        <i class="bi bi-plus-lg me-1"></i> Comprar
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
            <div class="alert alert-info text-center py-4">
                <i class="bi bi-info-circle fs-3 d-block mb-2"></i>
                No hay productos disponibles en este momento.
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
        background-color: var(--bs-primary);
        color: white;
        box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
    }
    .pagination-modern .page-link:hover:not(.active) {
        background-color: #f8f9fa;
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
                    btn.html('<i class="bi bi-check-lg"></i> Listo').removeClass('btn-primary').addClass('btn-success');
                    setTimeout(() => {
                        btn.html(originalHtml).removeClass('btn-success').addClass('btn-primary');
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
