@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card mb-4 border-0 shadow-sm bg-brand-green text-white">
                <div class="card-body p-4">
                    <h2 class="h4 mb-3">¿Qué estás buscando hoy?</h2>
                    <form action="{{ url('/') }}" method="GET" class="d-flex gap-2">
                        <div class="input-group">
                            <span class="input-group-text border-0 text-white" style="background-color: #A2A58D;"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control border-0 text-white placeholder-white" 
                                style="background-color: #A2A58D;"
                                placeholder="Busca por nombre o descripción..." 
                                value="{{ $search ?? '' }}">
                            <button class="btn btn-light text-brand-green fw-bold" type="submit">Buscar</button>
                        </div>
                        @if(isset($search) && $search != '')
                            <a href="{{ url('/') }}" class="btn btn-outline-light"><i class="bi bi-x-lg"></i></a>
                        @endif
                    </form>
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
                                    <h5 class="card-title text-brand-green fw-bold">{{ $product->name }}</h5>
                                    <p class="card-text text-muted small">{{ Str::limit($product->description, 80) }}</p>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <span class="h5 mb-0 text-brand-tan fw-bold">${{ number_format($product->price, 2) }}</span>
                                        @auth
                                            <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form shadow-none">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn text-white btn-sm rounded-pill px-4 transition-transform hover:scale-105 shadow-sm" style="background-color: #A2A58D;">
                                                    <i class="bi bi-plus-lg me-1"></i> Comprar
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('login') }}" class="btn border-brand-olive text-brand-olive btn-sm rounded-pill px-3 hover:bg-brand-olive hover:text-white transition-all">
                                                <i class="bi bi-plus-lg me-1"></i> Comprar
                                            </a>
                                        @endauth
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
        background-color: var(--brand-green);
        color: white;
        box-shadow: 0 4px 10px rgba(88, 98, 74, 0.3);
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

    @auth
    // redireccinar a home en 5 segs
    setTimeout(function() {
        window.location.href = "{{ route('home') }}";
    }, 2000);
@endauth

</script>
@endpush
