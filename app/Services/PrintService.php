<?php

namespace App\Services;

use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\CapabilityProfile;
use Illuminate\Support\Facades\Log;

class PrintService
{
    protected $printerName;

    public function __construct()
    {
        $this->printerName = config('printing.printer_name', 'EPSON_58MM');
    }

    public function printOrder($order)
    {
        try {
            $connector = new WindowsPrintConnector($this->printerName);
            $printer = new Printer($connector);

            /* Initialize */
            $printer->initialize();
            
            /* Header */
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("OFFICIAL RECEIPT\n");
            $printer->text("================================\n");
            $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH | Printer::MODE_DOUBLE_HEIGHT);
            $printer->text("ECOSKIN\n");
            $printer->selectPrintMode();
            $printer->text("NATURAL COSMETICS\n");
            $printer->text("EcoSkin Cosmetics S.A. de C.V.\n");
            $printer->text("Calle Falsa 123, CDMX\n");
            $printer->text("--------------------------------\n");
            $printer->feed();

            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("FOLIO: #" . $order->order_number . "\n");
            $printer->text("FECHA: " . $order->created_at->format('d/m/Y H:i') . "\n");
            $customerName = substr(auth()->user()->name, 0, 23);
            $printer->text("CLIENTE: " . $customerName . "\n");
            $printer->text("PAGO: " . strtoupper($order->payment_method) . "\n");
            $printer->text("--------------------------------\n");

            /* Items */
            $printer->setEmphasis(true);
            $printer->text(str_pad("DESCRIPCION", 14) . str_pad("CT", 4, " ", STR_PAD_LEFT) . str_pad("IMPORTE", 14, " ", STR_PAD_LEFT) . "\n");
            $printer->setEmphasis(false);
            $printer->text("--------------------------------\n");

            foreach ($order->items as $item) {
                $name = substr($item->product->name, 0, 32);
                $qty = $item->quantity;
                $total = number_format($item->price * $item->quantity, 2);
                
                $printer->text($name . "\n");
                $printer->text(str_pad("", 14) . str_pad("x" . $qty, 4, " ", STR_PAD_LEFT) . str_pad("$" . $total, 14, " ", STR_PAD_LEFT) . "\n");
            }

            $printer->text("--------------------------------\n");
            
            /* Totals */
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text("SUBTOTAL: $" . number_format($order->total, 2) . "\n");
            $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer->text("TOTAL: $" . number_format($order->total, 2) . "\n");
            $printer->selectPrintMode();
            $printer->feed();

            /* Footer */
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("--------------------------------\n");
            $printer->text("¡GRACIAS POR TU COMPRA!\n");
            $printer->text("Nuestros productos son 100% orgánicos\n");
            $printer->text("www.ecoskin.test\n");
            $printer->feed(2);
            
            /* Cut the paper */
            $printer->cut();
            $printer->close();

            return true;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            Log::error("Error al imprimir en {$this->printerName}: " . $message);
            
            if (strpos($message, 'Could not print to') !== false || strpos($message, 'not found') !== false) {
                return "La impresora '{$this->printerName}' no está conectada o no se encuentra disponible. Por favor, verifica que esté encendida y conectada correctamente.";
            }
            
            return "Error técnico al intentar imprimir: " . $message;
        }
    }
}
