@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card border-0 shadow-lg overflow-hidden" style="border-radius: 20px;">
                <div class="card-body p-0">
                    <div class="text-white text-center py-5" style="background-color: #58624A;">
                        <i class="bi bi-check-circle-fill display-1 mb-3"></i>
                        <h2 class="fw-bold">¡Compra Exitosa!</h2>
                        <p class="mb-0 opacity-75">Tu pedido #{{ $orderNumber }} ha sido registrado</p>
                    </div>

                    <div class="p-4 p-md-5">
                        <div class="d-flex justify-content-between align-items-center mb-4 pb-4 border-bottom">
                            <div>
                                <span class="text-muted d-block small text-uppercase fw-bold">Fecha</span>
                                <span class="fw-bold">{{ now()->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="text-end">
                                <span class="text-muted d-block small text-uppercase fw-bold">Total Pagado</span>
                                <span class="h4 fw-bold mb-0" style="color: #58624A;">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Resumen de Productos</h6>
                            <ul class="list-group list-group-flush small">
                                @foreach($items as $item)
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <span>{{ $item['name'] }} (x{{ $item['quantity'] }})</span>
                                        <span class="fw-bold">${{ number_format($item['total'], 2) }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        @if($paymentMethod == 'oxxo')
                            <div class="payment-receipt bg-light rounded-4 p-4 text-center border">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/66/Oxxo_Logo.svg/1200px-Oxxo_Logo.svg.png" 
                                     alt="OXXO" class="mb-4" style="height: 40px;">
                                
                                <h5 class="fw-bold mb-3">Ficha Digital de Pago</h5>
                                <p class="text-muted small mb-4">Presenta este código en cualquier tienda OXXO para completar tu pago.</p>
                                
                                <!-- Barcode Simulation -->
                                <div class="barcode-container mb-3 p-3 bg-white border d-inline-block">
                                    <div class="d-flex align-items-end justify-content-center mb-2" style="height: 60px;">
                                        @php $barcodeParts = [2,4,1,3,5,2,4,1,3,2,4,1,2,5,3,4,2,1,3]; @endphp
                                        @foreach($barcodeParts as $width)
                                            <div class="bg-dark mx-1" style="width: {{ $width }}px; height: 100%;"></div>
                                        @endforeach
                                    </div>
                                    <code class="h5 fw-bold letter-spacing-2">{{ implode(' ', str_split($reference, 4)) }}</code>
                                </div>
                                
                                <div class="alert alert-warning border-0 small mt-3">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    Este comprobante expira en 48 horas.
                                </div>
                            </div>

                        @elseif($paymentMethod == 'transfer')
                            <div class="payment-receipt bg-light rounded-4 p-4 border">
                                <div class="d-flex align-items-center mb-4">
                                    <i class="bi bi-bank fs-2 me-3" style="color: #58624A;"></i>
                                    <h5 class="fw-bold mb-0">Datos para Transferencia (SPEI)</h5>
                                </div>
                                
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label class="small text-muted d-block">Banco</label>
                                        <span class="fw-bold">STP / BBVA</span>
                                    </div>
                                    <div class="col-sm-6 text-sm-end">
                                        <label class="small text-muted d-block">Beneficiario</label>
                                        <span class="fw-bold">Yana's Page S.A de C.V</span>
                                    </div>
                                    <div class="col-12 mt-3 border-top pt-3">
                                        <label class="small text-muted d-block">Referencia Única</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control fw-bold border-0 bg-white" value="{{ $reference }}" readonly>
                                            <button class="btn border-0" style="color: #58624A;" type="button" onclick="copyClabe()">
                                                <i class="bi bi-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="small text-muted d-block">CLABE Interbancaria</label>
                                        <span class="fw-bold" style="color: #58624A;">0121 8000 1234 5678 90</span>
                                    </div>
                                </div>
                                
                                <div class="mt-4 p-3 bg-white border rounded small text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Tu pedido se procesará automáticamente una vez que recibamos la confirmación del banco (usualmente menos de 5 minutos).
                                </div>
                            </div>

                        @else
                            <div class="text-center py-4 bg-light rounded-4 border">
                                <i class="bi bi-credit-card-2-front fs-1 mb-3" style="color: #58624A;"></i>
                                <h5 class="fw-bold">Pago con Tarjeta Confirmado</h5>
                                <p class="text-muted small">Hemos procesado tu cargo de manera segura.</p>
                                <span class="badge py-2 px-3 rounded-pill" style="background-color: #58624A;">Autorizado: #{{ rand(100000, 999999) }}</span>
                            </div>
                        @endif

                        <div class="mt-5 d-flex flex-column gap-2">
                            <div class="d-flex gap-2">
                                @if(isset(session('last_order')['order_id']))
                                    <button onclick="printDirectly({{ session('last_order')['order_id'] }})" id="btn-direct-print" class="btn text-white w-100 py-3 rounded-pill fw-bold" style="background-color: #BA9B72;">
                                        <i class="bi bi-printer-fill me-2"></i> Impresión Térmica Directa
                                    </button>
                                @endif
                                <button onclick="window.print()" class="btn btn-outline-secondary w-100 py-3 rounded-pill fw-bold">
                                    <i class="bi bi-window me-2"></i> Vista Previa (PDF)
                                </button>
                            </div>
                            <a href="{{ route('home') }}" class="btn text-white w-100 py-3 rounded-pill fw-bold btn-brand-green">
                                Volver al Inicio
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<x-ticket :order="['total' => $total, 'orderNumber' => $orderNumber, 'paymentMethod' => $paymentMethod, 'reference' => $reference ?? null]" :items="$items" />

<script>
    function copyClabe() {
        const clabeInput = document.querySelector('input[readonly]');
        clabeInput.select();
        document.execCommand('copy');
        alert('CLABE copiada al portapapeles');
    }

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
                alert('Error al imprimir: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error de conexión con la impresora.');
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = originalHtml;
        });
    }
</script>

<style>
    .letter-spacing-2 { letter-spacing: 2px; }
    .bg-gradient { background: linear-gradient(135deg, #58624A 0%, #464e3b 100%) !important; }
    .payment-receipt { transition: transform 0.3s ease; }
    .payment-receipt:hover { transform: translateY(-5px); }
</style>
@endsection
