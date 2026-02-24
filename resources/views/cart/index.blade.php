@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4"><i class="bi bi-cart3"></i> Tu Carrito de Compras</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($cartItems->isEmpty())
        <div class="card border-0 shadow-sm p-5 text-center">
            <div class="card-body">
                <i class="bi bi-cart-x fs-1 text-muted"></i>
                <h2 class="mt-3">Tu carrito está vacío</h2>
                <p class="text-muted">Parece que aún no has añadido ningún producto.</p>
                <a href="{{ url('/') }}" class="btn btn-primary mt-3 px-4 rounded-pill">Ir a la tienda</a>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted">
                                <tr>
                                    <th class="ps-4">Producto</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                    <th class="text-end pe-4">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $item)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                @if($item->product->hasImage())
                                                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                        <i class="bi bi-image text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h6 class="mb-0">{{ $item->product->name }}</h6>
                                                    <small class="text-muted">{{ Str::limit($item->product->description, 30) }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>${{ number_format($item->product->price, 2) }}</td>
                                        <td style="width: 150px;">
                                            <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="input-group input-group-sm">
                                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control text-center">
                                                    <button class="btn btn-outline-secondary" type="submit">
                                                        <i class="bi bi-arrow-repeat"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </td>
                                        <td class="fw-bold">${{ number_format($item->total, 2) }}</td>
                                        <td class="text-end pe-4">
                                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger p-0" title="Eliminar">
                                                    <i class="bi bi-trash fs-5"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-4">Resumen del Pedido</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="text-muted">Envío</span>
                            <span class="badge bg-success">Gratis</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="h5">Total</span>
                            <span class="h5 text-primary">${{ number_format($total, 2) }}</span>
                        </div>
                        <button class="btn btn-primary w-100 py-2 rounded-pill mb-2">Proceder al pago</button>
                        <a href="{{ url('/') }}" class="btn btn-outline-secondary w-100 py-2 rounded-pill">Seguir comprando</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
