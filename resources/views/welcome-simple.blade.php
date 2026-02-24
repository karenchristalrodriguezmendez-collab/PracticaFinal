@extends('layouts.app')

@section('content')
<div class="container">
            <div class="card mb-4 border-0 shadow-sm bg-primary bg-gradient text-white">
                <div class="card-body p-4">
                    <h2 class="h4 mb-3">¿Qué estás buscando hoy?</h2>
                    <form action="{{ url('/') }}" method="GET" class="d-flex gap-2">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-0"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control border-0" 
                                placeholder="Busca por nombre o descripción..." 
                                value="{{ $search ?? '' }}">
                            <button class="btn btn-light" type="submit">Buscar</button>
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
