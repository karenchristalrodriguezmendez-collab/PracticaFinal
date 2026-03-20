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

<div class="ticket-digital-preview">
    <div class="preview-header no-print">
        <i class="bi bi-eye me-2"></i> Previsualización Digital del Comprobante
    </div>
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
                    <p>Tel: (55) 1234-5678</p>
                </div>
            </div>

            <div class="ticket-info-grid">
                <div class="info-item">
                    <span class="label">FOLIO</span>
                    <span class="value">#{{ $orderNumber }}</span>
                </div>
                <div class="info-item">
                    <span class="label">FECHA</span>
                    <span class="value">{{ $date }}</span>
                </div>
                <div class="info-item">
                    <span class="label">MÉTODO</span>
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
                            <th class="text-start">PRODUCTO</th>
                            <th class="text-center">CT</th>
                            <th class="text-end">TOTAL</th>
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
                                    <div class="item-unit-price">${{ number_format($itemPrice, 2) }}</div>
                                </td>
                                <td class="text-center">{{ $qty }}</td>
                                <td class="text-end fw-bold">${{ number_format($itemTotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="totals-section">
                <div class="total-row main-total">
                    <span class="total-label">TOTAL</span>
                    <span class="total-value">${{ number_format($total, 2) }}</span>
                </div>
                @if($reference)
                    <div class="reference-box mt-2">
                        <span class="label">REF:</span>
                        <span class="value">{{ $reference }}</span>
                    </div>
                @endif
            </div>

            <div class="ticket-footer">
                <div class="qr-code-area">
                    <svg width="40" height="40" viewBox="0 0 100 100" class="qr-svg">
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
                    <p class="main-thanks text-uppercase">¡Gracias por tu compra!</p>
                    <p>Visítanos en www.ecoskin.test</p>
                    <p class="legal-disclaimer">Documento sin valor fiscal</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* CSS for Screen Display */
    .ticket-digital-preview {
        max-width: 58mm;
        margin: 20px auto;
        padding: 10px;
        background: #f0f2f0;
        border-radius: 8px;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
    }

    .preview-header {
        font-size: 0.7rem;
        text-align: center;
        color: #58624A;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 10px;
        letter-spacing: 0.5px;
    }

    #payment-ticket {
        display: block;
        background: #fff;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        margin: 0 auto;
        position: relative;
        overflow: hidden;
    }

    .ticket-container {
        font-family: 'Courier New', Courier, monospace; /* Thermal printer feel */
        color: #000;
        line-height: 1.2;
    }

    .ticket-wrapper {
        width: 58mm;
        padding: 4mm;
        box-sizing: border-box;
    }

    .ticket-header { text-align: center; margin-bottom: 15px; border-bottom: 1px dashed #000; padding-bottom: 10px; }
    .brand-title { font-size: 16pt; font-weight: bold; margin: 0; }
    .brand-subtitle { font-size: 7pt; margin: 0; letter-spacing: 1px; }
    .premium-badge { border: 1px solid #000; display: inline-block; font-size: 6pt; padding: 0 5px; margin-bottom: 5px; }
    .merchant-details { font-size: 7pt; margin-top: 5px; }

    .ticket-info-grid { border-bottom: 1px dashed #000; margin-bottom: 10px; padding-bottom: 10px; }
    .info-item { display: flex; justify-content: space-between; font-size: 8pt; margin-bottom: 2px; }
    .info-item .label { font-weight: bold; }

    .items-table { width: 100%; border-collapse: collapse; font-size: 8pt; margin-bottom: 10px; }
    .items-table th { border-bottom: 1px solid #000; padding: 2px 0; }
    .items-table td { padding: 4px 0; border-bottom: 1px dotted #ccc; }
    .item-name { font-weight: bold; }
    .item-unit-price { font-size: 7pt; color: #555; }

    .main-total { border-top: 2px solid #000; border-bottom: 2px solid #000; padding: 5px 0; display: flex; justify-content: space-between; align-items: center; }
    .total-label { font-size: 10pt; font-weight: bold; }
    .total-value { font-size: 12pt; font-weight: bold; }

    .status-stamp {
        position: absolute;
        top: 20%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-20deg);
        border: 3px double #000;
        padding: 5px 15px;
        font-size: 14pt;
        font-weight: bold;
        opacity: 0.1;
        pointer-events: none;
    }

    .ticket-footer { text-align: center; margin-top: 15px; }
    .thanks-msg { font-size: 8pt; margin-top: 10px; }
    .legal-disclaimer { font-size: 6pt; font-style: italic; opacity: 0.7; }

    /* Print Specific Overrides */
    @media print {
        @page { size: 58mm auto; margin: 0; }
        
        body { 
            background: #fff !important; 
            margin: 0 !important; 
            padding: 0 !important; 
        }

        /* Ocultar elementos de layout principales para que no ocupen espacio (evita páginas extra) */
        .top-bar, header, nav, .newsletter-section, footer, .footer-bottom, .container, .no-print {
            display: none !important;
        }
        
        .ticket-digital-preview {
            margin: 0 !important;
            padding: 0 !important;
            background: transparent !important;
            box-shadow: none !important;
            max-width: none !important;
        }

        #payment-ticket {
            position: relative !important;
            width: 58mm !important;
            margin: 0 auto !important;
            padding: 0 !important;
            box-shadow: none !important;
            border: none !important;
        }

        .ticket-wrapper {
            width: 58mm !important;
            padding: 0mm 2mm !important;
            box-sizing: border-box !important;
        }


        /* Essential resets for fonts and clarity */
        .ticket-container { 
            font-size: 8pt !important; 
            color: #000 !important; 
            font-family: 'Courier New', Courier, monospace !important;
        }

        .no-print { display: none !important; }
        
        /* Force background for the stamp */
        .status-stamp { opacity: 0.1 !important; color: #000 !important; }
    }
</style>
