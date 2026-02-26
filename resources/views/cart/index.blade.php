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
                        
                        <div id="payment-section" style="display: none;">
                            <h6 class="mb-3">Método de Pago</h6>
                            <form action="{{ route('cart.checkout') }}" method="POST" id="checkout-form">
                                @csrf
                                <div class="mb-3">
                                    <div class="form-check payment-option p-3 border rounded mb-2" style="cursor: pointer;">
                                        <input class="form-check-input" type="radio" name="payment_method" id="pay_card" value="card" checked>
                                        <label class="form-check-label w-100" for="pay_card">
                                            <i class="bi bi-credit-card me-2"></i> Tarjeta de Crédito/Débito
                                        </label>
                                    </div>
                                    <div class="form-check payment-option p-3 border rounded mb-2" style="cursor: pointer;">
                                        <input class="form-check-input" type="radio" name="payment_method" id="pay_paypal" value="paypal">
                                        <label class="form-check-label w-100" for="pay_paypal">
                                            <i class="bi bi-paypal me-2"></i> PayPal
                                        </label>
                                    </div>
                                    <div class="form-check payment-option p-3 border rounded mb-2" style="cursor: pointer;">
                                        <input class="form-check-input" type="radio" name="payment_method" id="pay_oxxo" value="oxxo">
                                        <label class="form-check-label w-100" for="pay_oxxo">
                                            <i class="bi bi-shop me-2"></i> OXXO Pay
                                        </label>
                                    </div>
                                    <div class="form-check payment-option p-3 border rounded mb-2" style="cursor: pointer;">
                                        <input class="form-check-input" type="radio" name="payment_method" id="pay_transfer" value="transfer">
                                        <label class="form-check-label w-100" for="pay_transfer">
                                            <i class="bi bi-bank me-2"></i> Transferencia (SPEI)
                                        </label>
                                    </div>
                                </div>

                                <div id="card-details" class="payment-details mb-3">
                                    <div class="mb-2">
                                        <label class="small text-muted">Número de tarjeta (Stripe)</label>
                                        <div id="stripe-card-element" class="form-control py-2">
                                            <!-- Stripe Element will be inserted here -->
                                        </div>
                                    </div>
                                    <div id="stripe-errors" class="text-danger small mt-1" role="alert"></div>
                                </div>

                                <div id="paypal-details" class="payment-details mb-3" style="display: none;">
                                    <div id="paypal-button-container"></div>
                                </div>

                                <div id="oxxo-details" class="payment-details mb-3" style="display: none;">
                                    <div class="alert alert-light border small">
                                        Se generará una ficha de pago para concluir en cualquier tienda OXXO.
                                    </div>
                                </div>

                                <div id="transfer-details" class="payment-details mb-3" style="display: none;">
                                    <div class="alert alert-light border small">
                                        Recibirás los datos CLABE para realizar tu transferencia electrónica.
                                    </div>
                                </div>

                                <button type="submit" id="confirm-payment-btn" class="btn btn-success w-100 py-2 rounded-pill mb-2">
                                    Confirmar y Pagar
                                </button>
                            </form>
                        </div>

                        <button id="show-payment" class="btn btn-primary w-100 py-2 rounded-pill mb-2">Proceder al pago</button>
                        <a href="{{ url('/') }}" class="btn btn-outline-secondary w-100 py-2 rounded-pill">Seguir comprando</a>
                    </div>
                </div>
            </div>
        </div>

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
                                fontSize: '16px',
                                color: '#32325d',
                            },
                        }
                    });
                    card.mount('#stripe-card-element');
                } else {
                    document.getElementById('stripe-card-element').innerHTML = '<p class="text-muted small mb-0">Configura tu STRIPE_KEY en .env</p>';
                }

                // Initial PayPal state: hidden because Card is default
                const paypalContainer = document.getElementById('paypal-details');

                // Toggle payment details
                const paymentOptions = document.querySelectorAll('.payment-option');
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
                                    // Submit the form with bypass for PayPal
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
                            
                            const {paymentMethod, error} = await stripe.createPaymentMethod({
                                type: 'card',
                                card: card,
                            });

                            if (error) {
                                const errorElement = document.getElementById('stripe-errors');
                                errorElement.textContent = error.message;
                                confirmBtn.disabled = false;
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
                    // For oxxo and transfer, the form submits normally
                });

                // Style active option
                const options = document.querySelectorAll('.payment-option');
                options.forEach(opt => {
                    opt.addEventListener('click', function() {
                        options.forEach(o => o.classList.remove('border-primary', 'bg-light'));
                        this.classList.add('border-primary', 'bg-light');
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
