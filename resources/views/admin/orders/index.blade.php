@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Gestión de Pedidos</h2>
        <span class="badge btn-brand-green rounded-pill px-3 py-2">Total: {{ $orders->total() }}</span>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3"># Pedido</th>
                            <th class="py-3">Cliente</th>
                            <th class="py-3">Fecha</th>
                            <th class="py-3">Total</th>
                            <th class="py-3">Método</th>
                            <th class="py-3">Estado</th>
                            <th class="py-3 text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="ps-4 fw-bold text-primary">{{ $order->order_number }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle p-2 me-2" style="background-color: rgba(88, 98, 74, 0.1);">
                                        <i class="bi bi-person text-brand-green"></i>
                                    </div>
                                    <span>{{ $order->user->name }}</span>
                                </div>
                            </td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="fw-bold">${{ number_format($order->total, 2) }}</td>
                            <td>
                                <span class="text-capitalize small">
                                    @if($order->payment_method == 'card') <i class="bi bi-credit-card me-1"></i> Tarjeta
                                    @elseif($order->payment_method == 'paypal') <i class="bi bi-paypal me-1"></i> PayPal
                                    @elseif($order->payment_method == 'oxxo') <i class="bi bi-shop me-1"></i> OXXO
                                    @else <i class="bi bi-bank me-1"></i> SPEI
                                    @endif
                                </span>
                            </td>
                            <td>
                                @php
                                    $statusClass = [
                                        'pending' => 'bg-warning text-dark',
                                        'completed' => 'bg-success',
                                        'failed' => 'bg-danger',
                                        'cancelled' => 'bg-secondary'
                                    ][$order->status] ?? 'bg-info';
                                    
                                    $statusLabel = [
                                        'pending' => 'Pendiente',
                                        'completed' => 'Completado',
                                        'failed' => 'Fallido',
                                        'cancelled' => 'Cancelado'
                                    ][$order->status] ?? $order->status;
                                @endphp
                                <span class="badge rounded-pill {{ $statusClass }} px-3">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    <i class="bi bi-eye me-1"></i> Detalles
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-info-circle fs-2 d-block mb-3"></i>
                                No se encontraron pedidos registrados.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="p-4 bg-light border-top d-flex justify-content-center">
                {{ $orders->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

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
        color: #58624A;
    }
</style>
@endpush
@endsection
