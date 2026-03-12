@props(['order', 'items' => null])

@php
    $order = (object) $order;
    $total = $order->total ?? 0;
    $orderNumber = $order->order_number ?? ($order->orderNumber ?? 'N/A');
    $date = isset($order->created_at) && $order->created_at instanceof \DateTimeInterface 
        ? $order->created_at->format('d/m/Y H:i') 
        : now()->format('d/m/Y H:i');
    $paymentMethod = $order->payment_method ?? ($order->paymentMethod ?? 'N/A');
    $reference = $order->reference ?? null;
    $orderItems = $items ?? ($order->items ?? []);
@endphp

<div id="payment-ticket" class="ticket-container">
    <div class="ticket-wrapper">
        <div class="ticket-header">
            <div class="premium-badge">OFFICIAL RECEIPT</div>
            <div class="logo-area">
                <h1 class="brand-title">ECOSKIN</h1>
                <p class="brand-subtitle">NATURAL COSMETICS</p>
            </div>
            
            <div class="status-stamp">PAGADO</div>

            <div class="merchant-details">
                <p><strong>EcoSkin Cosmetics S.A. de C.V.</strong></p>
                <p>RFC: EKC2026M0311</p>
                <p>Calle Falsa 123, Col. Roma Norte</p>
                <p>Alcaldía Cuauhtémoc, CDMX, 06700</p>
                <p>Tel: (55) 1234-5678 | www.ecoskin.test</p>
            </div>
        </div>

        <div class="ticket-info-grid">
            <div class="info-item">
                <span class="label">FOLIO DE VENTA</span>
                <span class="value">#{{ $orderNumber }}</span>
            </div>
            <div class="info-item">
                <span class="label">FECHA Y HORA</span>
                <span class="value">{{ $date }}</span>
            </div>
            <div class="info-item">
                <span class="label">MÉTODO DE PAGO</span>
                <span class="value text-uppercase">{{ $paymentMethod }}</span>
            </div>
            <div class="info-item">
                <span class="label">CLIENTE</span>
                <span class="value">{{ auth()->user()->name }}</span>
            </div>
        </div>

        <div class="items-section">
            <table class="items-table">
                <thead>
                    <tr>
                        <th class="text-start">DESCRIPCIÓN</th>
                        <th class="text-center">CANT</th>
                        <th class="text-end">IMPORTE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orderItems as $item)
                        @php
                            $name = is_array($item) ? $item['name'] : $item->product->name;
                            $qty = is_array($item) ? $item['quantity'] : $item->quantity;
                            $itemPrice = is_array($item) ? $item['price'] : $item->price;
                            $itemTotal = is_array($item) ? $item['total'] : ($item->price * $item->quantity);
                        @endphp
                        <tr>
                            <td class="text-start">
                                <div class="item-name">{{ $name }}</div>
                                <div class="item-unit-price">${{ number_format($itemPrice, 2) }} c/u</div>
                            </td>
                            <td class="text-center">{{ $qty }}</td>
                            <td class="text-end fw-bold">${{ number_format($itemTotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="totals-section">
            @if($reference)
                <div class="reference-box">
                    <span class="label">REFERENCIA DE PAGO:</span>
                    <span class="value">{{ $reference }}</span>
                </div>
            @endif
            
            <div class="total-row main-total">
                <span class="total-label">TOTAL A PAGAR</span>
                <span class="total-value">${{ number_format($total, 2) }} <small>MXN</small></span>
            </div>
        </div>

        <div class="ticket-footer">
            <div class="qr-code-area">
                <svg width="80" height="80" viewBox="0 0 100 100" class="qr-svg">
                    <rect width="100" height="100" fill="none" stroke="#000" stroke-width="0.5"/>
                    <rect x="10" y="10" width="20" height="20" fill="#000"/>
                    <rect x="70" y="10" width="20" height="20" fill="#000"/>
                    <rect x="10" y="70" width="20" height="20" fill="#000"/>
                    <rect x="40" y="40" width="20" height="20" fill="#000"/>
                    <rect x="15" y="15" width="10" height="10" fill="#fff"/>
                    <rect x="75" y="15" width="10" height="10" fill="#fff"/>
                    <rect x="15" y="75" width="10" height="10" fill="#fff"/>
                </svg>
            </div>
            <div class="thanks-msg">
                <p class="main-thanks">¡GRACIAS POR TU COMPRA!</p>
                <p>NUESTROS PRODUCTOS SON 100% ORGÁNICOS Y CRUELTY-FREE</p>
                <div class="footer-divider"></div>
                <p class="legal-disclaimer">ESTO NO ES UNA FACTURA FISCAL. PUEDES SOLICITAR TU FACTURA EN NUESTRO SITIO WEB CON TU FOLIO DE VENTA.</p>
            </div>
        </div>
    </div>
</div>

<style>
    /* CSS for Screen Display (Hidden by default) */
    #payment-ticket {
        display: none;
    }

    /* Styles common to both (but mainly for print structure) */
    .ticket-container {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        color: #1a1a1a;
        background: #fff;
    }

    .ticket-wrapper {
        width: 58mm;
        margin: 0 auto;
        padding: 4mm;
        box-sizing: border-box;
    }

    .ticket-header {
        text-align: center;
        position: relative;
        margin-bottom: 15px;
    }

    .premium-badge {
        display: inline-block;
        font-size: 6pt;
        font-weight: 800;
        letter-spacing: 1.5px;
        border: 1px solid #1a1a1a;
        padding: 1px 6px;
        margin-bottom: 8px;
    }

    .brand-title {
        font-size: 18pt;
        font-weight: 900;
        margin: 0;
        letter-spacing: 2px;
    }

    .brand-subtitle {
        font-size: 6.5pt;
        letter-spacing: 3px;
        margin: 0 0 10px 0;
        opacity: 0.8;
    }

    .status-stamp {
        position: absolute;
        top: 15px;
        right: -5px;
        border: 2px solid #1a1a1a;
        color: #1a1a1a;
        font-size: 11pt;
        font-weight: 900;
        padding: 3px 10px;
        transform: rotate(15deg);
        opacity: 0.2;
        pointer-events: none;
        letter-spacing: 1px;
    }

    .merchant-details {
        font-size: 7pt;
        line-height: 1.3;
        margin-top: 8px;
    }

    .merchant-details p { margin: 0; }

    .ticket-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        border-top: 1px solid #eee;
        border-bottom: 1px solid #eee;
        padding: 10px 0;
        margin-bottom: 10px;
    }

    .info-item {
        display: flex;
        flex-direction: column;
    }

    .info-item .label {
        font-size: 5.5pt;
        font-weight: 700;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .info-item .value {
        font-size: 8pt;
        font-weight: 600;
    }

    .items-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
    }

    .items-table th {
        font-size: 6.5pt;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #666;
        border-bottom: 1px solid #1a1a1a;
        padding-bottom: 3px;
    }

    .items-table td {
        padding: 6px 0;
        font-size: 8pt;
        border-bottom: 1px dashed #eee;
        vertical-align: top;
    }

    .item-name {
        font-weight: 600;
        text-transform: uppercase;
        line-height: 1.1;
    }

    .item-unit-price {
        font-size: 6.5pt;
        color: #888;
    }

    .totals-section {
        margin-top: 8px;
        padding-top: 8px;
    }

    .reference-box {
        background: #f9f9f9;
        padding: 6px;
        text-align: center;
        margin-bottom: 8px;
        border-radius: 4px;
    }

    .reference-box .label { font-size: 5.5pt; display: block; color: #666; }
    .reference-box .value { font-size: 9pt; font-weight: 800; }

    .total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
    }

    .main-total {
        border-top: 1.5px solid #1a1a1a;
        border-bottom: 1.5px solid #1a1a1a;
        margin-top: 4px;
    }

    .total-label {
        font-size: 9pt;
        font-weight: 800;
    }

    .total-value {
        font-size: 14pt;
        font-weight: 900;
    }

    .total-value small { font-size: 7pt; }

    .ticket-footer {
        text-align: center;
        margin-top: 20px;
    }

    .qr-code-area { margin-bottom: 12px; }
    .qr-svg { width: 60px; height: 60px; }

    .thanks-msg { font-size: 6.5pt; line-height: 1.3; color: #444; }
    .main-thanks { font-size: 9pt; font-weight: 800; color: #1a1a1a; margin-bottom: 3px; }
    .footer-divider { height: 1px; background: #eee; margin: 8px 0; }
    .legal-disclaimer { font-size: 5.5pt; opacity: 0.6; font-style: italic; }

    /* Print Specific Overrides */
    @media print {
        @page {
            size: 58mm auto;
            margin: 0;
        }

        /* Essential reset to remove vertical space */
        html, body {
            background: #fff !important;
            margin: 0 !important;
            padding: 0 !important;
            height: auto !important;
            min-height: 0 !important;
            width: 58mm !important;
            overflow: visible !important;
        }

        /* Hide all layout noise and containers */
        .top-bar, 
        header, 
        nav, 
        .newsletter-section, 
        footer, 
        .footer-main, 
        .footer-bottom,
        .container,
        .btn,
        .no-print,
        #app > section,
        #app > footer {
            display: none !important;
            height: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow: hidden !important;
        }

        /* Reset parent structures to not hold height */
        #app, main {
            display: block !important;
            margin: 0 !important;
            padding: 0 !important;
            height: auto !important;
            min-height: 0 !important;
        }

        #payment-ticket {
            display: block !important;
            visibility: visible !important;
            position: relative !important; /* Changed to relative to define page height */
            width: 58mm !important;
            margin: 0 !important;
            padding: 4mm !important;
            background: #fff !important;
            color: #000 !important;
            box-shadow: none !important;
            border: none !important;
            z-index: 1;
        }

        #payment-ticket * {
            visibility: visible !important;
        }

        /* Ensure fonts and colors are perfect for black/white printers */
        .ticket-wrapper {
            border: none !important;
            box-shadow: none !important;
            color: #000 !important;
            width: 100% !important;
            padding: 0 !important;
        }

        .status-stamp {
            opacity: 0.15 !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
    }
</style>
