@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex align-items-center mb-5">
        <h1 class="fw-light mb-0" style="font-family: 'Outfit', sans-serif; color: #1C2833;">Tu <span class="fw-bold">Carrito</span></h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-0 border-0 shadow-sm" role="alert" style="background-color: #f0fdf4; color: #166534; border-left: 4px solid #16a34a !important;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-0 border-0 shadow-sm" role="alert" style="background-color: #fef2f2; color: #991b1b; border-left: 4px solid #dc2626 !important;">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($cartItems->isEmpty())
        <div class="card border-0 shadow-sm p-5 text-center rounded-0" style="background: #FCFCFC;">
            <div class="card-body py-5">
                <i class="bi bi-cart-x text-muted mb-4 d-block" style="font-size: 3rem; opacity: 0.5;"></i>
                <h2 class="fw-light" style="color: #1C2833; font-family: 'Outfit', sans-serif;">Tu carrito está vacío</h2>
                <p class="text-muted mb-4">Descubre nuestra colección premium y encuentra tus esenciales de belleza.</p>
                <a href="{{ route('home') }}" class="btn rounded-0 text-uppercase px-5 py-3" style="background-color: #1C2833; color: white; letter-spacing: 2px; font-size: 0.85rem;">Explorar Colección</a>
            </div>
        </div>
    @else
        <div class="row g-5">
            <div class="col-lg-8">
                <div class="card border-0 rounded-0 shadow-sm">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0" style="border-collapse: separate; border-spacing: 0 15px;">
                            <thead style="background: transparent;">
                                <tr>
                                    <th class="ps-4 border-bottom pb-3 fw-semibold text-muted text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Producto</th>
                                    <th class="border-bottom pb-3 fw-semibold text-muted text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Precio</th>
                                    <th class="border-bottom pb-3 fw-semibold text-muted text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Cantidad</th>
                                    <th class="border-bottom pb-3 fw-semibold text-muted text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Subtotal</th>
                                    <th class="text-end pe-4 border-bottom pb-3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $item)
                                    <tr class="bg-white">
                                        <td class="ps-4 py-3 border-0">
                                            <div class="d-flex align-items-center">
                                                @if($item->product->hasImage())
                                                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="rounded-0 me-4 shadow-sm" style="width: 70px; height: 70px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded-0 me-4 d-flex align-items-center justify-content-center shadow-sm" style="width: 70px; height: 70px;">
                                                        <i class="bi bi-image text-muted fs-4"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h6 class="mb-1 fw-bold" style="color: #1C2833; font-family: 'Outfit', sans-serif; letter-spacing: 0.5px;">{{ $item->product->name }}</h6>
                                                    <small class="text-muted" style="font-size: 0.8rem;">{{ Str::limit($item->product->description, 40) }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="border-0 fw-medium text-muted">${{ number_format($item->product->price, 2) }}</td>
                                        <td class="border-0" style="width: 140px;">
                                            <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="input-group input-group-sm">
                                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control text-center rounded-0 border-end-0 shadow-none" style="border-color: #e2e8f0;">
                                                    <button class="btn btn-outline-secondary rounded-0 shadow-none" type="submit" style="border-color: #e2e8f0; background: #f8fafc;">
                                                        <i class="bi bi-arrow-repeat"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </td>
                                        <td class="border-0 fw-bold" style="color: #1C2833;">${{ number_format($item->total, 2) }}</td>
                                        <td class="text-end pe-4 border-0">
                                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-muted p-0" title="Eliminar" style="transition: color 0.2s;">
                                                    <i class="bi bi-x-lg"></i>
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
                <div class="card border-0 rounded-0 shadow-sm" style="background: #FCFCFC;">
                    <div class="card-body p-5">
                        <h5 class="card-title mb-4 fw-bold text-uppercase" style="font-family: 'Outfit', sans-serif; letter-spacing: 2px; font-size: 0.9rem; color: #1C2833;">Resumen de Pedido</h5>
                        
                        <div class="d-flex justify-content-between mb-3 pb-3 border-bottom border-light">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-medium">${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4 pb-3 border-bottom border-light">
                            <span class="text-muted">Envío</span>
                            <span class="text-uppercase fw-bold" style="color: #D4AF37; font-size: 0.8rem; letter-spacing: 1px;">Gratis</span>
                        </div>
                        <div class="d-flex justify-content-between mb-5">
                            <span class="h5 fw-light mb-0 text-uppercase" style="letter-spacing: 1px;">Total</span>
                            <span class="h4 fw-bold mb-0" style="color: #1C2833;">${{ number_format($total, 2) }}</span>
                        </div>
                        
                        <div id="payment-section" style="display: none;">
                            <h6 class="mb-3 text-uppercase text-muted fw-bold" style="font-size: 0.75rem; letter-spacing: 1px;">Método de Pago</h6>
                            <form action="{{ route('cart.checkout') }}" method="POST" id="checkout-form">
                                @csrf
                                <div class="mb-4">
                                    <div class="form-check payment-option p-3 border rounded-0 mb-2 bg-white" style="cursor: pointer; transition: all 0.2s;">
                                        <input class="form-check-input" type="radio" name="payment_method" id="pay_card" value="card" checked>
                                        <label class="form-check-label w-100 ms-2" for="pay_card" style="font-size: 0.9rem; color: #1C2833;">
                                            <i class="bi bi-credit-card me-2 text-muted"></i> Tarjeta de Crédito/Débito
                                        </label>
                                    </div>
                                    <div class="form-check payment-option p-3 border rounded-0 mb-2 bg-white" style="cursor: pointer; transition: all 0.2s;">
                                        <input class="form-check-input" type="radio" name="payment_method" id="pay_paypal" value="paypal">
                                        <label class="form-check-label w-100 ms-2" for="pay_paypal" style="font-size: 0.9rem; color: #1C2833;">
                                            <i class="bi bi-paypal me-2 text-muted"></i> PayPal
                                        </label>
                                    </div>
                                    <div class="form-check payment-option p-3 border rounded-0 mb-2 bg-white" style="cursor: pointer; transition: all 0.2s;">
                                        <input class="form-check-input" type="radio" name="payment_method" id="pay_oxxo" value="oxxo">
                                        <label class="form-check-label w-100 ms-2" for="pay_oxxo" style="font-size: 0.9rem; color: #1C2833;">
                                            <i class="bi bi-shop me-2 text-muted"></i> OXXO Pay
                                        </label>
                                    </div>
                                    <div class="form-check payment-option p-3 border rounded-0 mb-2 bg-white" style="cursor: pointer; transition: all 0.2s;">
                                        <input class="form-check-input" type="radio" name="payment_method" id="pay_transfer" value="transfer">
                                        <label class="form-check-label w-100 ms-2" for="pay_transfer" style="font-size: 0.9rem; color: #1C2833;">
                                            <i class="bi bi-bank me-2 text-muted"></i> Transferencia (SPEI)
                                        </label>
                                    </div>
                                </div>

                                <div id="card-details" class="payment-details mb-4">
                                    <div class="mb-2">
                                        <label class="text-uppercase text-muted fw-bold mb-2" style="font-size: 0.7rem; letter-spacing: 1px;">Número de tarjeta (Stripe)</label>
                                        <div id="stripe-card-element" class="form-control py-3 rounded-0 bg-white" style="border-color: #e2e8f0;">
                                            <!-- Stripe Element will be inserted here -->
                                        </div>
                                    </div>
                                    <div id="stripe-errors" class="text-danger small mt-2" role="alert"></div>
                                </div>

                                <div id="paypal-details" class="payment-details mb-4" style="display: none;">
                                    <div id="paypal-button-container"></div>
                                </div>

                                <div id="oxxo-details" class="payment-details mb-4" style="display: none;">
                                    <div class="alert bg-white border-0 shadow-sm small p-4 rounded-0" style="color: #64748b;">
                                        <i class="bi bi-info-circle me-2" style="color: #D4AF37;"></i> Se generará una ficha de pago para concluir en cualquier tienda OXXO.
                                    </div>
                                </div>

                                <div id="transfer-details" class="payment-details mb-4" style="display: none;">
                                    <div class="alert bg-white border-0 shadow-sm small p-4 rounded-0" style="color: #64748b;">
                                        <i class="bi bi-info-circle me-2" style="color: #D4AF37;"></i> Recibirás los datos CLABE para realizar tu transferencia electrónica.
                                    </div>
                                </div>

                                <button type="submit" id="confirm-payment-btn" class="btn text-white w-100 py-3 rounded-0 text-uppercase fw-bold shadow-sm" style="background-color: #1C2833; letter-spacing: 2px; font-size: 0.85rem; transition: all 0.3s;">
                                    Confirmar y Pagar
                                </button>
                            </form>
                        </div>

                        <button id="show-payment" class="btn text-white w-100 py-3 rounded-0 text-uppercase fw-bold shadow-sm mb-3" style="background-color: #1C2833; letter-spacing: 2px; font-size: 0.85rem; transition: all 0.3s;">
                            Proceder al pago
                        </button>
                        <a href="{{ route('home') }}" class="btn btn-outline-dark w-100 py-3 rounded-0 text-uppercase fw-bold" style="border-color: #e2e8f0; color: #64748b; letter-spacing: 2px; font-size: 0.85rem;">
                            Seguir comprando
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @push('styles')
        <style>
            .payment-option.active {
                border-color: #D4AF37 !important;
                background-color: #fffaf0 !important;
            }
            .btn-link:hover {
                color: #dc2626 !important;
            }
        </style>
        @endpush

        @push('scripts')
        <script src="https://js.stripe.com/v3/"></script>
        <script src="https://www.paypal.com/sdk/js?client-id={{ $paypalClientId ?? 'sb' }}&currency=MXN"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const showPaymentBtn = document.getElementById('show-payment');
                const paymentSection = document.getElementById('payment-section');
                const confirmBtn = document.getElementById('confirm-payment-btn');
                
                showPaymentBtn.addEventListener('click', function() {
                    paymentSection.style.display = 'block';
                    showPaymentBtn.style.display = 'none';
                    paymentSection.scrollIntoView({ behavior: 'smooth' });
                });

                // Stripe Initialization
                let stripe, elements, card;
                const stripeKey = '{{ $stripeKey }}';
                if (stripeKey && !stripeKey.includes('placeholder')) {
                    stripe = Stripe(stripeKey);
                    elements = stripe.elements();
                    card = elements.create('card', {
                        style: {
                            base: {
                                fontSize: '15px',
                                color: '#1C2833',
                                fontFamily: 'Nunito, sans-serif',
                                '::placeholder': {
                                    color: '#aab7c4',
                                },
                            },
                        }
                    });
                    card.mount('#stripe-card-element');
                } else {
                    document.getElementById('stripe-card-element').innerHTML = '<p class="text-muted small mb-0 px-3">Configura tu STRIPE_KEY en .env</p>';
                }

                // Initial PayPal state
                const paypalContainer = document.getElementById('paypal-details');

                // Toggle payment details
                const paymentOptions = document.querySelectorAll('.payment-option');
                
                // Initialize active class on first load
                document.querySelector('.payment-option input:checked').closest('.payment-option').classList.add('active');

                paymentOptions.forEach(option => {
                    option.addEventListener('click', function() {
                        const radio = this.querySelector('input[name="payment_method"]');
                        radio.checked = true;
                        radio.dispatchEvent(new Event('change'));
                    });
                });

                const radios = document.querySelectorAll('input[name="payment_method"]');
                radios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        document.querySelectorAll('.payment-details').forEach(el => el.style.display = 'none');
                        const detailsId = this.value + '-details';
                        const detailsEl = document.getElementById(detailsId);
                        if (detailsEl) detailsEl.style.display = 'block';

                        // Show/Hide default confirm button
                        if (this.value === 'paypal') {
                            confirmBtn.style.display = 'none';
                            initPayPal();
                        } else {
                            confirmBtn.style.display = 'block';
                        }
                    });
                });

                function initPayPal() {
                    if (window.paypal && !document.querySelector('#paypal-button-container iframe')) {
                        paypal.Buttons({
                            createOrder: function(data, actions) {
                                return actions.order.create({
                                    purchase_units: [{
                                        amount: {
                                            value: '{{ $total }}'
                                        }
                                    }]
                                });
                            },
                            onApprove: function(data, actions) {
                                return actions.order.capture().then(function(details) {
                                    const form = document.getElementById('checkout-form');
                                    const hiddenInput = document.createElement('input');
                                    hiddenInput.type = 'hidden';
                                    hiddenInput.name = 'paypal_order_id';
                                    hiddenInput.value = data.orderID;
                                    form.appendChild(hiddenInput);
                                    form.submit();
                                });
                            }
                        }).render('#paypal-button-container');
                    }
                }

                // Card payment and form submission
                const form = document.getElementById('checkout-form');
                form.addEventListener('submit', async function(e) {
                    const method = document.querySelector('input[name="payment_method"]:checked').value;
                    
                    if (method === 'card') {
                        if (stripe && card) {
                            e.preventDefault();
                            confirmBtn.disabled = true;
                            confirmBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Procesando...';
                            
                            const {paymentMethod, error} = await stripe.createPaymentMethod({
                                type: 'card',
                                card: card,
                            });

                            if (error) {
                                const errorElement = document.getElementById('stripe-errors');
                                errorElement.textContent = error.message;
                                confirmBtn.disabled = false;
                                confirmBtn.innerHTML = 'Confirmar y Pagar';
                            } else {
                                const hiddenInput = document.createElement('input');
                                hiddenInput.type = 'hidden';
                                hiddenInput.name = 'stripe_payment_id';
                                hiddenInput.value = paymentMethod.id;
                                form.appendChild(hiddenInput);
                                form.submit();
                            }
                        } else {
                            e.preventDefault();
                            alert('Stripe no está configurado correctamente.');
                        }
                    } else if (method === 'paypal') {
                        e.preventDefault(); // Handled by PayPal JS
                    }
                });

                // Style active option
                const options = document.querySelectorAll('.payment-option');
                options.forEach(opt => {
                    opt.addEventListener('click', function() {
                        options.forEach(o => o.classList.remove('active'));
                        this.classList.add('active');
                        this.querySelector('input').checked = true;
                        this.querySelector('input').dispatchEvent(new Event('change'));
                    });
                });
            });
        </script>
        @endpush
    @endif
</div>
@endsection
