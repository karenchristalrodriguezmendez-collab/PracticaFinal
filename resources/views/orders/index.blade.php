@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Mis Pedidos</h2>
            <p class="text-muted small">Historial de tus compras en EcoSkin</p>
        </div>
        <a href="{{ url('/') }}" class="btn btn-outline-brand-green rounded-pill px-4">Volver a la tienda</a>
    </div>

    @if($orders->isEmpty())
        <div class="card border-0 shadow-sm p-5 text-center my-5 rounded-4 bg-light">
            <div class="card-body">
                <i class="bi bi-box-seam fs-1 text-muted mb-3 d-block"></i>
                <h3 class="fw-bold">Aún no tienes pedidos</h3>
                <p class="text-muted">Cuando realices tu primera compra, aparecerá aquí.</p>
                <a href="{{ url('/') }}" class="btn btn-brand-green rounded-pill px-4 py-2 mt-2">Empezar a comprar</a>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 border-0">Nº Pedido</th>
                            <th class="py-3 border-0">Fecha</th>
                            <th class="py-3 border-0">Estado</th>
                            <th class="py-3 border-0">Método de Pago</th>
                            <th class="py-3 border-0">Total</th>
                            <th class="pe-4 py-3 border-0 text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td class="ps-4 fw-bold text-brand-green">{{ $order->order_number }}</td>
                                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge rounded-pill px-3 py-2 {{ $order->status == 'completed' ? 'bg-success' : ($order->status == 'pending' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted x-small text-uppercase fw-bold">{{ $order->payment_method }}</span>
                                </td>
                                <td class="fw-bold fs-5">${{ number_format($order->total, 2) }}</td>
                                <td class="pe-4 text-end">
                                    <a href="{{ route('orders.show', $order->order_number) }}" class="btn btn-brand-green btn-sm rounded-pill px-3 fw-bold">Ver detalles</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $orders->links('vendor.pagination.bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
