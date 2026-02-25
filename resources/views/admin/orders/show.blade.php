@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <a href="{{ route('admin.orders.index') }}" class="text-decoration-none">
            <i class="bi bi-arrow-left me-1"></i> Volver al listado
        </a>
        <h2 class="fw-bold mt-2">Pedido {{ $order->order_number }}</h2>
    </div>

    <div class="row g-4">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0">Artículos del Pedido</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Producto</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th class="text-end pe-4">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center py-2">
                                            @if($item->product->image)
                                                <img src="{{ asset('storage/'.$item->product->image) }}" class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                    <i class="bi bi-image text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <span class="fw-bold d-block text-dark">{{ $item->product->name }}</span>
                                                <small class="text-muted">ID: #{{ $item->product_id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td class="text-end pe-4 fw-bold">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="border-top-0">
                                <tr class="bg-light">
                                    <td colspan="3" class="text-end py-3 h5 fw-bold">Total:</td>
                                    <td class="text-end pe-4 py-3 h5 fw-bold text-primary">${{ number_format($order->total, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Payment Info -->
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Información de Pago</h5>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="small text-muted d-block">Médodo de Pago</label>
                                <span class="fw-bold text-capitalize">{{ $order->payment_method }}</span>
                            </div>
                            <div class="mb-3">
                                <label class="small text-muted d-block">Transacción ID / Referencia</label>
                                <span class="fw-bold text-break">{{ $order->transaction_id ?? $order->reference ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="small text-muted d-block">Estado de Pago</label>
                                <span class="badge rounded-pill @if($order->status == 'completed') bg-success @elseif($order->status == 'pending') bg-warning text-dark @else bg-danger @endif px-3">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <div class="mb-3">
                                <label class="small text-muted d-block">Fecha de Compra</label>
                                <span class="fw-bold">{{ $order->created_at->format('d/m/Y H:i:s') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar / Actions -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Cliente</h5>
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <span class="h4 mb-0">{{ strtoupper(substr($order->user->name, 0, 1)) }}</span>
                        </div>
                        <div>
                            <span class="fw-bold d-block">{{ $order->user->name }}</span>
                            <small class="text-muted">{{ $order->user->email }}</small>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">Rol:</span>
                        <span class="badge bg-light text-dark">{{ $order->user->role ?? 'Usuario' }}</span>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Acciones</h5>
                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-4">
                            <label class="form-label small fw-bold">Cambiar Estado</label>
                            <select name="status" class="form-select rounded-pill">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completado</option>
                                <option value="failed" {{ $order->status == 'failed' ? 'selected' : '' }}>Fallido</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-pill mb-2 py-2">
                            Actualizar Pedido
                        </button>
                    </form>
                    <button class="btn btn-outline-secondary w-100 rounded-pill py-2" onclick="window.print()">
                        <i class="bi bi-printer me-1"></i> Imprimir Reporte
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
