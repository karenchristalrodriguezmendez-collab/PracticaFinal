<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\PrintService;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    protected $printService;

    public function __construct(PrintService $printService)
    {
        $this->printService = $printService;
    }

    public function printTicket(Order $order)
    {
        // Verificar que el pedido pertenezca al usuario (opcional si es admin)
        if ($order->user_id !== auth()->id() && !auth()->user()->hasRole('admin')) {
            return response()->json(['success' => false, 'message' => 'No autorizado'], 403);
        }

        $result = $this->printService->printOrder($order);

        if ($result === true) {
            return response()->json(['success' => true, 'message' => 'Ticket enviado a la impresora']);
        } else {
            return response()->json(['success' => false, 'message' => 'Error al imprimir: ' . $result], 500);
        }
    }
}
