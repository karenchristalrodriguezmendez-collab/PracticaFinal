@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-0">Detalles del Pedido</h2>
                    <p class="text-muted small">Pedido #{{ $order->order_number }}</p>
                </div>
                <div class="d-flex gap-2">
                    <button onclick="printDirectly({{ $order->id }})" id="btn-direct-print" class="btn btn-brand-gold text-white rounded-pill px-4">
                        <i class="bi bi-printer-fill me-2"></i>Imprimir Directo (58mm)
                    </button>
                    <button onclick="window.print()" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="bi bi-receipt-cutoff me-2"></i>Vista Previa
                    </button>
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-brand-green rounded-pill px-4">
                        <i class="bi bi-arrow-left me-2"></i>Volver a mis pedidos
                    </a>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-8">
                    <!-- Resumen de Productos -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white py-3 border-0 ps-4">
                            <h5 class="mb-0 fw-bold">Productos</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="ps-4 border-0 small text-uppercase text-muted">Producto</th>
                                            <th class="border-0 small text-uppercase text-muted text-center">Cant.</th>
                                            <th class="border-0 small text-uppercase text-muted text-end">Precio</th>
                                            <th class="pe-4 border-0 small text-uppercase text-muted text-end">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->items as $item)
                                            <tr>
                                                <td class="ps-4 border-0 d-flex align-items-center py-3">
                                                    @if($item->product->hasImage())
                                                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="rounded shadow-sm me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light rounded d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                                            <i class="bi bi-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <span class="fw-bold d-block">{{ $item->product->name }}</span>
                                                        <span class="text-muted small">ID: {{ $item->product->id }}</span>
                                                    </div>
                                                </td>
                                                <td class="border-0 text-center py-3">{{ $item->quantity }}</td>
                                                <td class="border-0 text-end py-3">${{ number_format($item->price, 2) }}</td>
                                                <td class="pe-4 border-0 text-end py-3 fw-bold">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Información de Pago -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background-color: #f8faf8;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Información del Pedido</h5>

                            <!-- Tracking Timeline -->
                            <div class="tracking-timeline mb-4">
                                <div class="d-flex justify-content-between position-relative">
                                    <div class="text-center" style="z-index: 1; width: 25%;">
                                        <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center {{ $order->status != 'cancelled' ? 'bg-success text-white' : 'bg-light text-muted' }}" style="width: 30px; height: 30px; font-size: 12px;">
                                            <i class="bi bi-check-lg"></i>
                                        </div>
                                        <span class="x-small fw-bold d-block">Recibido</span>
                                    </div>
                                    <div class="text-center" style="z-index: 1; width: 25%;">
                                        <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center {{ ($order->status == 'completed' || $order->status == 'shipped') ? 'bg-success text-white' : 'bg-light text-muted' }}" style="width: 30px; height: 30px; font-size: 12px;">
                                            <i class="bi bi-credit-card"></i>
                                        </div>
                                        <span class="x-small fw-bold d-block">Pagado</span>
                                    </div>
                                    <div class="text-center" style="z-index: 1; width: 25%;">
                                        <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center {{ $order->status == 'shipped' ? 'bg-success text-white' : 'bg-light text-muted' }}" style="width: 30px; height: 30px; font-size: 12px;">
                                            <i class="bi bi-truck"></i>
                                        </div>
                                        <span class="x-small fw-bold d-block">Enviado</span>
                                    </div>
                                    <div class="text-center" style="z-index: 1; width: 25%;">
                                        <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center {{ $order->status == 'completed' ? 'bg-success text-white' : 'bg-light text-muted' }}" style="width: 30px; height: 30px; font-size: 12px;">
                                            <i class="bi bi-house-door"></i>
                                        </div>
                                        <span class="x-small fw-bold d-block">Entregado</span>
                                    </div>
                                    <!-- Connector Line -->
                                    <div class="position-absolute" style="top: 15px; left: 12%; right: 12%; height: 2px; background-color: #e9ecef; z-index: 0;"></div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Estado del Pago:</span>
                                <span class="badge rounded-pill px-3 {{ $order->status == 'completed' ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Fecha:</span>
                                <span class="fw-bold">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Método:</span>
                                <span class="fw-bold text-uppercase">{{ $order->payment_method }}</span>
                            </div>

                            @if($order->reference)
                                <div class="mt-3 p-3 bg-white rounded-3 border border-dashed text-center">
                                    <span class="text-muted small d-block">Referencia de Pago:</span>
                                    <span class="h5 fw-bold text-brand-green mb-0">{{ $order->reference }}</span>
                                </div>
                            @endif

                            <hr class="my-4">

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 mb-0 fw-bold">Total Pagado</span>
                                <span class="h3 mb-0 fw-bold text-brand-green">${{ number_format($order->total, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    @if($order->status == 'pending')
                        <div class="card border-0 shadow-sm rounded-4 bg-white">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-2">¿Cómo pagar?</h6>
                                <p class="small text-muted mb-0">
                                    Si elegiste transferencia o pago en efectivo, asegúrate de enviar tu comprobante al administrador para confirmar tu pedido.
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<x-ticket :order="$order" />

<script>
    function printDirectly(orderId) {
        const btn = document.getElementById('btn-direct-print');
        const originalHtml = btn.innerHTML;
        
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Imprimiendo...';

        fetch(`/orders/${orderId}/print-direct`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                alert('Ticket enviado correctamente a la impresora.');
            } else {
                alert('Error al imprimir: ' + data.message + '\n\nVerifica que la impresora se llame "' + '{{ config("printing.printer_name") }}' + '" y esté compartida.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error de conexión con el servidor de impresión.');
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = originalHtml;
        });
    }
</script>
@endsection
