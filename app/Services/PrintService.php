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
            $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH | Printer::MODE_DOUBLE_HEIGHT);
            $printer->text("ECOSKIN\n");
            $printer->selectPrintMode();
            $printer->text("NATURAL COSMETICS\n");
            $printer->feed();

            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("--------------------------------\n");
            $printer->text("FOLIO: #" . $order->order_number . "\n");
            $printer->text("FECHA: " . $order->created_at->format('d/m/Y H:i') . "\n");
            $printer->text("CLIENTE: " . auth()->user()->name . "\n");
            $printer->text("PAGO: " . strtoupper($order->payment_method) . "\n");
            $printer->text("--------------------------------\n");

            /* Items */
            $printer->setEmphasis(true);
            $printer->text(str_pad("DESCRIPCION", 18) . str_pad("CT", 4, " ", STR_PAD_LEFT) . str_pad("IMP", 10, " ", STR_PAD_LEFT) . "\n");
            $printer->setEmphasis(false);

            foreach ($order->items as $item) {
                $name = substr($item->product->name, 0, 17);
                $qty = $item->quantity;
                $total = number_format($item->price * $item->quantity, 2);
                
                $printer->text(str_pad($name, 18) . str_pad($qty, 4, " ", STR_PAD_LEFT) . str_pad("$" . $total, 10, " ", STR_PAD_LEFT) . "\n");
            }

            $printer->text("--------------------------------\n");
            
            /* Totals */
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer->text("TOTAL: $" . number_format($order->total, 2) . "\n");
            $printer->selectPrintMode();
            $printer->feed();

            /* Footer */
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("¡GRACIAS POR TU COMPRA!\n");
            $printer->text("www.ecoskin.test\n");
            
            /* Cut the paper */
            $printer->cut();
            $printer->close();

            return true;
        } catch (\Exception $e) {
            Log::error("Error al imprimir: " . $e->getMessage());
            return $e->getMessage();
        }
    }
}
