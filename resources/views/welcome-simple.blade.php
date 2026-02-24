@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('messages.Welcome') }}</div>

                <div class="card-body">
                    @guest
                        <h4>Bienvenido invitado!!!</h4>
                        {{-- <p class="mb-4">Por favor, inicia sesión para acceder al menú principal.</p> --}}
                        <p class="mt-4">Aquí puedes acceder a la información de contenido público</p>
                    @else
                        <h4>¡Hola, {{ Auth::user()->name }} !</h4>
                        <p class="mb-4">Has iniciado sesión correctamente.</p>
                        <p class="mb-4">En breve serás redireccionado...</p>
                        <a href="{{ route('home') }}" class="btn btn-primary">{{ __('Ir al Menú Principal') }}</a>
                    @endguest
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
                                        <a href="#" class="btn btn-outline-primary btn-sm">Ver más</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
    .gap-3 {
        gap: 1rem;
    }
    .d-flex {
        display: flex;
    }
    .card {
        transition: all 0.3s ease;
    }
    .card:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
</style>
@endpush

@push('scripts')
<script>
@auth
    // redireccinar a home en 5 segs
    setTimeout(function() {
        window.location.href = "{{ route('home') }}";
    }, 2000);
@endauth

</script>
@endpush
